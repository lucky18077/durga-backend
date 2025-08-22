<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Jenssegers\Agent\Agent;

class FrontEnd extends Controller
{
    public function Index(Request $request)
    {
        $data['slider'] = DB::table("sliders")->where("id", 1)->first();
        $data['slider1'] = DB::table("sliders1")->orderBy("id", "desc")->get();
        $data['slider2'] = DB::table("sliders2")->orderBy("id", "desc")->get();

        $data['products'] = DB::table("products as a")
            ->select("a.*", "b.name as uom")
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->limit(10)->get();
        $data['new_product'] = DB::table("products as a")
            ->select("a.*", "b.name as uom")
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->orderBy("a.id", "desc")
            ->limit(50)->get();
        $categories = DB::table("product_category")->get();
        $data['category'] = [];

        foreach ($categories as $category) {
            $subCategories = DB::table("product_sub_category")
                ->where("category_id", $category->id)
                ->get();

            if ($subCategories->isNotEmpty()) {
                $category->sub_categories = $subCategories;
                $data['category'][] = $category;
            }
        }


        $product_brand = DB::table("product_brand")->limit(16)->get();
        return view("frontend.index", compact("data", "product_brand"));
    }

    public function Shop(Request $request)
    {


        $category_id = request("category_id");
        $sub_category_id = request("sub_category_id");
        $brand_id = request("brand_id");
        $query = request("query");

        $categories = DB::table("product_category")->get();

        $subCategories = DB::table("product_sub_category")
            ->where("category_id", request("category_id"))
            ->get();

        $prod = DB::table("products as a")
            ->select("a.*", "b.name as uom", "c.name as category", "d.name as sub_category")
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->join("product_category as c", "a.category_id", "c.id")
            ->join("product_sub_category as d", "a.sub_category_id", "d.id")
            ->where("a.active", 1);

        if ($category_id) {
            $prod->where("a.category_id", $category_id);
        }
        if ($sub_category_id) {
            $prod->where("a.sub_category_id", $sub_category_id);
        }

        if ($brand_id) {
            $prod->where("a.brand_id", $brand_id);
        }

        if ($query) {
            $prod->where(function ($q) use ($query) {
                $q->where('a.name', 'like', '%' . $query . '%')
                    ->orWhere('a.description', 'like', '%' . $query . '%')
                    ->orWhere('c.name', 'like', '%' . $query . '%')
                    ->orWhere('d.name', 'like', '%' . $query . '%')
                    ->orWhere('a.tags', 'like', '%' . $query . '%');
            });
        }
        $products = $prod->get();

        foreach ($products as $key => $value) {
            $products[$key]->details = DB::table("product_price")->where("product_id", $value->id)->get();
        }

        // Handle customer pricing
        $web_token = session('web_token');
        if ($web_token) {
            $customer = DB::table("customer_users")->where("web_token", $web_token)->first();

            if ($customer) {
                foreach ($products as $key => $value) {
                    $cart = DB::table("cart")
                        ->where("customer_id", $customer->customer_id)
                        ->where("product_id", $value->id)
                        ->first();

                    if ($cart) {
                        // Apply the best eligible price based on quantity
                        $eligible_price = null;
                        foreach ($products[$key]->details as $tier) {
                            if ($cart->qty >= $tier->qty) {
                                $eligible_price = $tier->price;
                            }
                        }

                        if ($eligible_price !== null) {
                            $products[$key]->mrp = $eligible_price;
                        }
                    }
                }
            }
        }


        return view("frontend.shop", compact("categories", "subCategories", "products"));
    }

    public function ProductDetails(Request $request, $id)
    {




        $product = DB::table("products as a")
            ->select("a.*", "b.name as uom", "c.name as category", "d.name as sub_category")
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->join("product_category as c", "a.category_id", "c.id")
            ->join("product_sub_category as d", "a.sub_category_id", "d.id")
            ->where("a.id", $id)
            ->where("a.active", 1)
            ->first();
        if (!$product) {
            return redirect()->back()->with("error", "Product not found");
        }


        $product->details =  DB::table("product_price")->where("product_id", $product->id)->get();

        $web_token = session('web_token');
        if ($web_token) {
            $customer = DB::table("customer_users")->where("web_token", $web_token)->first();
            if ($customer) {


                $cart = DB::table("cart")->where("customer_id", $customer->customer_id)->where("product_id", $id)->first();
                if ($cart) {
                    foreach ($product->details as $tier) {
                        if ($cart->qty >= $tier->qty) {
                            $product->mrp = $tier->price;
                        }
                    }
                }
            }
        }




        $supplier = DB::table("suppliers")->where("id", $product->supplier_id)->first();

        $related_products = DB::table("products as a")
            ->select("a.*", "b.name as uom", "c.name as category", "d.name as sub_category")
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->join("product_category as c", "a.category_id", "c.id")
            ->join("product_sub_category as d", "a.sub_category_id", "d.id")
            ->where("a.sub_category_id", $product->sub_category_id)
            ->get();
        $images = DB::table("product_images")->where("product_id", $id)->get();
        // echo "<pre>";
        // print_r($product);

        // die;
        return view("frontend.product-details", compact("product", "supplier", "related_products", "images"));
    }
}
