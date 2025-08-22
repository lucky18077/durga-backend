<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Raw;
use League\Csv\Reader;


class BulkImport extends Controller
{
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
                $brand_id = null;
                $category_id = "";
                $sub_category_id = "";
                $unit_type_id = "";


                try {

                    if ($record[0] == "brand") {
                        continue;
                    }


                    $brand = DB::table("product_brand")->where("name", $record[0])->where("supplier_id", $request->user['supplier_id'])->first();
                    if ($brand) {
                        $brand_id = $brand->id;
                    } else if ($record[0]) {
                        $brand_id =  DB::table('product_brand')->insertGetId(array(
                            "name" => $record[0],
                            "supplier_id" => $request->user['supplier_id']

                        ));
                    }


                    $category = DB::table("product_category")->where("name", $record[1])->where("supplier_id", $request->user['supplier_id'])->first();
                    if ($category) {
                        $category_id = $category->id;
                    } else if ($record[1]) {

                        $category_id =  DB::table('product_category')->insertGetId(array(
                            "name" => $record[1],

                            "supplier_id" => $request->user['supplier_id']

                        ));
                    }

                    $sub_category = DB::table("product_sub_category")->where("name", $record[2])->where("supplier_id", $request->user['supplier_id'])->first();
                    if ($sub_category) {
                        $sub_category_id = $sub_category->id;
                    } else if ($record[2]) {
                        $sub_category_id =  DB::table('product_sub_category')->insertGetId(array(
                            "name" => $record[2],
                            "category_id" => $category_id,
                            "supplier_id" => $request->user['supplier_id']

                        ));
                    }

                    $unit_type = DB::table("product_uom")->where("name", $record[10])->where("supplier_id", $request->user['supplier_id'])->first();
                    if ($unit_type) {
                        $unit_type_id = $unit_type->id;
                    } else if ($record[10]) {
                        $unit_type_id =  DB::table('product_uom')->insertGetId(array(
                            "name" => $record[10],
                            "supplier_id" => $request->user['supplier_id']
                        ));
                    }



                    if ($record[3]) {
                        DB::table('products')->insertGetId(array(
                            "brand_id" => $brand_id,
                            "category_id" => $category_id,
                            "sub_category_id" => $sub_category_id,
                            "name" => $record[3],
                            "base_price" => $record[4],
                            "mrp" => $record[5],
                            "gst" => $record[6],
                            "cess_tax" => $record[7],
                            "article_no" => $record[8],
                            "hsn_code" => $record[9],
                            "uom_id" => $unit_type_id,
                            "min_stock" => $record[11],
                            "description" => $record[12],
                            "supplier_id" => $request->user['supplier_id'],
                        ));
                        $success++;
                    } else {
                        $error .= "Raw ID " . $count . " Product name not found. <br>";
                        $error_count++;
                    }
                } catch (\Throwable $th) {
                    $error .= "Raw ID " . $count . " Invalid format. " . $th->getMessage() . "<br>";
                    $error_count++;
                }
                $count++;
            }

            return redirect()->back()->with("success", "Save successfully - Total : " . $count - 1 . " Success : " . $success . "  Duplicate : " . $duplicate . " Error : " . $error_count)->with("msg", $error);
        }

        return redirect()->back()->with("error", "No csv file selected for upload");
    }
}
