<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function apiProducts()
    {
        $category_id = request("category_id");
        $sub_category_id = request("sub_category_id");
        $brand_id = request("brand_id");
        $query = request("query");

        $customer_id = optional(auth()->guard('customer')->user())->id; 

        $categories = DB::table("product_category")->get();

        $subCategories = DB::table("product_sub_category")
            ->where("category_id", $category_id)
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

        $products = $prod->paginate(50);

        foreach ($products as $key => $value) {
            $products[$key]->details = DB::table("product_price")->where("product_id", $value->id)->get();

            // Add cart quantity if user is logged in
            if ($customer_id) {
                $cartItem = DB::table("cart")
                    ->where("product_id", $value->id)
                    ->where("customer_id", $customer_id)
                    ->first();
                $products[$key]->cart_qty = $cartItem ? $cartItem->qty : 0;
            } else {
                $products[$key]->cart_qty = 0;
            }
        }

        return $products;
    }




    public function AddToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $qty = $request->btnQty ?? 1;
        $request->quantity = $qty;

        try {
            $product = DB::table("products")->where("id", $request->product_id)->first();
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => "Product not found"
                ], 404);
            }

            $cart = DB::table("cart")
                ->where("product_id", $request->product_id)
                ->where("customer_id", $request->user['customer_id'])
                ->first();

            if ($cart) {
                if ($request->qtyType === "plus") {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $request->user['customer_id'])
                        ->increment("qty", 1);
                } elseif ($request->qtyType === "minus") {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $request->user['customer_id'])
                        ->decrement("qty", 1);

                    if ($cart->qty - 1 == 0) {
                        DB::table("cart")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $request->user['customer_id'])
                            ->delete();
                    }
                } else {
                    if ($request->quantity <= 0 || empty($request->quantity)) {
                        DB::table("cart")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $request->user['customer_id'])
                            ->delete();
                    } else {
                        DB::table("cart")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $request->user['customer_id'])
                            ->update([
                                "qty" => $request->quantity,
                            ]);
                    }
                }
            } else {
                DB::table("cart")->insert([
                    "product_id" => $request->product_id,
                    "qty" => $qty,
                    "customer_id" => $request->user['customer_id'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
