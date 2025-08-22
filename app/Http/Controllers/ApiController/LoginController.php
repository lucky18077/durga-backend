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

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|string',           // user mobile number
            'firebase_token' => 'required|string',   // token received from Firebase OTP verification
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Number and OTP token are required',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Initialize Firebase
            $factory = (new Factory)->withServiceAccount(config('firebase.credentials_file'));
            $auth = $factory->createAuth();

            // Verify the Firebase token sent from mobile
            $verifiedIdToken = $auth->verifyIdToken($request->firebase_token);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');

            // Fetch user by mobile number
            $user = DB::table('customer_users as a')
                ->select('a.*', 'b.active')
                ->join('customers as b', 'a.customer_id', 'b.id')
                ->where('a.number', $request->number)
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or inactive account'
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

            // Generate session token
            $token = bin2hex(random_bytes(16));
            $agent = new Agent();

            DB::table('customer_users')->where('id', $user->id)->update([
                'web_token' => $token,
                'last_ip' => $request->ip(),
                'last_login' => now(),
                'platform' => $agent->platform() . ' / ' . $agent->browser() . ' ' . $agent->version($agent->browser())
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Kreait\Firebase\Exception\Auth\FailedToVerifyToken $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP token'
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Server error: ' . $th->getMessage()
            ], 500);
        }
    }


    public function saveCustomerApi(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'number' => 'required|digits:10',
            'name' => 'required',
            'password' => 'required',
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

        try {
            DB::beginTransaction();

            // Insert into customers table
            $customer_id = DB::table('customers')->insertGetId([
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

            // Insert into customer_users table
            DB::table('customer_users')->insert([
                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
                "address" => $request->address,
                "state" => $request->state,
                "city" => $request->city,
                "district" => $request->district,
                "pincode" => $request->pincode,
                "password" => $request->password,
                "customer_id" => $customer_id,
            ]);

            // Insert documents if applicable
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
                'message' => 'Customer saved successfully',
                'customer_id' => $customer_id
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // public function customerLoginApi(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'number' => 'required',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Number and password are required',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     try {
    //         $user = DB::table("customer_users as a")
    //             ->select("a.*", "b.active")
    //             ->join("customers as b", "a.customer_id", "b.id")
    //             ->where("a.number", $request->number)
    //             ->where("a.password", $request->password)
    //             ->first();

    //         if (!$user) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Incorrect number or password or inactive account'
    //             ], 401);
    //         }

    //         if ($user->active == 2) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Your request is pending. Please contact your supplier.'
    //             ], 403);
    //         }

    //         if ($user->active == 0) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Your account is inactive. Please contact your supplier.'
    //             ], 403);
    //         }
    //         $token = bin2hex(random_bytes(16));
    //         $agent = new Agent();
    //         $browser = $agent->browser();
    //         $version = $agent->version($browser);
    //         $platform = $agent->platform();
    //         DB::table('customer_users')->where("id", $user->id)->update([
    //             'web_token' => $token,
    //             'last_ip' => $request->ip(),
    //             'last_login' => now(),
    //             'platform' => "$browser / $version / $platform"
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Login successful',
    //             'token' => $token,
    //             'user' => $user
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Server error: ' . $th->getMessage()
    //         ], 500);
    //     }
    // }
}
