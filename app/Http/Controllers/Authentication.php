<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Jenssegers\Agent\Agent;

class Authentication extends Controller
{

    // admin login
    public function SuperAdmin()
    {
        if (!empty(session("token"))) {
            $superAdmin =   DB::table("users")->where("token", session("token"))->first();
            if (!empty($superAdmin)) {

                return redirect("s1/dashboard");
            }
        }

        return view("admin.index");
    }

    public function SuperAdminLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash("error", "Enter email or password");
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $superAdmin =   DB::table("users")->where("email", $request->email)->where("password", $request->password)->first();
            if (!empty($superAdmin)) {
                $token = bin2hex(random_bytes(16));
                $agent = new Agent();
                $browser = $agent->browser();
                $version = $agent->version($browser);
                $platform = $agent->platform();
                DB::table('users')->where("id", $superAdmin->id)->update(array(
                    'token' => $token,
                    "last_ip" => $_SERVER['REMOTE_ADDR'],
                    'last_login' => date("Y-m-d H:m:s"),
                    'platform' => $browser . " / " . $version . ' / ' . $platform,
                ));
                session()->put('token', $token);
                session()->put('user', $superAdmin);
                session()->save();
            } else {
                return redirect()->back()->with('error', "Incorrect Username or Password");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        session()->flash('success', "login successfully");

        return redirect("s1/dashboard");
    }


    public function logout(Request $request)
    {

        DB::table('users')->where("token", session("token"))->update(array(
            'token' => "",

        ));
        return redirect("s1/")->with("success", "logout successfully");
    }

    // supplier login

    public function SupplierLogin()
    {
        if (!empty(session("supplier_token"))) {
            $superAdmin =   DB::table("supplier_users")->where("token", session("supplier_token"))->first();
            if (!empty($superAdmin)) {

                return redirect("supplier/dashboard");
            }
        }

        return view("suppliers.index");
    }

    public function SaveSupplierLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash("error", "Enter number or password");
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $superAdmin =   DB::table("supplier_users")->where("number", $request->number)->where("password", $request->password)->first();
            if (!empty($superAdmin)) {
                $token = bin2hex(random_bytes(16));
                $agent = new Agent();
                $browser = $agent->browser();
                $version = $agent->version($browser);
                $platform = $agent->platform();
                DB::table('supplier_users')->where("id", $superAdmin->id)->update(array(
                    'token' => $token,
                    "last_ip" => $_SERVER['REMOTE_ADDR'],
                    'last_login' => date("Y-m-d H:m:s"),
                    'platform' => $browser . " / " . $version . ' / ' . $platform,
                ));
                session()->put('supplier_token', $token);
                session()->put('supplier', $superAdmin);
                session()->save();
            } else {
                return redirect()->back()->with('error', "Incorrect number or Password");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        session()->flash('success', "login successfully");

        return redirect("supplier/dashboard");
    }


    // customer login panel

    public function CustomerLogin()
    {
        if (!empty(session("customer_token"))) {
            $superAdmin =   DB::table("customer_users")->where("token", session("customer_token"))->first();
            if (!empty($superAdmin)) {

                return redirect("customer/dashboard");
            }
        }

        return view("customers.index");
    }
    public function SaveCustomerLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash("error", "Enter number or password");
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $superAdmin =   DB::table("customer_users as a")->select("a.*")->join("customers as b", "a.customer_id", "b.id")->where("a.number", $request->number)->where("a.password", $request->password)->where("b.active", 1)->first();
            if (!empty($superAdmin)) {
                $token = bin2hex(random_bytes(16));
                $agent = new Agent();
                $browser = $agent->browser();
                $version = $agent->version($browser);
                $platform = $agent->platform();
                DB::table('customer_users')->where("id", $superAdmin->id)->update(array(
                    'token' => $token,
                    "last_ip" => $_SERVER['REMOTE_ADDR'],
                    'last_login' => date("Y-m-d H:m:s"),
                    'platform' => $browser . " / " . $version . ' / ' . $platform,
                ));

                session()->put('customer_token', $token);
                session()->put('customer', $superAdmin);
                session()->save();
            } else {
                return redirect()->back()->with('error', "Incorrect number or Password");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        session()->flash('success', "login successfully");

        return redirect("customer/dashboard");
    }

    public function CustomerLogout(Request $request)
    {
        DB::table('customer_users')->where("token", session("customer_token"))->update(array(
            'token' => "",

        ));
        return redirect("customer/")->with("success", "logout successfully");
    }

    // customer login website

    public function customerLoginWebsite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash("error", "Enter number or password");
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $superAdmin =   DB::table("customer_users as a")
                ->select("a.*", "b.active")
                ->join("customers as b", "a.customer_id", "b.id")
                ->where("a.number", $request->number)
                ->where("a.password", $request->password)
                ->first();
            if (!empty($superAdmin)) {

                if ($superAdmin->active == 2) {
                    return redirect()->back()->with("error", "You request is pending contact to supplier");
                }
                if ($superAdmin->active == 0) {
                    return redirect()->back()->with("error", "You are Inactive contact to supplier");
                }

                $token = bin2hex(random_bytes(16));
                $agent = new Agent();
                $browser = $agent->browser();
                $version = $agent->version($browser);
                $platform = $agent->platform();
                DB::table('customer_users')->where("id", $superAdmin->id)->update(array(
                    'web_token' => $token,
                    "last_ip" => $_SERVER['REMOTE_ADDR'],
                    'last_login' => date("Y-m-d H:m:s"),
                    'platform' => $browser . " / " . $version . ' / ' . $platform,
                ));
                session()->put('web_token', $token);
                session()->put('customer', $superAdmin);
                session()->save();
            } else {
                return redirect()->back()->with('error', "Incorrect number or Password or you are inactive customer");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        session()->flash('success', "login successfully");

        return redirect()->back()->with("success", "Login Successfully");
    }

    public function StaffLogin(Request $request)
    {
        if (!empty(session("app_token"))) {
            $superAdmin =   DB::table("supplier_users")->where("app_token", session("app_token"))->first();
            if (!empty($superAdmin)) {

                return redirect("staff/dashboard");
            }
        }
        return view("staff.login");
    }



    public function SaveStaffLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            session()->flash("error", "Enter number or password");
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $superAdmin =   DB::table("supplier_users as a")
                ->join("supplier_role as b", "a.role_id", "b.id")
                ->where("a.number", $request->number)->where("a.password", $request->password)->where("b.app_permission", 1)->first();
            if (!empty($superAdmin)) {
                $token = bin2hex(random_bytes(16));
                $agent = new Agent();
                $browser = $agent->browser();
                $version = $agent->version($browser);
                $platform = $agent->platform();
                DB::table('supplier_users')->where("id", $superAdmin->id)->update(array(
                    'app_token' => $token,
                    "last_ip" => $_SERVER['REMOTE_ADDR'],
                    'last_login' => date("Y-m-d H:m:s"),
                    'platform' => $browser . " / " . $version . ' / ' . $platform,
                ));
                session()->put('app_token', $token);
                session()->put('staff', $superAdmin);
                session()->save();
            } else {

                return redirect()->back()->with('error', "Incorrect number or Password or you don't have app permission");
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        session()->flash('success', "login successfully");

        return redirect("staff/dashboard");
    }
}
