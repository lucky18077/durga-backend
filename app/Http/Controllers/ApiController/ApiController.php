<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function getCategory(Request $request)
    {
        $categories = DB::table('product_category')
            ->select('id', 'name', 'image')
            ->where('supplier_id', 1)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Category list retrieved successfully.',
            'data' => $categories
        ]);
    }

    public function getSubCategory(Request $request)
    {
        $categories = DB::table('product_sub_category')
            ->select('id', 'category_id', 'name', 'image')
            ->where('supplier_id', 1)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Sub Category list Retrieved Successfully.',
            'data' => $categories
        ]);
    }
    public function getBrands(Request $request)
    {
        $brands = DB::table('product_brand')
            ->select('id', 'name', 'image')
            ->where('supplier_id', 1)
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Brands list retrieved successfully.',
            'data' => $brands
        ]);
    }

    public function getProducts(Request $request)
    {
        $category_id = $request->input("category_id");
        $sub_category_id = $request->input("sub_category_id");
        $brand_id = $request->input("brand_id");
        $query = $request->input("query");
        $productsQuery = DB::table("products as a")
            ->select(
                "a.*",
                "b.name as uom",
                "c.name as category",
                "d.name as sub_category",
                "e.name as brand"
            )
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->join("product_category as c", "a.category_id", "c.id")
            ->join("product_sub_category as d", "a.sub_category_id", "d.id")
            ->leftJoin("product_brand as e", "a.brand_id", "e.id")
            ->where("a.active", 1);
        if ($category_id) {
            $productsQuery->where("a.category_id", $category_id);
        }
        if ($sub_category_id) {
            $productsQuery->where("a.sub_category_id", $sub_category_id);
        }
        if ($brand_id) {
            $productsQuery->where("a.brand_id", $brand_id);
        }
        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('a.name', 'like', '%' . $query . '%')
                    ->orWhere('a.description', 'like', '%' . $query . '%')
                    ->orWhere('c.name', 'like', '%' . $query . '%')
                    ->orWhere('d.name', 'like', '%' . $query . '%')
                    ->orWhere('a.tags', 'like', '%' . $query . '%');
            });
        }
        $products = $productsQuery->paginate(50);
        foreach ($products as $product) {
            $product->details = DB::table("product_price")
                ->where("product_id", $product->id)
                ->get();
        }
        return response()->json([
            'status' => true,
            'message' => 'All products retrieved successfully.',
            'data' => $products
        ]);
    }

    public function getAllProducts()
    {
        $category_id = request("category_id");
        $sub_category_id = request("sub_category_id");
        $brand_id = request("brand_id");
        $query = request("search");

        $customer_id = "";

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

    public function getproduct(Request $request)
    {
        $customer_id = $request->user['customer_id'] ?? null;

        if (!$customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'Customer ID not found in request.',
            ], 401);
        }

        // Get wishlist product IDs
        $wishlistIds = DB::table('wishlist')
            ->where('customer_id', $customer_id)
            ->pluck('product_id');

        if ($wishlistIds->isEmpty()) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        // Fetch products in wishlist
        $products = DB::table('products as a')
            ->select('a.*', 'b.name as uom', 'c.name as category', 'd.name as sub_category')
            ->join('product_uom as b', 'a.uom_id', 'b.id')
            ->join('product_category as c', 'a.category_id', 'c.id')
            ->join('product_sub_category as d', 'a.sub_category_id', 'd.id')
            ->whereIn('a.id', $wishlistIds)
            ->where('a.active', 1)
            ->get();

        // Add details and cart quantity
        foreach ($products as $key => $product) {
            $products[$key]->details = DB::table('product_price')
                ->where('product_id', $product->id)
                ->get();

            $cartItem = DB::table('cart')
                ->where('product_id', $product->id)
                ->where('customer_id', $customer_id)
                ->first();

            $products[$key]->cart_qty = $cartItem ? $cartItem->qty : 0;
        }

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function ProductDetailsApi(Request $request, $id)
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
            return response()->json([
                "status" => false,
                "message" => "Product not found"
            ], 404);
        }

        $product->details = DB::table("product_price")->where("product_id", $product->id)->get();

        $web_token = $request->header('web_token') ?? session('web_token');

        if ($web_token) {
            $customer = DB::table("customer_users")->where("web_token", $web_token)->first();
            if ($customer) {
                $cart = DB::table("cart")
                    ->where("customer_id", $customer->customer_id)
                    ->where("product_id", $id)
                    ->first();

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
            ->where("a.active", 1)
            ->get();

        $images = DB::table("product_images")->where("product_id", $id)->get();

        return response()->json([
            "status" => true,
            "message" => "Product details fetched successfully",
            "data" => [
                "product" => $product,
                "supplier" => $supplier,
                "related_products" => $related_products,
                "images" => $images
            ]
        ], 200);
    }

    public function shopAddToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'qty' => 'nullable|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $qty = $request->qty ?? 1;

        $customerId = $request->user['customer_id'] ?? null;
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Customer ID not found.',
            ], 401);
        }

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
                ->where("customer_id", $customerId)
                ->first();

            if ($cart) {
                if ($request->qtyType === "plus") {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $customerId)
                        ->increment("qty", 1);
                } elseif ($request->qtyType === "minus") {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $customerId)
                        ->decrement("qty", 1);

                    if ($cart->qty - 1 <= 0) {
                        DB::table("cart")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $customerId)
                            ->delete();
                    }
                } else {
                    if ($qty <= 0) {
                        DB::table("cart")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $customerId)
                            ->delete();
                    } else {
                        DB::table("cart")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $customerId)
                            ->update([
                                "qty" => $qty,
                            ]);
                    }
                }
            } else {
                DB::table("cart")->insert([
                    "product_id" => $request->product_id,
                    "qty" => $qty,
                    "customer_id" => $customerId,
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

    public function shopAddToWhishlist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            // 'qty' => 'nullable|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $qty = $request->qty ?? 1;

        $customerId = $request->user['customer_id'] ?? null;
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Customer ID not found.',
            ], 401);
        }

        try {
            $product = DB::table("products")->where("id", $request->product_id)->first();
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => "Product not found"
                ], 404);
            }

            $cart = DB::table("wishlist")
                ->where("product_id", $request->product_id)
                ->where("customer_id", $customerId)
                ->first();

            if ($cart) {
                if ($request->qtyType === "plus") {
                    DB::table("wishlist")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $customerId)
                        ->increment("qty", 1);
                } elseif ($request->qtyType === "minus") {
                    DB::table("wishlist")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $customerId)
                        ->decrement("qty", 1);

                    if ($cart->qty - 1 <= 0) {
                        DB::table("wishlist")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $customerId)
                            ->delete();
                    }
                } else {
                    if ($qty <= 0) {
                        DB::table("wishlist")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $customerId)
                            ->delete();
                    } else {
                        DB::table("wishlist")
                            ->where("product_id", $request->product_id)
                            ->where("customer_id", $customerId)
                            ->update([
                                "qty" => $qty,
                            ]);
                    }
                }
            } else {
                DB::table("wishlist")->insert([
                    "product_id" => $request->product_id,
                    "qty" => $qty,
                    "customer_id" => $customerId,
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
    public function cartApi(Request $request)
    {
        try {
            $customer_id = $request->user['customer_id'] ?? null;

            if (!$customer_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer ID not found in request.',
                ], 401);
            }

            $data = DB::table("cart as a")
                ->select(
                    "a.*",
                    "b.name",
                    "b.base_price",
                    "c.name as brand",
                    "d.name as uom",
                    "b.qty as prod_qty",
                    "b.image",
                    "b.gst",
                    "b.cess_tax",
                    "b.id as product_id"
                )
                ->join("products as b", "a.product_id", "b.id")
                ->leftJoin("product_brand as c", "b.brand_id", "c.id")
                ->join("product_uom as d", "b.uom_id", "d.id")
                ->where("a.customer_id", $customer_id)
                ->where("a.qty", ">", 0)
                ->get();
            foreach ($data as $item) {
                $tiers = DB::table("product_price")
                    ->where("product_id", $item->product_id)
                    ->orderBy("qty", "asc")
                    ->get();
                $item->details = $tiers;
                foreach ($tiers as $tier) {
                    if ($item->qty >= $tier->qty) {
                        $item->mrp = $tier->price;
                    }
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Cart data fetched successfully.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function whishList(Request $request)
    {
        try {
            $customer_id = $request->user['customer_id'] ?? null;

            if (!$customer_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer ID not found in request.',
                ], 401);
            }

            $data = DB::table("wishlist as a")
                ->select(
                    "a.*",
                    "b.name",
                    "b.base_price",
                    "c.name as brand",
                    "d.name as uom",
                    "b.qty as prod_qty",
                    "b.image",
                    "b.gst",
                    "b.mrp",
                    "b.cess_tax",
                    "b.id as product_id"
                )
                ->join("products as b", "a.product_id", "b.id")
                ->leftJoin("product_brand as c", "b.brand_id", "c.id")
                ->join("product_uom as d", "b.uom_id", "d.id")
                ->where("a.customer_id", $customer_id)
                ->where("a.qty", ">", 0)
                ->get();
            foreach ($data as $item) {
                $tiers = DB::table("product_price")
                    ->where("product_id", $item->product_id)
                    ->orderBy("qty", "asc")
                    ->get();
                $item->details = $tiers;
                foreach ($tiers as $tier) {
                    if ($item->qty >= $tier->qty) {
                        $item->mrp = $tier->price;
                    }
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Cart data fetched successfully.',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getCartByCustomer(Request $request)
    {
        $customer_id = $request->user['customer_id'];

        $cartItems = DB::table('cart')
            ->select('product_id', 'qty')
            ->where('customer_id', $customer_id)
            ->get();

        $totalQty = $cartItems->count('product_id');

        return response()->json([
            'cart_items' => $cartItems,
            'total_qty' => $totalQty
        ]);
    }
    public function apiLogout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token not provided.'], 401);
        }
        $user = DB::table('customer_users')->where('web_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }
        DB::table('customer_users')
            ->where('id', $user->id)
            ->update(['web_token' => '']);
        return response()->json(['message' => 'Logout successful.'], 200);
    }

    public function Checkout(Request $request)
    {
        $cart = DB::table("cart")->where("customer_id", $request->user['customer_id'])->get();

        if ($cart->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Cart is empty",
                "data" => []
            ], 200);
        }

        $data = DB::table("cart as a")
            ->select(
                "a.*",
                "b.name",
                "b.base_price",
                "c.name as brand",
                "d.name as uom",
                "b.qty as prod_qty",
                "b.image",
                "b.gst",
                "b.cess_tax",
                "b.id as product_id"
            )
            ->join("products as b", "a.product_id", "b.id")
            ->leftJoin("product_brand as c", "b.brand_id", "c.id")
            ->join("product_uom as d", "b.uom_id", "d.id")
            ->where("customer_id", $request->user['customer_id'])
            ->get();

        foreach ($data as $item) {
            $tiers = DB::table("product_price")
                ->where("product_id", $item->product_id)
                ->orderBy("qty", "asc")
                ->get();

            foreach ($tiers as $tier) {
                if ($item->qty >= $tier->qty) {
                    $item->mrp = $tier->price;
                }
            }
        }

        $customer_details = DB::table("customers as a")
            ->select(
                "a.*",
                "b.name as customer_name",
                "b.number as customer_number",
                "b.email as customer_email",
                "b.address as customer_address",
                "b.state as customer_state",
                "b.district as customer_district",
                "b.city as customer_city",
                "b.pincode as customer_pincode"
            )
            ->join("customer_users as b", "a.id", "=", "b.customer_id")
            ->where("b.customer_id", $request->user['customer_id'])
            ->first();

        return response()->json([
            "status" => true,
            "message" => "Checkout data fetched successfully",
            "data" => [
                "cart_items" => $data,
                "customer_details" => $customer_details
            ]
        ], 200);
    }

    public function SaveOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_address' => 'required',
            // 'paymode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $cart = DB::table("cart as a")
                ->select("a.*", "b.supplier_id", "b.base_price as mrp", "b.name as product", "b.description", "b.cess_tax", "b.gst")
                ->join("products as b", "a.product_id", "=", "b.id")
                ->where("a.customer_id", $request->user["customer_id"])
                ->get()
                ->groupBy("supplier_id");

            if ($cart->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart is empty.'
                ], 400);
            }

            // Tier pricing
            foreach ($cart as $k => $v) {
                foreach ($v as $item) {
                    $tiers = DB::table("product_price")
                        ->where("product_id", $item->product_id)
                        ->orderBy("qty", "asc")
                        ->get();

                    foreach ($tiers as $tier) {
                        if ($item->qty >= $tier->qty) {
                            $item->mrp = $tier->price;
                        }
                    }
                }
            }

            $customer = $request->delivery_address === "Office"
                ? DB::table("customers")->where("id", $request->user["customer_id"])->first()
                : DB::table("customer_users")->where("id", $request->user["id"])->first();

            $total_amount = 0;
            $invoice_no = 'INV-' . $request->user['customer_id'] . date('YmdHis');

            $order_id = DB::table("orders")->insertGetId([
                "customer_id" => $request->user['customer_id'],
                "invoice_no" => $invoice_no,
                "pay_mode" => "wallet",
                // "pay_mode" => $request->paymode,
                "payment_status" => "Pending",
                "order_status" => "Pending",
                "total_amount" => $total_amount,
                "name" => $customer->name,
                "number" => $customer->number,
                "email" => $customer->email,
                "address" => $customer->address,
                "state" => $customer->state,
                "district" => $customer->district,
                "city" => $customer->city,
                "pincode" => $customer->pincode,
            ]);

            foreach ($cart as $supplier_id => $items) {
                $supplierSubtotal = $items->sum(fn($item) => $item->mrp * $item->qty);

                $orderSupplierId = DB::table("orders_supplier")->insertGetId([
                    "order_id" => $order_id,
                    "supplier_id" => $supplier_id,
                    "subtotal" => $supplierSubtotal,
                    "shipping_status" => "pending",
                ]);

                $gst_total = 0;
                $cess_total = 0;

                foreach ($items as $item) {
                    DB::table("orders_item")->insert([
                        "supplier_id" => $orderSupplierId,
                        "order_id" => $order_id,
                        "product_id" => $item->product_id,
                        "qty" => $item->qty,
                        "price" => $item->mrp,
                        "cess_tax" => $item->cess_tax,
                        "gst" => $item->gst,
                        "name" => $item->product,
                        "description" => $item->description,
                    ]);

                    $gst_total += $item->mrp * $item->qty * $item->gst / 100;
                    $cess_total += $item->mrp * $item->qty * $item->cess_tax / 100;
                }

                DB::table("orders_supplier")->where("id", $orderSupplierId)->update([
                    "subtotal" => $supplierSubtotal + $gst_total + $cess_total,
                ]);

                $total_amount += $supplierSubtotal + $gst_total + $cess_total;
            }

            DB::table('orders')->where('id', $order_id)->update([
                'total_amount' => $total_amount
            ]);

            // if ($request->paymode == "wallet") {
            //     $customer = DB::table("customers")->where("id", $request->user["customer_id"])->first();
            //     $total_with_used = $total_amount + $customer->used_wallet;

            //     if ($total_with_used > $customer->wallet) {
            //         DB::rollBack();
            //         return response()->json([
            //             'status' => false,
            //             'message' => 'Wallet amount is less than order total.'
            //         ], 400);
            //     }

            //     DB::table('orders')->where('id', $order_id)->update([
            //         'payment_status' => "Paid"
            //     ]);

            //     DB::table("customers")->where("id", $request->user['customer_id'])->increment("used_wallet", $total_amount);
            // }
            if (true) {
                $customer = DB::table("customers")->where("id", $request->user["customer_id"])->first();
                $total_with_used = $total_amount + $customer->used_wallet;

                if ($total_with_used > $customer->wallet) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Wallet amount is less than order total.'
                    ], 400);
                }

                DB::table('orders')->where('id', $order_id)->update([
                    'payment_status' => "Paid"
                ]);

                DB::table("customers")->where("id", $request->user['customer_id'])->increment("used_wallet", $total_amount);
            }

            // Clear cart
            DB::table("cart")->where("customer_id", $request->user['customer_id'])->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order placed successfully.',
                'order_id' => $order_id,
                'invoice_no' => $invoice_no
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getInvoiceData(Request $request, $id)
    {
        $order_mst = DB::table("orders as a")
            ->select("a.*", "b.shipping_status as status", "b.subtotal", "b.id")
            ->join("orders_supplier as b", "a.id", "b.order_id")
            ->where("b.id", $id)
            ->orderBy("a.id", "desc")
            ->first();

        if (!$order_mst) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $orders_item = DB::table("orders_item as oi")
            ->select(
                "oi.*",
                "p.hsn_code",
                "p.name as product_name",
                "u.name as uom_name"
            )
            ->join("products as p", "oi.product_id", "=", "p.id")
            ->leftJoin("product_uom as u", "p.uom_id", "=", "u.id")
            ->where("oi.supplier_id", $id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Invoice data fetched successfully',
            'data' => [
                'order_mst' => $order_mst,
                'orders_item' => $orders_item,
            ]
        ]);
    }
    public function removeItem(Request $request)
    {
        try {
            $customer_id = $request->user['id'];
            $productId = $request->input('product_id');

            if (!$productId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product ID is required'
                ], 400);
            }

            DB::table('cart')
                ->where('customer_id', $customer_id)
                ->where('product_id', $productId)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removewishlist(Request $request)
    {
        try {
            $id = $request->input('product_id');
            if (!$id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product ID is required'
                ], 400);
            }

            DB::table('wishlist')
                ->where('product_id', $id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function customerProfileApi(Request $request)
    {
        $company = DB::table("customers")
            ->where("id", $request->user["customer_id"])
            ->first();

        $customer_details = DB::table("customer_users")
            ->where("id", $request->user["id"])
            ->first();

        $order_mst = DB::table("orders as a")
            ->select("a.*", "b.shipping_status as status", "b.subtotal", "b.id")
            ->join("orders_supplier as b", "a.id", "b.order_id")
            ->where("a.customer_id", $request->user["customer_id"])
            ->orderBy("a.id", "desc")
            ->get();

        $customer_document = DB::table("customer_document")
            ->where("customer_id", $request->user["customer_id"])
            ->get();

        $order_count = DB::table("orders")
            ->selectRaw("
            COUNT(*) as total_order,
            SUM(CASE WHEN order_status = 'pending' THEN 1 ELSE 0 END) as pending_order,
            SUM(CASE WHEN order_status = 'complete' THEN 1 ELSE 0 END) as complete_order
        ")
            ->where("customer_id", $request->user['customer_id'])
            ->first();

        $orders = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('customer_id', $request->user['customer_id'])
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $monthlyOrders = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyOrders[] = $orders->get($m, 0);
        }

        $id = $request->user['customer_id'];

        $wallet_statement = DB::table(DB::raw("(
        SELECT id, created_at, amount, 'credit' as type, invoice_no, 'Sale (GST)' as particular, pay_date, pay_mode, remarks
        FROM wallet_ledger
        WHERE customer_id = $id
    
        UNION ALL
    
        SELECT id, created_at, total_amount as amount, 'debit' as type, invoice_no, 'Payment' as particular, created_at as pay_date, pay_mode, 'Order Generated' as remarks
        FROM orders
        WHERE customer_id = $id AND pay_mode = 'wallet'
    ) as wallet_union"))
            ->orderBy('created_at', 'asc')
            ->get();

        $balance = 0;
        foreach ($wallet_statement as $entry) {
            if ($entry->type === 'credit') {
                $balance += $entry->amount;
            } elseif ($entry->type === 'debit') {
                $balance -= $entry->amount;
            }
            $entry->balance = -$balance;
        }

        return response()->json([
            'status' => true,
            'data' => [
                'company' => $company,
                'customer_details' => $customer_details,
                'order_mst' => $order_mst,
                'customer_document' => $customer_document,
                'order_count' => $order_count,
                'monthlyOrders' => $monthlyOrders,
                'wallet_statement' => $wallet_statement
            ]
        ]);
    }
    public function dealOnDay(Request $request)
    {
        $category_id = $request->category_id;
        $sub_category_id = $request->sub_category_id;

        $query = DB::table("products as a")
            ->select("a.*", "b.name as uom", "c.name as category", "d.name as sub_category")
            ->join("product_uom as b", "a.uom_id", "b.id")
            ->join("product_category as c", "a.category_id", "c.id")
            ->join("product_sub_category as d", "a.sub_category_id", "d.id")
            ->where("a.active", 1)
            ->where("a.is_deal", 1);

        if ($category_id) {
            $query->where("a.category_id", $category_id);
        }

        if ($sub_category_id) {
            $query->where("a.sub_category_id", $sub_category_id);
        }
        $products = $query->get();

        foreach ($products as $key => $value) {
            $value->details = DB::table("product_price")
                ->where("product_id", $value->id)
                ->get();
        }

        return response()->json($products);
    }


    public function SlidersApi(Request $request)
    {
        try {
            $data = DB::table("sliders")->first();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching sliders',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function BannerApi(Request $request)
    {
        try {
            $data = DB::table("sliders1")->orderBy("id", "desc")->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching sliders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function FooterBannerApi(Request $request)
    {
        try {
            $data = DB::table("sliders2")->orderBy("id", "desc")->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching sliders',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
