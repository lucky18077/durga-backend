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

class PurchaseManagement extends Controller
{


    public function vendorProduct(Request $request, $id)
    {

        $vendor = DB::table("vendor")->where("id", $id)->first();
        $vendor_product = DB::table("vendor_product as a")
            ->select("a.id as id", "b.*")
            ->join("customer_products as b", "a.product_id", "b.id")
            ->where("a.vendor_id", $id)->get();
        $products = DB::table('customer_products as a')
            ->select("a.*")
            ->leftJoin("vendor_product as b", "a.id", "b.product_id")
            ->whereNull("b.product_id")
            ->where("customer_id", $request->user["customer_id"])->get();
        return view("customers.vendor-product", compact("vendor", "vendor_product", "products"));
    }
    public function generatePO(Request $request)
    {
        $vendor =  DB::table("vendor")->where("customer_id", $request->user['customer_id'])->get();
        $gst =  DB::table("customer_gst")->where("customer_id", $request->user['customer_id'])->get();

        return view("customers.generate-po", compact("vendor", "gst"));
    }

    public function saveVendorProduct(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'checks' => 'required',

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
            foreach ($request->checks as $key => $value) {
                $vendor_product = DB::table("vendor_product")->where("product_id", $value)->where("vendor_id", $request->vendor_id)->first();
                if (!$vendor_product) {
                    DB::table("vendor_product")->insert(array(
                        "product_id" => $value,
                        "vendor_id" => $request->vendor_id,
                    ));
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function GetVendorProducts(Request $request)
    {
        return DB::table("vendor_product as a")
            ->select("a.*", "b.name", "b.price", "b.id as id")
            ->join("customer_products as b", "a.product_id", "b.id")
            ->where("a.vendor_id", $request->id)->get();
    }

    public function SavePO(Request $request)
    {



        $po_id = $request->user["customer_id"] . date("ymhs");

        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'name' => 'required',

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
            $mst_id = DB::table('customer_po_mst')->insertGetId(array(
                "vendor_id" => $request->vendor_id,
                "user_id" => $request->user['id'],
                "customer_id" => $request->user['customer_id'],
                "po_id" => $po_id,
                "name" => $request->name,
                "description" => $request->description,
                "status" => "generated",
            ));
            foreach ($prod_list as $key => $value) {
                DB::table('customer_po_det')->insertGetId(array(
                    "mst_id" => $mst_id,
                    "product_id" => $value->product_id,
                    "qty" => $value->qty,
                    "price" => $value->price,
                    "gst" => $value->gst,
                    "gst_type" => $value->gst_type,
                ));
            }
            // $company_settings =  DB::table("company_settings")->where("id", 1)->increment("invoice_no", 1);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
        return redirect()->back()->with('success', "Save Successfully");
    }

    public function po(Request $request, $status)
    {

        $data =  DB::table("customer_po_mst as a")
            ->select("a.*", "b.company as company", "b.name as vendor", "c.name as user")
            ->join("vendor as b", "a.vendor_id", "b.id")
            ->join("customer_users as c", "a.user_id", "c.id")
            ->where("a.customer_id", $request->user["customer_id"])
            ->where("a.status", $status)
            ->orderBy("a.id", "desc")
            ->get();
        return view("customers.po", compact("data"));
    }
    public function PurchaseView(Request $request, $id)
    {
        $po_mst =  DB::table("customer_po_mst as a")
            ->select("a.*", "b.company as vendor_company", "b.name as vendor_name", "b.address as vendor_address", "b.state as vendor_state", "b.city as vendor_city", "b.district as vendor_district", "b.pincode as vendor_pincode", "b.number as vendor_number", "b.email as vendor_email", "b.gst as vendor_gst", "c.name as user")
            ->join("vendor as b", "a.vendor_id", "b.id")
            ->join("customer_users as c", "a.user_id", "c.id")
            ->where("a.customer_id", $request->user["customer_id"])
            ->where("a.id", $id)
            ->first();
        $po_det = DB::table("customer_po_det as a")
            ->select("a.*", "b.name as product_name", "b.article_no", "c.name as uom")
            ->join("customer_products as b", "a.product_id", "b.id")
            ->join("customer_unit_type as c", "b.uom", "c.id")
            ->where("a.mst_id", $id)->get();


        $products =  DB::table("customer_products")->where("customer_id", $request->user["customer_id"])->get();
        $gst =  DB::table("customer_gst")->where("customer_id", $request->user["customer_id"])->get();

        return view("customers.purchase-view", compact("po_mst", "po_det", "products", "gst"));
    }



    public function UpdateCharges(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'freight_charges' => 'required',
            'loading_charges' => 'required',

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
            $mst_id = DB::table('customer_po_mst')->where("id", $request->id)->update(array(
                "freight_charges" => $request->freight_charges,
                "loading_charges" => $request->loading_charges,

            ));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        return redirect()->back()->with('success', "Save Successfully");
    }


    public function InwardStock(Request $request)
    {
        $vendor =  DB::table("vendor")->where("customer_id", $request->user["customer_id"])->get();
        return view("customers.inward-stock", compact("vendor"));
    }
    public function GetPO(Request $request)
    {
        $po_mst = DB::table('customer_po_mst')
            ->where('vendor_id', $request->id)
            ->where(function ($query) {
                $query->where('status', 'partial')
                    ->orWhere('status', 'generated');
            })
            ->get();
        return $po_mst;
    }

    public function GetPODet(Request $request)
    {

        $po_det = DB::table("customer_po_det as a")
            ->select("a.*", "b.name as product_name", "b.article_no", "b.id as product_id")
            ->join("customer_products as b", "a.product_id", "b.id")
            ->where("mst_id", $request->id)->get();
        return $po_det;
    }


    public function SaveInwardStock(Request $request)
    {



        $inward_id = 'Inward_' . date('dmyhis');

        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required',
            'po_id' => 'required',


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
            $mst_id = DB::table('customer_stock_inward_mst')->insertGetId(array(
                "vendor_id" => $request->vendor_id,
                "po_id" => $request->po_id,
                "invoice_no" => $request->invoice_no,
                "invoice_date" => $request->invoice_date,
                "received_material_date" => $request->received_material_date,
                "description" => $request->description,
                "user_id" => $request->user["id"],
                "customer_id" => $request->user["customer_id"],

            ));
            $status = 0;
            foreach ($prod_list as $key => $value) {

                $det_id = DB::table('customer_stock_inward_det')->insertGetId(array(
                    "mst_id" => $mst_id,
                    "product_id" => $value->product_id,
                    "qty" => $value->qty,
                    "price" => $value->price,

                ));



                DB::table('customer_po_det')->where("mst_id", $request->po_id)->where("product_id", $value->product_id)->increment("received_qty", $value->qty);

                $current_stock = DB::table("customer_current_stock")->where("product_id", $value->product_id)->first();

                if ($current_stock) {
                    DB::table('customer_current_stock')->where("id", $current_stock->id)->update([
                        'stock' => DB::raw('stock + ' . $value->qty)
                    ]);
                } else {
                    DB::table('customer_current_stock')->insertGetId(array(

                        "product_id" => $value->product_id,
                        "stock" => $value->qty,
                    ));
                }
            }


            $status = 0;
            $po_det = DB::table('customer_po_det')->where("mst_id", $request->po_id)->get();
            foreach ($po_det as $value) {
                if ($value->received_qty < $value->qty) {
                    $status = 1;
                }
            }


            if ($status == 1) {
                DB::table('customer_po_mst')->where("id", $request->po_id)->update(array(
                    "status" => "partial",
                ));
            } else {
                DB::table('customer_po_mst')->where("id", $request->po_id)->update(array(
                    "status" => "complete",
                ));
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }

        return redirect()->back()->with('success', "Save Successfully");
    }

    public function InwardReport(Request $request)
    {
        $data = DB::table("customer_stock_inward_mst as a")
            ->select("a.*", "b.name as vendor", "c.name as user")
            ->join("vendor as b", "a.vendor_id", "b.id")
            ->join("customer_users as c", "a.user_id", "c.id")
            ->where("a.customer_id", $request->user["customer_id"])->orderBy("id", "desc")->get();
        return view("customers.inward-stock-report", compact("data"));
    }
    public function InwardReportView(Request $request, $id)
    {

        $stock_inward_mst =   DB::table("customer_stock_inward_mst as a")
            ->select("a.*", "b.name as vendor", "c.name as po_name",  "e.name as user")
            ->join("vendor as b", "a.vendor_id", "b.id")
            ->join("customer_po_mst as c", "a.po_id", "c.id")

            ->join("users as e", "a.user_id", "e.id")
            ->where("a.id", $id)
            ->first();


        $stock_inward_det = DB::table("customer_stock_inward_det as a")
            ->select("a.*", "b.name as product_name", "b.article_no")
            ->join("products as b", "a.product_id", "b.id")

            ->where("a.mst_id", $id)
            ->get();



        return view("customers.inward-stock-view", compact("stock_inward_mst", "stock_inward_det"));
    }
}
