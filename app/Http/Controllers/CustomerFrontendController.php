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

class CustomerFrontendController extends Controller
{
    public function AddToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',

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
        $qty = 1;
        if ($request->btnQty) {
            $qty = $request->btnQty;
            $request->quantity  = $qty;
        }

        try {
            $products = DB::table("products")->where("id", $request->product_id)->first();
            if (!$products) {
                return redirect()->back()->with('error', "Product not found");
            }

            $cart =    DB::table("cart")->where("product_id", $request->product_id)->where("customer_id", $request->user['customer_id'])->first();
            if ($cart) {

                if ($request->qtyType == "plus") {
                    DB::table("cart")->where("product_id", $request->product_id)->where("customer_id", $request->user['customer_id'])->increment("qty", 1);
                } else if ($request->qtyType == "minus") {
                    DB::table("cart")->where("product_id", $request->product_id)->where("customer_id", $request->user['customer_id'])->decrement("qty", 1);
                    if ($cart->qty - 1 == 0) {
                        DB::table("cart")->where("product_id", $request->product_id)->where("customer_id", $request->user['customer_id'])->delete();
                    }
                } else {

                    if ($request->quantity <= 0 || empty($request->quantity)) {
                        DB::table("cart")->where("product_id", $request->product_id)->where("customer_id", $request->user['customer_id'])->delete();
                    }
                    DB::table("cart")->where("product_id", $request->product_id)->where("customer_id", $request->user['customer_id'])->update(array(
                        "product_id" => $request->product_id,
                        "qty" => $request->quantity,
                        "customer_id" => $request->user['customer_id'],
                    ));
                }
            } else {
                DB::table("cart")->insert(array(
                    "product_id" => $request->product_id,
                    "qty" => $qty,
                    "customer_id" => $request->user['customer_id'],
                ));
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function Cart(Request $request)
    {

        $data = DB::table("cart as a")
            ->select("a.*", "b.name", "b.base_price", "c.name as brand", "d.name as uom", "b.qty as prod_qty", "b.image", "b.id as product_id")
            ->join("products as b", "a.product_id", "b.id")
            ->leftJoin("product_brand as c", "b.brand_id", "c.id")
            ->join("product_uom as d", "b.uom_id", "d.id")
            ->where("customer_id", $request->user['customer_id'])->get();

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

        return view("frontend.cart", compact("data"));
    }

    public function Checkout(Request $request)
    {

        $cart =  DB::table("cart")->where("customer_id", $request->user['customer_id'])->get();
        if ($cart->isEmpty()) {
            return redirect("/")->with("error", "Cart is empty");
        }

        $data = DB::table("cart as a")
            ->select("a.*", "b.name", "b.base_price", "c.name as brand", "d.name as uom", "b.qty as prod_qty", "b.image", "b.id as product_id")
            ->join("products as b", "a.product_id", "b.id")
            ->leftJoin("product_brand as c", "b.brand_id", "c.id")
            ->join("product_uom as d", "b.uom_id", "d.id")
            ->where("customer_id", $request->user['customer_id'])->get();

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
        return view("frontend.checkout", compact("data", "customer_details"));
    }

    public function SaveOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'delivery_address' => 'required',
            'paymode' => 'required',

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

        DB::beginTransaction();
        try {


            $cart = DB::table("cart as a")
                ->select("a.*", "b.supplier_id", "b.base_price as mrp", "b.name as product", "b.description as description", "b.cess_tax", "b.gst")
                ->join("products as b", "a.product_id", "=", "b.id")
                ->where("a.customer_id", $request->user["customer_id"])
                ->get()
                ->groupBy("supplier_id");

            if ($cart->isEmpty()) {
                return redirect()->back()->with('error', 'Cart is empty');
            }


            foreach ($cart as $k => $v) {

                foreach ($v as $i => $j) {
                    $tiers = DB::table("product_price")
                        ->where("product_id", $j->product_id)
                        ->orderBy("qty", "asc")
                        ->get();


                    foreach ($tiers as $tier) {
                        if ($j->qty >= $tier->qty) {
                            $j->mrp = $tier->price;
                        }
                    }
                }
            }


            if ($request->delivery_address == "Office") {
                $customer =   DB::table("customers")->where("id", $request->user["customer_id"])->first();
            } else {
                $customer =   DB::table("customer_users")->where("id", $request->user["id"])->first();
            }
            $total_amount = 0;

            $invoice_no = 'INV-' . $request->user['customer_id'] . date('YmdHis');
            $order_id = DB::table("orders")->insertGetId(array(
                "customer_id" => $request->user['customer_id'],
                "invoice_no" => $invoice_no,
                "pay_mode" => $request->paymode,
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
            ));

            foreach ($cart as $supplier_id => $items) {
                $supplierSubtotal = $items->sum(fn($item) => $item->mrp * $item->qty);
                $OrderSupplier_id =  DB::table("orders_supplier")->insertGetId(array(
                    "order_id" => $order_id,
                    "supplier_id" => $supplier_id,
                    "subtotal" => $supplierSubtotal,
                    "shipping_status" => "pending",
                ));
                $gst_total = 0;
                $cess_total = 0;
                foreach ($items as $item) {

                    DB::table("orders_item")->insert(array(
                        "supplier_id" => $OrderSupplier_id,
                        "order_id" => $order_id,
                        "product_id" => $item->product_id,
                        "qty" => $item->qty,
                        "price" => $item->mrp,
                        "cess_tax" => $item->cess_tax,
                        "gst" => $item->gst,
                        "name" => $item->product,
                        "description" => $item->description,
                    ));
                    $gst_total += $item->mrp * $item->qty / 100 * $item->gst;
                    $cess_total += $item->mrp * $item->qty / 100 * $item->cess_tax;
                }
                DB::table("orders_supplier")->where("id", $OrderSupplier_id)->update(array(
                    "subtotal" => $supplierSubtotal + $gst_total + $cess_total,
                ));

                $total_amount += $supplierSubtotal + $gst_total + $cess_total;
            }

            DB::table('orders')->where('id', $order_id)->update([
                'total_amount' => $total_amount
            ]);
            if ($request->paymode == "wallet") {
                $customers =   DB::table("customers")->where("id", $request->user["customer_id"])->first();
                $total_amt = $total_amount + $customers->used_wallet;
                if ($total_amt > $customers->wallet) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "wallet amount is less then order amount");
                }

                DB::table('orders')->where('id', $order_id)->update([
                    'payment_status' => "Paid",
                ]);
                DB::table("customers")->where("id", $request->user['customer_id'])->increment("used_wallet", $total_amount);
            }
            DB::table("cart")->where("customer_id", $request->user['customer_id'])->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect("invoice/$OrderSupplier_id")->with("success", "Save Successfully");
    }


    public function Profile(Request $request)
    {

        $company = DB::table("customers")->where("id", $request->user["customer_id"])->first();
        $customer_details = DB::table("customer_users")->where("id", $request->user["id"])->first();
        $order_mst = DB::table("orders as a")
            ->select("a.*", "b.shipping_status as status", "b.subtotal", "b.id")
            ->join("orders_supplier as b", "a.id", "b.order_id")
            ->where("a.customer_id", $request->user["customer_id"])->orderBy("a.id", "desc")->get();

        $customer_document =  DB::table("customer_document")->where("customer_id", $request->user["customer_id"])->get();
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
            ->whereYear('created_at', date('Y')) // only this year
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month'); // gives [1 => 10, 2 => 5, ...]
        $monthlyOrders = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyOrders[] = $orders->get($m, 0); // get count or 0
        }



        $id = $request->user['customer_id'];
        $wallet_statement = DB::table(DB::raw("(
            SELECT id, created_at, amount, 'credit' as type, invoice_no, 'Sale (GST)' as particular, pay_date,pay_mode,remarks
            FROM wallet_ledger
            WHERE customer_id = $id
        
            UNION ALL
        
            SELECT id, created_at, total_amount as amount, 'debit' as type, invoice_no, 'Payment' as particular, created_at as pay_date,pay_mode, 'Order Generated' as remarks
            FROM orders
            WHERE customer_id = $id AND pay_mode = 'wallet'
        ) as wallet_union"))
            ->orderBy('created_at', 'asc')
            ->get();

        $balance = 0;
        foreach ($wallet_statement as $entry) {
            if ($entry->type === 'credit') {
                $balance += $entry->amount;
            } else if ($entry->type === 'debit') {
                $balance -= $entry->amount;
            }
            $entry->balance = -$balance;
        }
        return view("frontend.profile", compact("company", "customer_details", "order_mst", "customer_document", "order_count", "monthlyOrders", "wallet_statement"));
    }

    public function Logout(Request $request)
    {
        DB::table('customer_users')->where("web_token", session("web_token"))->update(array(
            'web_token' => "",

        ));
        return redirect("/")->with("success", "logout successfully");
    }

    public function UpdateCompanyDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',

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

            $file = "";
            if ($request->hasFile('file')) {
                $file = time() . '.' . $request->file('file')->extension();
                $request->file('file')->move('profile images', $file);
            } else {
                if ($request->id) {
                    $product_category =  DB::table("customers")->where("id", $request->user['customer_id'])->first();
                    $file = $product_category->image;
                }
            }


            DB::table("customers")->where("id", $request->user["customer_id"])->update(array(
                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
                "gst" => $request->gst,
                "address" => $request->address,
                "state" => $request->state,
                "district" => $request->district,
                "city" => $request->city,
                "pincode" => $request->pincode,
                "image" => $file,
            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function UpdateCustomerDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
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




            DB::table("customer_users")->where("id", $request->user["id"])->update(array(
                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,

                "address" => $request->address,
                "state" => $request->state,
                "district" => $request->district,
                "city" => $request->city,
                "pincode" => $request->pincode,
                "password" => $request->password,

            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function Invoice(Request $request, $id)
    {
        $order_mst = DB::table("orders as a")
            ->select("a.*", "b.shipping_status as status", "b.subtotal", "b.id")
            ->join("orders_supplier as b", "a.id", "b.order_id")
            ->where("b.id", $id)->orderBy("a.id", "desc")->first();
        $orders_item =  DB::table("orders_item")->where("supplier_id", $id)->get();
        return view("frontend.invoice", compact("order_mst", "orders_item"));
    }

    public function SignUp()
    {

        $suppliers = DB::table("suppliers")->where("active", 1)->get();
        return view("frontend.sign-up", compact("suppliers"));
    }



    public function SaveCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'number' => 'required|digits:10',
            'name' => 'required',
            'password' => 'required',
            'company_name' => 'required',
            'company_number' => 'required',
            'customer_type' => 'required',
            'type' => 'required',
            'supplier_id' => 'required',

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
            $customer_id = DB::table('customers')->insertGetId(array(

                "customer_type" => $request->customer_type,
                "type" => $request->type,
                "name" => $request->company_name,
                "number" => $request->company_number,
                "email" => $request->company_email,
                "gst" => $request->company_gst,
                "address" => $request->company_address,
                "state" => $request->company_state,
                "city" => $request->company_city,
                "district" => $request->company_district,
                "pincode" => $request->company_pincode,
                "supplier_id" => $request->supplier_id,
                "active" => 2,

            ));
            DB::table('customer_users')->insertGetId(array(
                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
                "address" => $request->address,
                "state" => $request->state,
                "city" => $request->city,
                "district" => $request->district,
                "pincode" => $request->pincode,
                "password" => $request->password,
                "customer_id" => $customer_id,
            ));

            $documents = DB::table('documents')->where('type', $request->type)->get();

            if ($documents->isNotEmpty()) {
                $customerDocuments = $documents->map(function ($doc) use ($customer_id) {
                    return [
                        'customer_id' => $customer_id,
                        'type'        => $doc->type,
                        'name'        => $doc->name,
                    ];
                })->toArray();

                DB::table('customer_document')->insert($customerDocuments);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
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

                if ($cart->qty - 1 <= 0) {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $request->user['customer_id'])
                        ->delete();
                }
            } else {
                // Direct quantity update
                if ($qty <= 0) {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $request->user['customer_id'])
                        ->delete();
                } else {
                    DB::table("cart")
                        ->where("product_id", $request->product_id)
                        ->where("customer_id", $request->user['customer_id'])
                        ->update([
                            "qty" => $qty,
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


    public function apiProducts(Request $request)
    {

        $category_id = request("category_id");
        $sub_category_id = request("sub_category_id");
        $brand_id = request("brand_id");
        $query = request("query");

        $token = session("web_token") ?? "";
        $customer_id = "";
        if ($token) {
            $customer_users = DB::table("customer_users")->where("web_token", $token)->first();
            $customer_id = $customer_users->customer_id;
        }


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
}
