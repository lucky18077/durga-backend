<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Jenssegers\Agent\Agent;

class LoginController extends Controller
{

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Mobile number is required',
                'errors' => $validator->errors()
            ], 422);
        }
        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Mobile number is required',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = DB::table("customer_users as a")
            ->select("a.*", "b.active", "b.supplier_id")
            ->join("customers as b", "a.customer_id", "b.id")
            ->where("a.number", $request->number)
            ->first();

        if (!$user) {
            $customerId = DB::table('customers')->insertGetId([
                'name' => 'Guest User',
                'active' => 0,
                'number' => $request->number,
                'supplier_id' => 0,
            ]);

            $userId = DB::table('customer_users')->insertGetId([
                'customer_id' => $customerId,
                'number' => $request->number,
                'name' => 'Guest User',
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Please complete signup',
                'redirect' => 'signup'
            ], 200);
        }

        if ($user->active == 2) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is under process. Please wait 2-4 hours.',
                'redirect' => 'pending'
            ], 200);
        }

        if ($user->active == 0 && $user->supplier_id == 0) {
            return response()->json([
                'status' => false,
                'message' => 'You need to signup first',
                'redirect' => 'signup'
            ], 200);
        }

        if ($user->active == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is inactive. Please contact supplier.',
                'redirect' => 'inactive'
            ], 200);
        }

        $token = bin2hex(random_bytes(16));
        $agent = new Agent();
        $browser = $agent->browser();
        $version = $agent->version($browser);
        $platform = $agent->platform();

        DB::table('customer_users')->where("id", $user->id)->update([
            'web_token' => $token,
            'last_ip' => $request->ip(),
            'last_login' => now(),
            'platform' => "$browser / $version / $platform"
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
            'redirect' => 'home'
        ], 200);
    }


    public function saveCustomerApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|digits:10',
            'name' => 'required',
            'company_name' => 'required',
            'company_number' => 'required',
            'customer_type' => 'required',
            'type' => 'required',
            'supplier_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        DB::beginTransaction();
        try {
            $customer = DB::table("customers")->where("number", $request->number)->first();
            if ($customer) {
                DB::table('customers')->where("id", $customer->id)->update([
                    "customer_type" => $request->customer_type,
                    "type" => $request->type,
                    "name" => $request->company_name,
                    "number" => $request->company_number,
                    "email" => $request->company_email,
                    "gst" => $request->company_gst,
                    "address" => $request->company_address,
                    "state" => $request->company_state,
                    "city" => $request->company_city,
                    "district" => $request->company_district,
                    "pincode" => $request->company_pincode,
                    "supplier_id" => $request->supplier_id,
                    "active" => 2,
                ]);
                DB::table('customer_users')->where("customer_id", $customer->id)->update([
                    "name" => $request->name,
                    "number" => $request->number,
                    "email" => $request->email,
                    "password" => $request->password,
                    "address" => $request->address,
                    "state" => $request->state,
                    "city" => $request->city,
                    "district" => $request->district,
                    "pincode" => $request->pincode,
                ]);
                $customer_id = $customer->id;
                $documents = DB::table('documents')->where('type', $request->type)->get();
                if ($documents->isNotEmpty()) {
                    $customerDocuments = $documents->map(function ($doc) use ($customer_id) {
                        return [
                            'customer_id' => $customer_id,
                            'type'        => $doc->type,
                            'name'        => $doc->name,
                        ];
                    })->toArray();
                    DB::table('customer_document')->insert($customerDocuments);
                }
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Your Account Under Process By Supplier Please Wait 2-3Hrs',
                    'customer_id' => $customer_id
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Number not exists or try after sometime',

                ], 422);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function customerLoginApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Number and password are required',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = DB::table("customer_users as a")
                ->select("a.*", "b.active")
                ->join("customers as b", "a.customer_id", "b.id")
                ->where("a.number", $request->number)
                ->where("a.password", $request->password)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Incorrect number or password or inactive account'
                ], 401);
            }

            if ($user->active == 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your request is pending. Please contact your supplier.'
                ], 403);
            }

            if ($user->active == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is inactive. Please contact your supplier.'
                ], 403);
            }
            $token = bin2hex(random_bytes(16));
            $agent = new Agent();
            $browser = $agent->browser();
            $version = $agent->version($browser);
            $platform = $agent->platform();
            DB::table('customer_users')->where("id", $user->id)->update([
                'web_token' => $token,
                'last_ip' => $request->ip(),
                'last_login' => now(),
                'platform' => "$browser / $version / $platform"
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error: ' . $th->getMessage()
            ], 500);
        }
    }
}
