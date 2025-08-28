<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Jenssegers\Agent\Agent;

class Masters extends Controller
{
    public function Customers(Request $request)
    {
        return view("admin.customers");
    }
    public function Suppliers(Request $request)
    {
        $data =  DB::table("suppliers")->orderBy("id", "desc")->get();
        return view("admin.suppliers", compact("data"));
    }

    public function SaveSuppliers(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'number' => 'required|digits:10',
            'name' => 'required',
            'password' => 'required',
            'company_name' => 'required',
            'company_number' => 'required',

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

            DB::beginTransaction();
            $supplier_id = DB::table('suppliers')->insertGetId(array(

                "name" => $request->company_name,
                "number" => $request->company_number,
                "email" => $request->company_email,
                "gst" => $request->company_gst,
                "address" => $request->company_address,
                "state" => $request->company_state,
                "city" => $request->company_city,
                "district" => $request->company_district,
                "pincode" => $request->company_pincode,

            ));
            $role_id = DB::table("supplier_role")->insertGetId(array(
                "name" => "admin",
                "supplier_id" => $supplier_id,
            ));
            DB::table('supplier_users')->insert(array(
                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
                "address" => $request->address,
                "state" => $request->state,
                "city" => $request->ity,
                "district" => $request->district,
                "pincode" => $request->pincode,
                "password" => $request->password,
                "supplier_id" => $supplier_id,
                "role_id" => $role_id,
            ));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }
    public function ProductBrand(Request $request)
    {
        $data =   DB::table("product_brand")->where("supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.product-brand", compact("data"));
    }

    public function SaveProductBrand(Request $request)
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
        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('master images', $file);
        } else {
            if ($request->id) {
                $product_category =  DB::table("product_brand")->where("id", $request->id)->first();
                $file = $product_category->image;
            }
        }

        try {
            if ($request->id) {
                DB::table('product_brand')->where("id", $request->id)->update(array(

                    "name" => $request->name,
                    "image" => $file,
                    "supplier_id" => $request->user['supplier_id'],


                ));
            } else {
                DB::table('product_brand')->insertGetId(array(

                    "name" => $request->name,
                    "image" => $file,
                    "supplier_id" => $request->user['supplier_id'],


                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }



    public function ProductCategory(Request $request)
    {
        $brand = DB::table("product_brand")->where("supplier_id", $request->user['supplier_id'])->get();
        $data =   DB::table("product_category")->where("supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.product-category", compact("data", "brand"));
    }

    public function SaveProductCategory(Request $request)
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
        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('master images', $file);
        } else {
            if ($request->id) {
                $product_category =  DB::table("product_category")->where("id", $request->id)->first();
                $file = $product_category->image;
            }
        }

        try {
            if ($request->id) {
                DB::table('product_category')->where("id", $request->id)->update(array(

                    "name" => $request->name,

                    "image" => $file,
                    "supplier_id" => $request->user['supplier_id'],


                ));
            } else {
                DB::table('product_category')->insertGetId(array(

                    "name" => $request->name,

                    "image" => $file,
                    "supplier_id" => $request->user['supplier_id'],


                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function ProductSubCategory(Request $request)
    {
        $category =   DB::table("product_category")->where("supplier_id", $request->user['supplier_id'])->get();

        $data =   DB::table("product_sub_category as a")
            ->select("a.*",   "b.name as category")
            ->join("product_category as b", "a.category_id", "b.id")
            ->where("a.supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.product-sub-category", compact("data", "category"));
    }

    public function GetProductCategory(Request $request)
    {
        return DB::table("product_category")->where("brand_id", $request->brand_id)->get();
    }

    public function SaveProductSubCategory(Request $request)
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
        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('master images', $file);
        } else {
            if ($request->id) {
                $product_category =  DB::table("product_sub_category")->where("id", $request->id)->first();
                $file = $product_category->image;
            }
        }

        try {
            if ($request->id) {
                DB::table('product_sub_category')->where("id", $request->id)->update(array(

                    "name" => $request->name,
                    "category_id" => $request->category_id,
                    "image" => $file,
                    "supplier_id" => $request->user['supplier_id'],


                ));
            } else {
                DB::table('product_sub_category')->insertGetId(array(

                    "name" => $request->name,
                    "category_id" => $request->category_id,
                    "image" => $file,
                    "supplier_id" => $request->user['supplier_id'],


                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function ProductUOM(Request $request)
    {

        $data =   DB::table("product_uom")->where("supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.product-uom", compact("data"));
    }

    public function SaveProductUOM(Request $request)
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
            if ($request->id) {
                DB::table('product_uom')->where("id", $request->id)->update(array(
                    "name" => $request->name,
                    "supplier_id" => $request->user['supplier_id'],
                ));
            } else {
                DB::table('product_uom')->insertGetId(array(
                    "name" => $request->name,
                    "supplier_id" => $request->user['supplier_id'],
                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }
    public function ProductGST(Request $request)
    {

        $data =   DB::table("product_gst")->where("supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.product-gst", compact("data"));
    }

    public function SaveProductGST(Request $request)
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
            if ($request->id) {
                DB::table('product_gst')->where("id", $request->id)->update(array(
                    "gst" => $request->gst,
                    "supplier_id" => $request->user['supplier_id'],
                ));
            } else {
                DB::table('product_gst')->insertGetId(array(
                    "gst" => $request->gst,
                    "supplier_id" => $request->user['supplier_id'],
                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function Products(Request $request)
    {

        $brand = DB::table("product_brand")->where("supplier_id", $request->user['supplier_id'])->get();
        $category = DB::table("product_category")->where("supplier_id", $request->user['supplier_id'])->get();
        $product_uom = DB::table("product_uom")->where("supplier_id", $request->user['supplier_id'])->get();
        $gst = DB::table("product_gst")->where("supplier_id", $request->user['supplier_id'])->get();

        $data = DB::table("products as a")
            ->select("a.*", "b.name as brand", "c.name as category", "d.name as sub_category", "e.name as uom")
            ->LeftJoin("product_brand as b", "a.brand_id", "b.id")
            ->join("product_category as c", "a.category_id", "c.id")
            ->join("product_sub_category as d", "a.sub_category_id", "d.id")
            ->join("product_uom as e", "a.uom_id", "e.id")
            ->where("a.supplier_id", $request->user['supplier_id'])->get();

        return view("suppliers.products", compact("data", "brand", "product_uom", "gst", "category"));
    }

    public function GetProductSubCategory(Request $request)
    {
        return DB::table("product_sub_category")->where("category_id", $request->category_id)->get();
    }


    public function SaveProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required',
            'category_id'      => 'required|integer|exists:product_category,id',
            'sub_category_id'  => 'required|integer|exists:product_sub_category,id',
            'base_price'       => 'required|numeric|min:0',
            'mrp'              => 'required|numeric|min:0',
            'gst'              => 'required|numeric|min:0|max:100',
            'uom_id'           => 'required|integer|exists:product_uom,id',

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
            if ($request->id) {
                $product_category =  DB::table("products")->where("id", $request->id)->first();
                $file = $product_category->image;
            }
        }

        try {
            if ($request->id) {
                DB::table('products')->where("id", $request->id)->update(array(

                    "name" => $request->name,
                    "image" => $file,
                    "brand_id" => $request->brand_id,
                    "category_id" => $request->category_id,
                    "sub_category_id" => $request->sub_category_id,
                    "base_price" => $request->base_price,
                    "mrp" => $request->mrp,
                    "gst" => $request->gst,
                    "cess_tax" => $request->cess_tax,
                    "discount" => $request->discount,
                    "article_no" => $request->article_no,
                    "hsn_code" => $request->hsn_code,
                    "uom_id" => $request->uom_id,
                    "min_stock" => $request->min_stock,
                    "description" => $request->description,
                    "tags" => $request->tags,
                    "supplier_id" => $request->user['supplier_id'],
                    "video_link" => $request->video_link,
                    "active" => $request->active,
                    // "is_deal" => $request->is_deal,
                    "qty" => $request->qty,


                ));
            } else {
                DB::table('products')->insertGetId(array(

                    "name" => $request->name,
                    "image" => $file,
                    "brand_id" => $request->brand_id,
                    "category_id" => $request->category_id,
                    "sub_category_id" => $request->sub_category_id,
                    "base_price" => $request->base_price,
                    "mrp" => $request->mrp,
                    "gst" => $request->gst,
                    "cess_tax" => $request->cess_tax,
                    "article_no" => $request->article_no,
                    "hsn_code" => $request->hsn_code,
                    "uom_id" => $request->uom_id,
                    "min_stock" => $request->min_stock,
                    "description" => $request->description,
                    "tags" => $request->tags,
                    "supplier_id" => $request->user['supplier_id'],
                    "video_link" => $request->video_link,
                    "active" => $request->active,
                     "discount" => $request->discount,
                    // "is_deal" => $request->is_deal,
                    "qty" => $request->qty,
                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function uploadMultipleImages(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'    => 'required',
            'files' => 'required',


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
        $filename = "";


        try {

            $files = $request->file('files');
            if ($files && is_array($files)) {
                foreach ($files as $fileItem) {
                    if ($fileItem && $fileItem->isValid()) {
                        $filename = time() . '_' . uniqid() . '.' . $fileItem->extension();
                        $fileItem->move(public_path('product images'), $filename);

                        DB::table('product_images')->insert([
                            "product_id" => $request->id,
                            "image" => $filename,
                        ]);
                    }
                }
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function Documents(Request $request)
    {
        $data = DB::table("documents")->get();
        return view("admin.documents", compact("data"));
    }

    public function SaveDocuments(Request $request)
    {
        $validator = Validator::make($request->all(), [


            'name' => 'required',
            'type' => 'required',


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
            if ($request->id) {
                DB::table('documents')->where("id", $request->id)->update(array(
                    "name" => $request->name,
                    "type" => $request->type,
                ));
            } else {
                DB::table('documents')->insertGetId(array(
                    "name" => $request->name,
                    "type" => $request->type,
                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function UpdateProductStatus(Request $request)
    {
        DB::table("products")->where("id", $request->id)->update(array("active" => $request->active));
    }
    public function UpdateProductIsdeal(Request $request)
    {
        DB::table("products")->where("id", $request->id)->update(array("is_deal" => $request->is_deal));
    }
    public function UpdateProductDiscount(Request $request)
    {
        DB::table("products")->where("id", $request->id)->update(array("is_discount" => $request->is_discount));
    }
}
