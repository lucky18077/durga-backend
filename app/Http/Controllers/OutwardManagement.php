<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Jenssegers\Agent\Agent;


use Illuminate\Support\Facades\Storage;
use Termwind\Components\Raw;
use League\Csv\Reader;

use function Laravel\Prompts\table;

class OutwardManagement extends Controller
{
    public function outwardStock(Request $request)
    {
        $department =  DB::table("customer_department")->where("customer_id", $request->user["customer_id"])->get();
        $products =  DB::table("customer_products as a")
            ->select("a.*", "b.stock")
            ->join("customer_current_stock as b", "a.id", "b.product_id")
            ->where("a.customer_id", $request->user["customer_id"])->get();

        return view("customers.outward-stock", compact("department", "products"));
    }

    public function SaveOutward(Request $request)
    {
        $outward_id = 'Outward_' . date('dmyhis');

        $validator = Validator::make($request->all(), [
            'department_id' => 'required',

            'invoice_date' => 'required',

        ]);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $count = 0;
            foreach ($messages->all() as $error) {
                if ($count == 0)
                    return redirect()->back()->with('error', $error);
                $count++;
            }
        }


        $prod_list = json_decode($request->prod_list);
        if (!$prod_list) {
            return redirect()->back()->with('error', "Select at least one product");
        }




        try {
            DB::beginTransaction();
            $mst_id = DB::table('customer_stock_outward_mst')->insertGetId(array(
                "department_id" => $request->department_id,

                "invoice_date" => $request->invoice_date,
                "description" => $request->description,
                "outward_id" => $outward_id,
                "user_id" => $request->user["id"],
                "customer_id" => $request->user["customer_id"],
                "jon_no" => $request->jon_no,

            ));
            $status = 0;
            foreach ($prod_list as $key => $value) {

                $det_id = DB::table('customer_stock_outward_det')->insertGetId(array(
                    "mst_id" => $mst_id,
                    "product_id" => $value->product_id,
                    "qty" => $value->qty,
                    "price" => $value->price,

                ));

                DB::table('customer_current_stock')->where("product_id", $value->product_id)->decrement("stock", $value->qty);
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }

        return redirect()->back()->with('success', "Save Successfully");
    }



    public function outwardReport(Request $request)
    {

        $status = request("status", "pending");
        $outward =  DB::table("customer_stock_outward_mst as a")
            ->select("a.*",    "c.name as customer", "d.name as user")

            ->join("customer_department as c", "a.department_id", "c.id")
            ->join("users as d", "a.user_id", "d.id")
            ->where("a.status", $status)
            ->orderBy("a.id", "desc")
            ->get();

        return view("customers.outward-order-list", compact("outward"));
    }
    public function DispatchChallan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',

        ]);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $count = 0;
            foreach ($messages->all() as $error) {
                if ($count == 0)
                    return redirect()->back()->with('error', $error);
                $count++;
            }
        }

        try {

            $mst_id = DB::table('customer_stock_outward_mst')->where("id", $request->id)->update(array(
                "status" => "dispatch",


            ));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function DeliveredChallan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',

        ]);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $count = 0;
            foreach ($messages->all() as $error) {
                if ($count == 0)
                    return redirect()->back()->with('error', $error);
                $count++;
            }
        }

        try {

            $mst_id = DB::table('customer_stock_outward_mst')->where("id", $request->id)->update(array(
                "status" => "delivered",


            ));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function OutwardChallanView(Request $request, $id)
    {
        $order_mst =  DB::table("customer_stock_outward_mst as a")
            ->select("a.*", "d.name as user","c.name as department")
         
            ->join("customer_department as c", "a.department_id", "c.id")
            ->join("users as d", "a.user_id", "d.id")
            ->where("a.id", $id)
            ->first();
        $order_det = DB::table("customer_stock_outward_det as a")
            ->select("a.*", "b.name as product", "b.article_no")
            ->join("customer_products as b", "a.product_id", "=", "b.id")
            ->join("customer_stock_outward_mst as c", "a.mst_id", "=", "c.id")
            ->where("a.mst_id", $id)
            ->get();


        $nextProduct = DB::table("customer_stock_outward_mst")
            ->where("id", ">", $id)
            ->where("customer_id",$request->user["customer_id"])
            ->orderBy("id", "asc")
            ->first();

        // Get the previous record
        $previousProduct = DB::table("customer_stock_outward_mst")
            ->where("id", "<", $id)
            ->where("customer_id",$request->user["customer_id"])
            ->orderBy("id", "desc")
            ->first();
        return view("customers.outward-challan-view", compact("order_mst", "order_det", "nextProduct", "previousProduct"));
    }
}
