<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Jenssegers\Agent\Agent;

class StaffManagement extends Controller
{
    public function StaffDashboard(Request $request)
    {
        $data = DB::table("orders_supplier")
            ->select(
                DB::raw("
                SUM(CASE WHEN shipping_status = 'processing' THEN 1 ELSE 0 END) AS processing,
                SUM(CASE WHEN shipping_status = 'complete' THEN 1 ELSE 0 END) AS complete,
                SUM(CASE WHEN shipping_status = 'dispatch' THEN 1 ELSE 0 END) AS dispatch,
                SUM(CASE WHEN shipping_status = 'delivered' THEN 1 ELSE 0 END) AS delivered
            ")
            )
            ->where("supplier_id", $request->user["supplier_id"])
            ->where("user_id", $request->user["id"])
            ->first();


        return view("staff.index", compact("data"));
    }


    public function Orders(Request $request, $status)
    {

        $data =  DB::table("orders_supplier as a")
            ->select("b.*", "a.shipping_status as status", "a.updated_at", "b.id")
            ->join("orders as b", "a.order_id", "b.id")
            ->where("a.supplier_id", $request->user["supplier_id"])
            ->where("a.user_id", $request->user["id"])
            ->where("a.shipping_status", $status)
            ->orderBy("a.id", "desc")
            ->get();

        return view("staff.orders", compact("data"));
    }

    public function OrderDetails(Request $request, $id)
    {
        $orders = DB::table("orders as a")
            ->select("a.*", "c.name as supplier_name", "c.number as supplier_number", "c.email as supplier_email", "c.address as supplier_address", "c.state as supplier_state", "c.district as supplier_district", "c.city as supplier_city", "c.pincode as supplier_pincode", "b.subtotal", "b.shipping_status as status", "b.id as supplier_id")
            ->join("orders_supplier as b", "a.id", "b.order_id")
            ->join("suppliers as c", "b.supplier_id", "c.id")
            ->where("a.id", $id)->first();
        $det = DB::table("orders_item as a")
            ->select("a.*", "b.hsn_code", "c.name as uom")
            ->join("products as b", "a.product_id", "b.id")
            ->join("product_uom as c", "b.uom_id", "c.id")
            ->where("a.supplier_id", $orders->supplier_id)
            ->where("a.order_id", $orders->id)
            ->get();


        return view("staff.order-details", compact("orders", "det"));
    }


    public function Logout(Request $request)
    {

        DB::table('supplier_users')->where("app_token", session("app_token"))->update(array(
            'app_token' => "",
        ));
        session()->flush();
        return redirect("supplier-staff")->with("success", "logout successfully");
    }
}
