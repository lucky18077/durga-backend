<?php

namespace App\Http\Controllers;

use App\Models\SupplierRole;
use App\Models\SupplierUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Jenssegers\Agent\Agent;
use Yajra\DataTables\Facades\DataTables;


class Supplier extends Controller
{
    public function Dashboard(Request $request)
    {
        return view("suppliers.dashboard");
    }

    public function Customers(Request $request, $id)
    {

        $data = DB::table('customers')->where("supplier_id", $request->user['supplier_id'])->orderBy("id", "desc")->where("active", $id)->get();
        return view("suppliers.customers", compact("data"));
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
                "supplier_id" => $request->user['supplier_id'],

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

    public function Profile(Request $request)
    {
        $data = DB::table("supplier_users")->where("id", $request->user['id'])->first();
        return view("suppliers.profile", compact("data"));
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


            DB::table('supplier_users')->where("id", $request->user['id'])->update(array(

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


    public function CustomerProfile(Request $request, $id)
    {
        $data = DB::table("customers")->where("id", $id)->first();
        $user = DB::table("customer_users")->where("customer_id", $id)->first();
        $documents = DB::table("customer_document")->where("customer_id", $id)->get();

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

        // echo "<pre>";
        // print_r($wallet_statement);
        // die;

        return view("suppliers.customer-profile", compact("data", "user", "documents", "wallet_statement"));
    }

    public function UpdateCompanyDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_number' => 'required',
            'customer_type' => 'required',
            'type' => 'required',
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

            DB::table('customers')->where("id", $request->id)->update(array(

                "type" => $request->type,
                "customer_type" => $request->customer_type,
                "name" => $request->company_name,
                "number" => $request->company_number,
                "email" => $request->company_email,
                "gst" => $request->company_gst,
                "address" => $request->company_address,
                "state" => $request->company_state,
                "city" => $request->company_city,
                "district" => $request->company_district,
                "pincode" => $request->company_pincode,
                "active" => $request->active,
                "supplier_id" => $request->user['supplier_id'],

            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function UpdatePersonalDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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

            DB::table('customer_users')->where("id", $request->id)->update(array(

                "name" => $request->name,
                "number" => $request->number,
                "email" => $request->email,
                "address" => $request->address,
                "state" => $request->state,
                "city" => $request->city,
                "district" => $request->district,
                "pincode" => $request->pincode,

            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function UploadDocument(Request $request)
    {



        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('documents', $file);
        } else {
            if ($request->id) {
                $product_category =  DB::table("customer_document")->where("id", $request->id)->first();
                $file = $product_category->file;
            }
        }

        try {

            DB::table('customer_document')->where("id", $request->id)->update(array(

                "file" => $file,
                "remarks" => $request->remarks,


            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function UploadAgreement(Request $request)
    {
        $file = "";
        if ($request->hasFile('file')) {
            $file = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move('documents', $file);
        } else {
            if ($request->id) {
                $product_category =  DB::table("customer_document")->where("id", $request->id)->first();
                $file = $product_category->file;
            }
        }

        try {

            DB::table('customers')->where("id", $request->id)->update(array(

                "agreement" => $file,
                "agreement_remarks" => $request->agreement_remarks,
                "active" => 1,


            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function UploadWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'wallet' => 'required',
            'due_date' => 'required',
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

            DB::table('customers')->where("id", $request->id)->update(array(


                "wallet" => $request->wallet,
                "due_date" => $request->due_date,


            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function GetProductPrices(Request $request)
    {

        return DB::table("product_price")->where("product_id", $request->id)->get();
    }

    public function DeleteProductPrice(Request $request)
    {
        try {
            DB::table("product_price")->where("id", $request->id)->delete();
            return response()->json(["msg" => "Save successfully", "error" => "success"]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => $th->getMessage(), "error" => "error"]);
        }
    }

    public function AddProductPrice(Request $request)
    {
        try {
            DB::table("product_price")->insert(array(
                "product_id" => $request->product_id,
                "price" => $request->product_price,
                "qty" => $request->product_qty,
            ));
            return response()->json(["msg" => "Save successfully", "error" => "success"]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => $th->getMessage(), "error" => "error"]);
        }
    }




    public function Orders(Request $request, $status)
    {
        $data =  DB::table("orders_supplier as a")
            ->select("b.*", "a.subtotal", "a.shipping_status as status", "b.id", "a.id as supplier_order_id")
            ->join("orders as b", "a.order_id", "b.id")
            ->where("a.supplier_id", $request->user['supplier_id'])
            ->where("a.shipping_status", $status)
            ->orderBy("a.id", "desc")->get();

        $suppliers = DB::table("supplier_users")->whereIn("id", $request->userIds)->get();
        return view("suppliers.orders", compact("data", "suppliers"));
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

        return view("suppliers.order-details", compact("orders", "det"));
    }

    public function UpdateOrderStatus(Request $request)
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

            DB::table('orders_supplier')->where("id", $request->id)->update(array(
                "shipping_status" => $request->status,
                "user_id" => $request->user_id,
            ));
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function AddWalletLedger(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'amount' => 'required',
            'pay_mode' => 'required',
            'pay_date' => 'required',

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
            $invoice_no = 'VOU-' . $request->customer_id . date('YmdHis');

            DB::table('wallet_ledger')->insert(array(
                'customer_id' => $request->customer_id,
                'amount' => $request->amount,
                'pay_mode' => $request->pay_mode,
                'pay_date' => $request->pay_date,
                'supplier_id' => $request->user['supplier_id'],
                'invoice_no' => $invoice_no,
                "remarks" => $request->remarks
            ));
            $orders = DB::table("orders")->where("customer_id", $request->customer_id)->first();
            if ($orders) {
                DB::table("customers")->where("id", $request->customer_id)->decrement("used_wallet", $request->amount);
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function WalletManagement(Request $request)
    {
        $data =  DB::table("customers")->where("supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.wallet-management", compact("data"));
    }


    public function UserRole(Request $request)
    {
        $data = SupplierRole::where("supplier_id", $request->user['supplier_id'])->get();
        return view("suppliers.user-role", compact("data"));
    }
    public function saveUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'app_permission' => 'required',
        ]);


        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {

            if ($request->id) {
                $supplierRole =  SupplierRole::findOrFail($request->id);
                $supplierRole->name = $request->name;
                $supplierRole->app_permission = $request->app_permission;
                $supplierRole->save();
            } else {
                $supplierRole = new SupplierRole();
                $supplierRole->name = $request->name;
                $supplierRole->app_permission = $request->app_permission;
                $supplierRole->supplier_id = $request->user["supplier_id"];
                $supplierRole->save();
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }


    public function users(Request $request)
    {
        $data   = SupplierUsers::where("supplier_id", $request->user["supplier_id"])->where("parent_id", '!=', 0)->get();
        $supplierRole = SupplierRole::where("supplier_id", $request->user['supplier_id'])->get();
        $parents = SupplierUsers::where("supplier_id", $request->user["supplier_id"])->get();
        return view("suppliers.users", compact("data", "supplierRole", "parents"));
    }

    public function updateSupplierUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'number' => 'required',
            'password' => 'required',
            'role_id' => 'required',
            'parent_id' => 'required',
        ]);


        if ($validator->fails()) {

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            if ($request->id) {
                $supplierRole =  SupplierUsers::findOrFail($request->id);
                $supplierRole->name = $request->name;
                $supplierRole->number = $request->number;
                $supplierRole->email = $request->email;
                $supplierRole->address = $request->address;
                $supplierRole->state = $request->state;
                $supplierRole->city = $request->city;
                $supplierRole->district = $request->district;
                $supplierRole->pincode = $request->pincode;
                $supplierRole->password = $request->password;
                $supplierRole->parent_id = $request->parent_id;
                $supplierRole->role_id = $request->role_id;
                $supplierRole->save();
            } else {
                $supplierRole =  new SupplierUsers();
                $supplierRole->name = $request->name;
                $supplierRole->number = $request->number;
                $supplierRole->email = $request->email;
                $supplierRole->address = $request->address;
                $supplierRole->state = $request->state;
                $supplierRole->city = $request->city;
                $supplierRole->district = $request->district;
                $supplierRole->pincode = $request->pincode;
                $supplierRole->password = $request->password;
                $supplierRole->parent_id = $request->parent_id;
                $supplierRole->role_id = $request->role_id;
                $supplierRole->supplier_id = $request->user["supplier_id"];
                $supplierRole->save();
            }
        } catch (Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }

        return  redirect()->back()->with("success", "Save Successfully");
    }

    public function logout(Request $request)
    {

        DB::table('supplier_users')->where("token", session("token"))->update(array(
            'token' => "",
        ));
        session()->flush();
        return redirect("supplier/")->with("success", "logout successfully");
    }


    public function getMultipleImages(Request $request)
    {
        return DB::table("product_images")->where("product_id", $request->id)->get();
    }

    public function deleteImage(Request $request)
    {
        DB::table("product_images")->where("id", $request->id)->delete();
    }

    public function getProduct(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table("products as a")
                ->select("a.*", "b.name as brand", "c.name as category", "d.name as sub_category", "e.name as uom")
                ->leftJoin("product_brand as b", "a.brand_id", "b.id")
                ->join("product_category as c", "a.category_id", "c.id")
                ->join("product_sub_category as d", "a.sub_category_id", "d.id")
                ->join("product_uom as e", "a.uom_id", "e.id")
                ->where("a.supplier_id", $request->user['supplier_id']);

            // Filter if category selected
            if ($request->filled('search_category')) {
                $query->where("a.category_id", $request->search_category);
            }
            if ($request->filled('sub_category_search')) {
                $query->where("a.sub_category_id", $request->sub_category_search);
            }
            $data = $query->get();

            return DataTables::of($data) // <-- query builder, NOT get()
                ->editColumn('image', function ($row) {
                    $src = asset('product images/' . $row->image);
                    return '<img src="' . $src . '" style="width: 80px; height: 80px; object-fit: cover; aspect-ratio: 1/1;">';
                })
                ->editColumn('active', function ($row) {
                    return $row->active == 1
                        ? '<div class="form-check form-switch">
                            <input class="form-check-input is_active" type="checkbox" value="' . $row->id . '"  role="switch"" checked>
                            </div>'
                        : '<div class="form-check form-switch">
                            <input class="form-check-input is_active" type="checkbox" role="switch" value="' . $row->id . '">
                        
                            </div>';
                })
                ->editColumn('is_deal', function ($row) {
                    return $row->is_deal == 1
                        ? '<div class="form-check  form-switch">
                            <input class="form-check-input is_deal" type="checkbox" value="' . $row->id . '"  role="switch"" checked>
                            </div>'
                        : '<div class="form-check  form-switch">
                            <input class="form-check-input is_deal" type="checkbox" role="switch"  value="' . $row->id . '" >
                        
                            </div>';
                })
                 ->editColumn('is_discount', function ($row) {
                    return $row->is_discount == 1
                        ? '<div class="form-check  form-switch">
                            <input class="form-check-input is_discount" type="checkbox" value="' . $row->id . '"  role="switch"" checked>
                            </div>'
                        : '<div class="form-check  form-switch">
                            <input class="form-check-input is_discount" type="checkbox" role="switch"  value="' . $row->id . '" >                        
                            </div>';
                })

                ->addColumn('action', function ($row) {
                    $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                    return '
                <button class="btn btn-primary btn-sm edit" data-data="' . $jsonData . '" type="button"
                        data-category="' . $row->category . '" data-sub_category="' . $row->sub_category . '">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
                <button class="btn btn-secondary btn-sm products" type="button" value="' . $row->id . '">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </button>
                <button class="btn btn-dark btn-sm uploadImages" type="button" value="' . $row->id . '">
                    Upload Images
                </button>
            ';
                })
                ->rawColumns(['image', 'active', "is_deal", "is_discount",'action'])
                ->make(true);
        }
    }
}
