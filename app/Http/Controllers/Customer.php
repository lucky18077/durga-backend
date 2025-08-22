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

class Customer extends Controller
{

    function generateRandomNumber($length = 12)
    {
        $number = '';
        while (strlen($number) < $length) {
            $number .= mt_rand(0, 9);
        }
        return substr($number, 0, $length);
    }

    public function GetCategory(Request $request)
    {
        return DB::table("customer_category")->where("brand_id", $request->id)
            ->where("customer_id", $request->user['customer_id'])
            ->get();
    }

    public function GetSubCategory(Request $request)
    {
        return DB::table("customer_sub_category")
            ->where("customer_id", $request->user['customer_id'])
            ->where("category_id", $request->id)->get();
    }

    public function GetProducts(Request $request)
    {
        return DB::table("customer_products")
            ->where("customer_id", $request->user['customer_id'])
            ->where("sub_category_id", $request->id)->get();
    }

    public function GetFinishProduct(Request $request)
    {
        return DB::table("customer_finish_products_mst")->where("f_category_id", $request->id)->get();
    }

    public function GetGatheringDet(Request $request)
    {
        return DB::table("gathering_det as a")
            ->select("a.*", "b.name as product", "a.f_product_id as id")
            ->join("customer_finish_products_mst as b", "a.f_product_id", "b.id")
            ->where("mst_id", $request->id)->get();
    }















    public function Dashboard(Request $request)
    {
        return view("customers.dashboard");
    }

    public function Profile(Request $request)
    {
        $data = DB::table("customer_users")->where("id", $request->user['id'])->first();
        return view("customers.profile", compact("data"));
    }



    public function UpdateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'number' => 'required|digits:10',
            'name' => 'required',
            'password' => 'required',


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


            DB::table('customer_users')->where("id", $request->user['id'])->update(array(

                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,

                "address" => $request->address,
                "state" => $request->state,
                "city" => $request->ity,
                "district" => $request->district,
                "pincode" => $request->pincode,
                "password" => $request->password,



            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function Brand(Request $request)
    {
        $data = DB::table("customer_brand")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.brand", compact("data"));
    }

    public function SaveBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        try {

            if (empty($request->id)) {

                DB::table('customer_brand')->insertGetId(array(

                    "name" => $request->name,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_brand')->where("id", $request->id)->update(array(

                    "name" => $request->name,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function Category(Request $request)
    {
        $brand = DB::table("customer_brand")->where("customer_id", $request->user['customer_id'])->get();
        $data = DB::table("customer_category")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.category", compact("data", "brand"));
    }

    public function SaveCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'brand_id' => 'required',
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

            if (empty($request->id)) {

                DB::table('customer_category')->insertGetId(array(

                    "name" => $request->name,
                    "brand_id" => $request->brand_id,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_category')->where("id", $request->id)->update(array(

                    "name" => $request->name,
                    "name" => $request->name,
                    "brand_id" => $request->brand_id,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function SubCategory(Request $request)
    {
        $brand = DB::table("customer_brand")->where("customer_id", $request->user['customer_id'])->get();
        $data = DB::table("customer_sub_category as a")
            ->select("a.*", "b.name as category_name", "c.id as brand_id")
            ->join("customer_category as b", "a.category_id", "b.id")
            ->join("customer_brand as c", "b.brand_id", "c.id")
            ->where("a.customer_id", $request->user['customer_id'])->get();
        return view("customers.sub-category", compact("data", "brand"));
    }

    public function SaveSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
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

            if (empty($request->id)) {

                DB::table('customer_sub_category')->insertGetId(array(

                    "name" => $request->name,
                    "category_id" => $request->category_id,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_sub_category')->where("id", $request->id)->update(array(

                    "name" => $request->name,
                    "category_id" => $request->category_id,


                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }



    public function Product(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);

        $product = DB::table("customer_products as a")
            ->select("a.*", "b.name as category_name", "c.name as brand_name", "ut.name as unit_type", "d.name as sub_category")
            ->join("customer_category as b", "a.category_id", "b.id")
            ->join("customer_brand as c", "a.brand_id", "c.id")
            ->join("customer_sub_category as d", "a.sub_category_id", "d.id")

            ->leftJoin("customer_unit_type as ut", "ut.id", "a.uom")
            ->where('a.customer_id', $request->user['customer_id']);

        if ($search) {
            $product->where(function ($query) use ($search) {
                $query->where('a.name', 'like', '%' . $search . '%')
                    ->orWhere('c.name', 'like', '%' . $search . '%')
                    ->orWhere('a.article_no', 'like', '%' . $search . '%')
                    ->orWhere('b.name', 'like', '%' . $search . '%');
            });
        }

        if ($perPage > 0) {
            $products = $product->paginate($perPage);
        } else {
            $perPage = PHP_INT_MAX;

            $products = $product->paginate($perPage);
        }



        $brand = DB::table("customer_brand")->where("customer_id", $request->user['customer_id'])->get();
        $unit_type = DB::table("customer_unit_type")->where("customer_id", $request->user['customer_id'])->get();
        $gst = DB::table("customer_gst")->where("customer_id", $request->user['customer_id'])->get();
        $products->appends(['search' => $search, 'perPage' => $perPage]);
        return view("customers.products", compact('products', "brand", "unit_type", "gst"));
    }

    public function SaveProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'category_id' => 'required',

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
        $barcode = $this->generateRandomNumber(10);
        $raw_material = 0;
        if (!empty($request->raw_material)) {
            $raw_material = implode(', ', $request->raw_material);
        }

        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('product images', $file);
        } else {
            if (!empty($request->id)) {
                $products = DB::table("customer_products")->where("id", $request->id)->first();
                $file = $products->image;
            }
        }
        try {
            if (empty($request->id)) {
                DB::table('customer_products')->insertGetId(array(
                    "brand_id" => $request->brand_id,
                    "category_id" => $request->category_id,
                    "sub_category_id" => $request->sub_category_id,

                    "name" => $request->name,
                    "article_no" => $request->article_no,
                    "price" => $request->price,
                    "min_stock" => $request->minimum_stock,
                    "uom" => $request->uom,
                    "warranty_days" => $request->warranty_days,

                    "active" => $request->active,
                    "bar_code" => $barcode,
                    "raw_material" => $raw_material,
                    "gst" => $request->gst,
                    "image" => $file,
                    "manual_barcode" => $request->manual_barcode,
                    "cess_tax" => $request->cess_tax,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_products')->where("id", $request->id)->update(array(
                    "brand_id" => $request->brand_id,
                    "category_id" => $request->category_id,
                    "sub_category_id" => $request->sub_category_id,
                    "name" => $request->name,
                    "article_no" => $request->article_no,
                    "price" => $request->price,
                    "min_stock" => $request->minimum_stock,
                    "uom" => $request->uom,
                    "warranty_days" => $request->warranty_days,

                    "active" => $request->active,
                    "raw_material" => $raw_material,
                    "gst" => $request->gst,
                    "image" => $file,
                    "manual_barcode" => $request->manual_barcode,
                    "cess_tax" => $request->cess_tax

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function ImportProducts(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt',
        ]);


        if ($validator->fails()) {
            $messages = $validator->errors();
            $count = 0;
            foreach ($messages->all() as $error) {
                if ($count == 0)
                    return redirect()->back()->with("error", $error);

                $count++;
            }
        }

        $count_d = 0;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('csv', 'public');

            $csv = Reader::createFromPath(storage_path('app/public/' . $filePath), 'r');
            // $csv->setHeaderOffset(0); // Assuming the first row contains headers
            $brand = "";
            $duplicate = 0;
            $error = "";
            $error_count = 0;
            $success = 0;
            $count = 1;
            foreach ($csv as $record) {
                $brand_id = "";
                $category_id = "";
                $sub_category_id = "";
                $unit_type_id = "";
                try {

                    $brand = DB::table("brand")->where("name", $record[0])->first();
                    if ($brand) {
                        $brand_id = $brand->id;
                    } else {
                        $brand_id =  DB::table('brand')->insertGetId(array(
                            "name" => $record[0],

                        ));
                    }

                    $category = DB::table("category")->where("name", $record[1])->first();
                    if ($category) {
                        $category_id = $category->id;
                    } else {
                        $category_id =  DB::table('category')->insertGetId(array(
                            "name" => $record[1],
                            "brand_id" => $brand_id,

                        ));
                    }
                    $sub_category = DB::table("sub_category")->where("name", $record[2])->first();
                    if ($sub_category) {
                        $sub_category_id = $sub_category->id;
                    } else {
                        $sub_category_id =  DB::table('sub_category')->insertGetId(array(
                            "name" => $record[2],
                            "category_id" => $category_id,

                        ));
                    }

                    $unit_type = DB::table("unit_type")->where("name", $record[7])->first();
                    if ($unit_type) {
                        $unit_type_id = $unit_type->id;
                    } else {
                        $unit_type_id =  DB::table('unit_type')->insertGetId(array(
                            "name" => $record[7],
                        ));
                    }



                    $products = DB::table("products")->where("article_no", $record[4])->first();
                    if ($products) {
                        $error .= "Raw ID " . $count . " Duplicate article no. <br>";
                        $duplicate++;
                    } else {
                        $barcode = $this->generateRandomNumber(10);


                        $product =  DB::table('products')->insertGetId(array(
                            "brand_id" => $brand_id,
                            "category_id" => $category_id,
                            "sub_category_id" => $sub_category_id,


                            "name" => $record[3],
                            "article_no" => $record[4],
                            "price" => $record[5],
                            "min_stock" => $record[6],
                            "uom" => $unit_type_id,

                            "active" => 1,
                            "bar_code" => $barcode,

                        ));
                        $success++;
                    }
                } catch (\Throwable $th) {
                    $error .= "Raw ID " . $count . " Invalid format. <br>";
                    $error_count++;
                }
                $count++;
            }

            return redirect()->back()->with("success", "Save successfully - Total : " . $count - 1 . " Success : " . $success . "  Duplicate : " . $duplicate . " Error : " . $error_count)->with("msg", $error);
        }

        return redirect()->back()->with("error", "No csv file selected for upload");
    }



    public function FinishProductCategory(Request $request)
    {
        $data = DB::table("customer_f_product_category")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.finish-product-category", compact("data"));
    }

    public function SaveFinishCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        try {

            if (empty($request->id)) {

                DB::table('customer_f_product_category')->insertGetId(array(

                    "name" => $request->name,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_f_product_category')->where("id", $request->id)->update(array(

                    "name" => $request->name,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }




    public function FinishProduct(Request $request)
    {

        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $product = DB::table("customer_finish_products_mst as a")
            ->select("a.*", "b.name as category_name", "ut.name as unit_type")
            ->join("customer_f_product_category as b", "a.f_category_id", "b.id")
            ->leftJoin("customer_unit_type as ut", "ut.id", "a.uom")
            ->where('a.customer_id', $request->user['customer_id']);
        if ($search) {
            $product->where(function ($query) use ($search) {
                $query->where('a.name', 'like', '%' . $search . '%')
                    ->orWhere('a.article_no', 'like', '%' . $search . '%')
                    ->orWhere('b.name', 'like', '%' . $search . '%');
            });
        }



        if ($perPage > 0) {
            $products = $product->paginate($perPage);
        } else {
            $perPage = PHP_INT_MAX;

            $products = $product->paginate($perPage);
        }



        $products->appends(['search' => $search, 'perPage' => $perPage]);

        $f_product_category = DB::table("customer_f_product_category")->where("customer_id", $request->user['customer_id'])->get();
        $unit_type = DB::table("customer_unit_type")->get();
        $gst = DB::table("customer_gst")->get();
        $brand = DB::table("customer_brand")->get();
        return view("customers.finish-product", compact('products', "f_product_category", "unit_type", "gst", "brand"));
    }

    public function SaveFinishProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'category_id' => 'required',

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
        $barcode = $this->generateRandomNumber(10);
        $raw_material = 0;
        if (!empty($request->raw_material)) {
            $raw_material = implode(', ', $request->raw_material);
        }

        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('product images', $file);
        } else {
            if (!empty($request->id)) {
                $products = DB::table("products")->where("id", $request->id)->first();
                $file = $products->image;
            }
        }
        try {

            $mst_id = DB::table('customer_finish_products_mst')->insertGetId(array(

                "f_category_id" => $request->category_id,


                "name" => $request->name,
                "article_no" => $request->article_no,
                "price" => $request->price,
                "min_stock" => $request->minimum_stock,
                "uom" => $request->uom,
                "gst" => $request->gst,

                "active" => $request->active,
                "bar_code" => $barcode,

                "image" => $file,
                "cess_tax" => $request->cess_tax,
                "hsn_code" => $request->hsn_code,
                "manual_barcode" => $request->manual_barcode,
                "customer_id" => $request->user['customer_id'],
                "warranty_days" => $request->warranty_days,

            ));

            $prod_list = json_decode($request->prod_List);
            foreach ($prod_list as $key => $value) {

                DB::table('customer_finish_products_det')->insertGetId(array(
                    "mst_id" => $mst_id,

                    "qty" => $value->qty,
                    "product_id" => $value->product_id,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function UpdateFinishProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'price' => 'required',

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

        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('product images', $file);
        } else {
            if (!empty($request->id)) {
                $products = DB::table("customer_finish_products_mst")->where("id", $request->id)->first();
                $file = $products->image;
            }
        }

        try {

            DB::table('customer_finish_products_mst')->where("id", $request->id)->update(array(
                "gst" => $request->gst,
                "image" => $file,
                "f_category_id" => $request->category_id,

                "name" => $request->name,
                "article_no" => $request->article_no,
                "price" => $request->price,
                "min_stock" => $request->minimum_stock,
                "uom" => $request->uom,
                "active" => $request->active,
                "image" => $file,
                "cess_tax" => $request->cess_tax,
                "hsn_code" => $request->hsn_code,
                "manual_barcode" => $request->manual_barcode,
                "warranty_days" => $request->warranty_days

            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function RawMaterialProduct(Request $request, $id)
    {
        $products = DB::table("customer_products as a")
            ->select("a.*", "b.name as category_name", "c.name as brand_name", "ut.name as unit_type", "fp.qty", "fp.id as eID")
            ->join("customer_category as b", "a.category_id", "b.id")
            ->join("customer_brand as c", "b.brand_id", "c.id")

            ->LeftJoin("customer_unit_type as ut", "ut.id", "a.uom")
            ->join("customer_finish_products_det as fp", "a.id", "fp.product_id")
            ->where("fp.mst_id", $id)

            ->get();
        $mst_id = $id;
        $brand = DB::table("customer_brand")->get();
        return view("customers.raw-material-product", compact("products", "brand", "mst_id"));
    }


    public function SaveRawProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'qty' => 'required',


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
            if (!empty($request->id)) {


                DB::table('customer_finish_products_det')->where("id", $request->id)->update(array(

                    "qty" => $request->qty,

                ));
            } else {

                $finish_products_det = DB::table("customer_finish_products_det")->where("mst_id", $request->mst_id)->where("product_id", $request->product_id)->first();
                if ($finish_products_det) {
                    return  redirect()->back()->with("error", "Raw material already added");
                } else {

                    DB::table('customer_finish_products_det')->insertGetId(array(

                        "mst_id" => $request->mst_id,
                        "qty" => $request->qty,
                        "product_id" => $request->product_id,

                    ));
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function DeleteProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
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
            DB::table('customer_finish_products_det')->where("id", $request->id)->delete();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function GatheringList(Request $request)
    {
        $data = DB::table("gathering_mst")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.gathering-list", compact("data"));
    }

    public function AddGathering(Request $request)
    {
        $category = DB::table("customer_f_product_category")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.add-gathering", compact("category"));
    }

    public function SaveGathering(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'qty' => 'required',

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

            $mst_id = DB::table('gathering_mst')->insertGetId(array(


                "customer_id" => $request->user['customer_id'],
                "qty" => $request->qty,
                "name" => $request->name,

            ));

            $prod_list = json_decode($request->prod_List);
            if (!$prod_list) {
                return redirect()->back()->with('error', "Select at least one product");
            }
            foreach ($prod_list as $key => $value) {

                DB::table('gathering_det')->insertGetId(array(
                    "mst_id" => $mst_id,

                    "qty" => $value->qty,
                    "f_product_id" => $value->product_id,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function UpdateGathering(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'qty' => 'required',
            'id' => 'required',

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

            DB::table('gathering_mst')->where("id", $request->id)->update(array(

                "qty" => $request->qty,
                "name" => $request->name,

            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }
    public function GatheringMenu(Request $request, $id)
    {
        $data =   DB::table("gathering_det as a")
            ->select("a.*", "b.name")
            ->join("customer_finish_products_mst as b", "a.f_product_id", "b.id")
            ->where("a.mst_id", $id)
            ->get();
        $gathering = DB::table("gathering_mst")->where("id", $id)->first();
        $category = DB::table("customer_f_product_category")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.gathering-menu", compact("data", "gathering", "category"));
    }

    public function AddGatheringMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'product_id' => 'required',
            'qty' => 'required',
            'mst_id' => 'required',

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

        $gathering_det =  DB::table("gathering_det")->where("mst_id", $request->mst_id)->where("f_product_id", $request->product_id)->first();
        if ($gathering_det) {
            return redirect()->back()->with('error', "Already added");
        }
        try {

            DB::table('gathering_det')->insertGetId(array(

                "f_product_id" => $request->product_id,
                "qty" => $request->qty,
                "mst_id" => $request->mst_id,

            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function DeleteGatheringMenuItem(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'id' => 'required',


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

            DB::table('gathering_det')->where("id", $request->id)->delete();
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function Customer(Request $request)
    {
        $data = DB::table("gathering_customer")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.customer", compact("data"));
    }

    public function SaveCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'number' => 'required',
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
        try {
            $data = [
                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
                "state" => $request->state,
                "city" => $request->city,
                "district" => $request->district,
                "pincode" => $request->pincode,
                "address" => $request->address,
                "customer_id" => $request->user['customer_id'],
            ];
            if (empty($request->id)) {
                DB::table('gathering_customer')->insertGetId($data);
            } else {
                DB::table('gathering_customer')->where("id", $request->id)->update($data);
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function CustomerGathering(Request $request)
    {
        $data = DB::table("customer_gathering_mst as a")
            ->select("a.*", "b.name as customer")
            ->join("gathering_customer as b", "a.g_customer_id", "b.id")
            ->where("a.customer_id", $request->user['customer_id'])->orderBy("a.id", "desc")->get();
        return view("customers.customer-gathering", compact("data"));
    }

    public function AddCustomerGathering(Request $request)
    {
        $gathering_mst = DB::table("gathering_mst")->where("customer_id", $request->user['customer_id'])->get();
        $gathering_customer = DB::table("gathering_customer")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.add-customer-gathering", compact("gathering_mst", "gathering_customer"));
    }

    public function SaveCustomerGathering(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'gathering_id' => 'required',
            'person_qty' => 'required',
            'g_customer_id' => 'required',
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

        if (!$request->qty) {

            return redirect()->back()->with('error', "Select at least one dish");
        }


        try {
            $gathering_mst =  DB::table("gathering_mst")->where("id", $request->gathering_id)->first();
            $mst_id =  DB::table("customer_gathering_mst")->insertGetId(array(
                "g_customer_id" => $request->g_customer_id,
                "gathering_name" => $gathering_mst->name,
                "qty" => $request->person_qty,
                "customer_id" => $request->user['customer_id'],

            ));
            foreach ($request->qty as $key => $value) {
                $gathering_det = DB::table("gathering_det")->where("f_product_id", $value)->where("mst_id", $gathering_mst->id)->first();
                $finish_products_mst = DB::table("customer_finish_products_mst")->where("id", $gathering_det->f_product_id)->first();
                $finish_products_det = DB::table("customer_finish_products_det")->where("mst_id", $finish_products_mst->id)->get();
                $kgs = $request->person_qty / $gathering_mst->qty * $gathering_det->qty;


                DB::table("customer_gathering_f_det")->insertGetId(array(
                    "mst_id" => $mst_id,
                    "f_product_id" => $gathering_det->f_product_id,
                    "qty" => $kgs,
                ));
                foreach ($finish_products_det as $key => $value) {
                    DB::table("customer_gathering_r_det")->insertGetId(array(
                        "mst_id" => $mst_id,
                        "product_id" => $value->product_id,
                        "qty" => $kgs * $value->qty,
                    ));
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function CustomerGatheringMenu(Request $request, $id)
    {
        $data = DB::table("customer_gathering_f_det as a")
            ->select("a.*", "b.name as product")
            ->join("customer_finish_products_mst as b", "a.f_product_id", "b.id")
            ->where("a.mst_id", $id)
            ->get();
        $customer =  DB::table("gathering_customer as a")
            ->select("a.*")
            ->join("customer_gathering_mst as b", "a.id", "b.g_customer_id")
            ->where("b.id", $id)
            ->first();
        return view("customers.customer-gathering-menu", compact("data", "id", "customer"));
    }

    public function CustomerGatheringMenuRawMaterial(Request $request, $id)
    {
        $data = DB::table("customer_gathering_r_det as a")
            ->select("b.name as product", DB::raw("sum(a.qty) as qty"))
            ->join("customer_products as b", "a.product_id", "b.id")
            ->where("a.mst_id", $id)
            ->groupBy("a.product_id", "b.name")
            ->get();
        $customer =  DB::table("gathering_customer as a")
            ->select("a.*")
            ->join("customer_gathering_mst as b", "a.id", "b.g_customer_id")
            ->where("b.id", $id)
            ->first();
        return view("customers.customer-gathering-menu-raw-material", compact("data", "id", "customer"));
    }


    public function vendor(Request $request)
    {
        $data =  DB::table("vendor")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.vendor", compact("data"));
    }

    public function saveVendor(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',

        ]);


        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {

            if ($request->id) {
                DB::table("vendor")->where("id", $request->id)->update(array(
                    "company" => $request->company,
                    "name" => $request->name,
                    "number" => $request->number,
                    "email" => $request->email,
                    "address" => $request->address,
                    "state" => $request->state,
                    "district" => $request->district,
                    "city" => $request->city,
                    "pincode" => $request->pincode,
                    "gst" => $request->gst,
                    "active" => $request->active,
                ));
            } else {
                DB::table("vendor")->insert(array(
                    "company" => $request->company,
                    "name" => $request->name,
                    "number" => $request->number,
                    "email" => $request->email,
                    "address" => $request->address,
                    "state" => $request->state,
                    "district" => $request->district,
                    "city" => $request->city,
                    "pincode" => $request->pincode,
                    "gst" => $request->gst,
                    "active" => $request->active,
                    "customer_id" => $request->user['customer_id'],
                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function gst(Request $request)
    {
        $data = DB::table("customer_gst")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.gst", compact("data"));
    }

    public function SaveGST(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gst' => 'required',
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

            if (empty($request->id)) {

                DB::table('customer_gst')->insertGetId(array(

                    "gst" => $request->gst,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_gst')->where("id", $request->id)->update(array(

                    "gst" => $request->gst,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }



    public function unitType(Request $request)
    {
        $data = DB::table("customer_unit_type")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.unit-type", compact("data"));
    }

    public function SaveUnitType(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        try {

            if (empty($request->id)) {

                DB::table('customer_unit_type')->insertGetId(array(

                    "name" => $request->name,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_unit_type')->where("id", $request->id)->update(array(

                    "name" => $request->name,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }



    public function department(Request $request)
    {
        $data = DB::table("customer_department")->where("customer_id", $request->user['customer_id'])->get();
        return view("customers.department", compact("data"));
    }

    public function saveDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        try {

            if (empty($request->id)) {

                DB::table('customer_department')->insertGetId(array(

                    "name" => $request->name,
                    "customer_id" => $request->user['customer_id'],

                ));
            } else {
                DB::table('customer_department')->where("id", $request->id)->update(array(

                    "name" => $request->name,

                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }
}
