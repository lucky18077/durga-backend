<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\BulkImport;
use App\Http\Controllers\CommonAjax;
use App\Http\Controllers\Customer;
use App\Http\Controllers\CustomerFrontendController;
use App\Http\Controllers\FrontEnd;
use App\Http\Controllers\Masters;
use App\Http\Controllers\OutwardManagement;
use App\Http\Controllers\PurchaseManagement;
use App\Http\Controllers\StaffManagement;
use App\Http\Controllers\Supplier;
use App\Http\Controllers\uploadProductsGDrive;
use App\Http\Controllers\WebsiteManagement;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CustomerFrontend;
use App\Http\Middleware\Customers;
use App\Http\Middleware\staffAuth;
use App\Http\Middleware\Suppliers;
use Illuminate\Support\Facades\Route;



Route::get('/home', [FrontEnd::class, 'Shop'])->name('home');
Route::get('/', [FrontEnd::class, 'Index'])->name('/');


    Route::get('apiProducts', [CustomerFrontendController::class, 'apiProducts'])->name('apiProducts');

Route::get('/s1', [Authentication::class, 'SuperAdmin'])->name('s1');
Route::post('/s1', [Authentication::class, 'SuperAdminLogin'])->name('SuperAdminLogin');
Route::get('/supplier', [Authentication::class, 'SupplierLogin'])->name('supplier');
Route::post('/SaveSupplierLogin', [Authentication::class, 'SaveSupplierLogin'])->name('SaveSupplierLogin');

Route::get('/customer', [Authentication::class, 'CustomerLogin'])->name('customer');
Route::post('/SaveCustomerLogin', [Authentication::class, 'SaveCustomerLogin'])->name('SaveCustomerLogin');

Route::post('/customerLoginWebsite', [Authentication::class, 'customerLoginWebsite'])->name('customerLoginWebsite');

Route::get('/shop', [FrontEnd::class, 'Shop'])->name('shop');
Route::get('/product-details/{id}', [FrontEnd::class, 'ProductDetails'])->name('product-details/{id}');
Route::post('/GetCity', [CommonAjax::class, 'GetCity'])->name('/GetCity');

Route::get('sign-up', [CustomerFrontendController::class, 'SignUp'])->name('sign-up');
Route::post('SaveCustomer', [CustomerFrontendController::class, 'SaveCustomer'])->name('SaveCustomer');


Route::get('supplier-staff', [Authentication::class, 'StaffLogin'])->name('supplier-staff');
Route::post('/SaveStaffLogin', [Authentication::class, 'SaveStaffLogin'])->name('SaveStaffLogin');
Route::get('apiProducts', [CustomerFrontendController::class, 'apiProducts'])->name('apiProducts');


Route::middleware([CheckAdmin::class])->group(function () {
    Route::get('s1/logout', [Authentication::class, 'logout'])->name('s1/Logout');
    //admin routes
    Route::get('s1/dashboard', [Admin::class, 'Dashboard'])->name('s1/dashboard');
    Route::get('s1/customers', [Masters::class, 'Customers'])->name('s1/customer');
    Route::get('s1/suppliers', [Masters::class, 'Suppliers'])->name('s1/suppliers');
    Route::post('s1/SaveSuppliers', [Masters::class, 'SaveSuppliers'])->name('s1/SaveSuppliers');

    // website management

    Route::get('s1/sliders', [WebsiteManagement::class, 'Sliders'])->name('s1/sliders');
    Route::post('s1/SaveSlider', [WebsiteManagement::class, 'SaveSlider'])->name('s1/SaveSlider');

    //masters 
    Route::get('s1/documents', [Masters::class, 'Documents'])->name('s1/documents');
    Route::post('s1/SaveDocuments', [Masters::class, 'SaveDocuments'])->name('s1/SaveDocuments');



    Route::get('s1/sliders1', [WebsiteManagement::class, 'Sliders1'])->name('s1/sliders1');
    Route::post('s1/SaveSlider1', [WebsiteManagement::class, 'SaveSlider1'])->name('s1/SaveSlider1');


    Route::get('s1/sliders2', [WebsiteManagement::class, 'Sliders2'])->name('s1/sliders2');
    Route::post('s1/SaveSlider2', [WebsiteManagement::class, 'SaveSlider2'])->name('s1/SaveSlider2');
});

Route::middleware([Suppliers::class])->group(function () {
    Route::get('supplier/logout', [Supplier::class, 'logout'])->name('supplier/Logout');
    Route::get('supplier/profile', [Supplier::class, 'Profile'])->name('supplier/profile');
    Route::post('supplier/UpdateProfile', [Supplier::class, 'UpdateProfile'])->name('supplier/UpdateProfile');
    //admin routes
    Route::get('supplier/dashboard', [Supplier::class, 'Dashboard'])->name('supplier/dashboard');
    Route::get('supplier/customers/{id}', [Supplier::class, 'Customers'])->name('supplier/customer');
    Route::post('Supplier/SaveCustomer', [Supplier::class, 'SaveCustomer'])->name('Supplier/SaveCustomer');

    // master routes
    Route::get('supplier/product-category', [Masters::class, 'ProductCategory'])->name('supplier/product-category');
    Route::post('supplier/SaveProductCategory', [Masters::class, 'SaveProductCategory'])->name('supplier/SaveProductCategory');

    Route::get('supplier/product-sub-category', [Masters::class, 'ProductSubCategory'])->name('supplier/product-sub-category');
    Route::post('supplier/SaveProductSubCategory', [Masters::class, 'SaveProductSubCategory'])->name('supplier/SaveProductSubCategory');


    Route::get('supplier/product-brand', [Masters::class, 'ProductBrand'])->name('supplier/product-brand');
    Route::post('supplier/SaveProductBrand', [Masters::class, 'SaveProductBrand'])->name('supplier/SaveProductBrand');
    Route::post('supplier/GetProductCategory', [Masters::class, 'GetProductCategory'])->name('supplier/GetProductCategory');
    Route::post('supplier/GetProductSubCategory', [Masters::class, 'GetProductSubCategory'])->name('supplier/GetProductSubCategory');


    Route::get('supplier/product-uom', [Masters::class, 'ProductUOM'])->name('supplier/product-uom');
    Route::post('supplier/SaveProductUOM', [Masters::class, 'SaveProductUOM'])->name('supplier/SaveProductUOM');

    Route::get('supplier/product-gst', [Masters::class, 'ProductGST'])->name('supplier/product-gst');
    Route::post('supplier/SaveProductGST', [Masters::class, 'SaveProductGST'])->name('supplier/SaveProductGST');

    Route::get('supplier/products', [Masters::class, 'Products'])->name('supplier/products');
    Route::post('supplier/SaveProducts', [Masters::class, 'SaveProducts'])->name('supplier/SaveProducts');
    Route::post('supplier/uploadMultipleImages', [Masters::class, 'uploadMultipleImages'])->name('supplier/uploadMultipleImages');


    Route::get('supplier/customer-profile/{id}', [Supplier::class, 'CustomerProfile'])->name('supplier/customer-profile');
    Route::post('supplier/UpdateCompanyDetails', [Supplier::class, 'UpdateCompanyDetails'])->name('supplier/UpdateCompanyDetails');
    Route::post('supplier/UpdatePersonalDetails', [Supplier::class, 'UpdatePersonalDetails'])->name('supplier/UpdatePersonalDetails');
    Route::post('supplier/UploadDocument', [Supplier::class, 'UploadDocument'])->name('supplier/UploadDocument');
    Route::post('supplier/UploadAgreement', [Supplier::class, 'UploadAgreement'])->name('supplier/UploadAgreement');
    Route::post('supplier/UploadWallet', [Supplier::class, 'UploadWallet'])->name('supplier/UploadWallet');
    Route::post('supplier/GetProductPrices', [Supplier::class, 'GetProductPrices'])->name('supplier/GetProductPrices');
    Route::post('supplier/DeleteProductPrice', [Supplier::class, 'DeleteProductPrice'])->name('supplier/DeleteProductPrice');
    Route::post('supplier/AddProductPrice', [Supplier::class, 'AddProductPrice'])->name('supplier/AddProductPrice');



    Route::post('supplier/getMultipleImages', [Supplier::class, 'getMultipleImages'])->name('supplier/getMultipleImages');
    Route::post('supplier/deleteImage', [Supplier::class, 'deleteImage'])->name('supplier/deleteImage');

    // order management
    Route::get('supplier/orders/{status}', [Supplier::class, 'Orders'])->name('supplier/orders');
    Route::get('supplier/order-details/{id}', [Supplier::class, 'OrderDetails'])->name('supplier/order-details');


    //bulk import
    Route::post('supplier/ImportProducts', [BulkImport::class, 'ImportProducts'])->name('supplier/ImportProducts');
    Route::post('supplier/UpdateOrderStatus', [Supplier::class, 'UpdateOrderStatus'])->name('supplier/UpdateOrderStatus');
    Route::post('supplier/AddWalletLedger', [Supplier::class, 'AddWalletLedger'])->name('supplier/AddWalletLedger');
    Route::get('supplier/wallet-management', [Supplier::class, 'WalletManagement'])->name('supplier/wallet-management');
    Route::post('supplier/importGDriveProducts', [uploadProductsGDrive::class, 'importGDriveProducts'])->name('supplier/importGDriveProducts');

    //user management
    Route::get("supplier/user-role", [Supplier::class, "UserRole"])->name("supplier/user-role");
    Route::post("supplier/saveUserRole", [Supplier::class, "saveUserRole"])->name("supplier/saveUserRole");

    Route::get("supplier/users", [Supplier::class, "users"])->name("supplier/users");
    Route::post("supplier/updateSupplierUser", [Supplier::class, "updateSupplierUser"])->name("supplier/updateSupplierUser");

    //ajax

    Route::get('supplier/getProduct', [Supplier::class, 'getProduct'])->name('supplier.getProduct');

    Route::post('supplier/UpdateProductStatus', [Masters::class, 'UpdateProductStatus'])->name('supplier/UpdateProductStatus');
    Route::post('supplier/UpdateProductIsdeal', [Masters::class, 'UpdateProductIsdeal'])->name('supplier/UpdateProductIsdeal');
    Route::post('supplier/UpdateProductDiscount', [Masters::class, 'UpdateProductDiscount'])->name('supplier/UpdateProductDiscount');
});

Route::middleware([Customers::class])->group(function () {

    //ajax
    Route::post('customer/GetCategory', [Customer::class, 'GetCategory'])->name('customer/GetCategory');
    Route::post('customer/GetSubCategory', [Customer::class, 'GetSubCategory'])->name('customer/GetSubCategory');
    Route::post('customer/GetProducts', [Customer::class, 'GetProducts'])->name('customer/GetProducts');
    Route::post('customer/GetFinishProduct', [Customer::class, 'GetFinishProduct'])->name('customer/GetFinishProduct');

    Route::post('customer/GetGatheringDet', [Customer::class, 'GetGatheringDet'])->name('customer/GetGatheringDet');






    Route::get('customer/logout', [Authentication::class, 'CustomerLogout'])->name('customer/Logout');
    Route::get('customer/profile', [Supplier::class, 'Profile'])->name('customer/profile');
    Route::post('customer/UpdateProfile', [Supplier::class, 'UpdateProfile'])->name('customer/UpdateProfile');
    //masters routes
    Route::get('customer/dashboard', [Customer::class, 'Dashboard'])->name('customer/dashboard');
    Route::get('customer/brand', [Customer::class, 'Brand'])->name('customer/brand');
    Route::post('customer/SaveBrand', [Customer::class, 'SaveBrand'])->name('customer/SaveBrand');

    Route::get('customer/category', [Customer::class, 'Category'])->name('customer/category');
    Route::post('customer/SaveCategory', [Customer::class, 'SaveCategory'])->name('customer/SaveCategory');

    Route::get('customer/sub-category', [Customer::class, 'SubCategory'])->name('customer/sub-category');
    Route::post('customer/SaveSubCategory', [Customer::class, 'SaveSubCategory'])->name('customer/SaveSubCategory');

    Route::get('customer/products', [Customer::class, 'Product'])->name('customer/products');
    Route::post('customer/SaveProduct', [Customer::class, 'SaveProduct'])->name('customer/SaveProduct');
    Route::post('customer/ImportProducts', [Customer::class, 'ImportProducts'])->name('customer/ImportProducts');

    Route::get('customer/finish-product-category', [Customer::class, 'FinishProductCategory'])->name('customer/finish-product-category');
    Route::post('customer/SaveFinishCategory', [Customer::class, 'SaveFinishCategory'])->name('customer/SaveFinishCategory');


    Route::get('customer/finish-product', [Customer::class, 'FinishProduct'])->name('customer/finish-product');
    Route::post('customer/SaveFinishProduct', [Customer::class, 'SaveFinishProduct'])->name('customer/SaveFinishProduct');
    Route::post('customer/UpdateFinishProduct', [Customer::class, 'UpdateFinishProduct'])->name('customer/UpdateFinishProduct');



    Route::get('customer/customer-raw-material-product/{id}', [Customer::class, 'RawMaterialProduct'])->name('customer/customer-raw-material-product/{id}');
    Route::post('customer/SaveRawProduct', [Customer::class, 'SaveRawProduct'])->name('customer/SaveRawProduct');
    Route::post('customer/DeleteProduct', [Customer::class, 'DeleteProduct'])->name('customer/DeleteProduct');

    Route::get('customer/gathering-list', [Customer::class, 'GatheringList'])->name('customer/gathering-list');
    Route::get('customer/add-gathering', [Customer::class, 'AddGathering'])->name('customer/add-gathering');
    Route::post('customer/SaveGathering', [Customer::class, 'SaveGathering'])->name('customer/SaveGathering');
    Route::post('customer/UpdateGathering', [Customer::class, 'UpdateGathering'])->name('customer/UpdateGathering');
    Route::get('customer/gathering-menu/{id}', [Customer::class, 'GatheringMenu'])->name('customer/gathering-menu');

    Route::post('customer/AddGatheringMenu', [Customer::class, 'AddGatheringMenu'])->name('customer/AddGatheringMenu');
    Route::post('customer/DeleteGatheringMenuItem', [Customer::class, 'DeleteGatheringMenuItem'])->name('customer/DeleteGatheringMenuItem');
    Route::get('customer/customer', [Customer::class, 'Customer'])->name('customer/customer');
    Route::post('customer/SaveCustomer', [Customer::class, 'SaveCustomer'])->name('customer/SaveCustomer');

    Route::get('customer/customer-gathering', [Customer::class, 'CustomerGathering'])->name('customer/customer-gathering');
    Route::get('customer/add-customer-gathering', [Customer::class, 'AddCustomerGathering'])->name('customer/add-customer-gathering');
    Route::post('customer/SaveCustomerGathering', [Customer::class, 'SaveCustomerGathering'])->name('customer/SaveCustomerGathering');

    Route::get('customer/customer-gathering-menu/{id}', [Customer::class, 'CustomerGatheringMenu'])->name('customer/customer-gathering-menu');
    Route::get('customer/customer-gathering-menu-raw-material/{id}', [Customer::class, 'CustomerGatheringMenuRawMaterial'])->name('customer/customer-gathering-menu-raw-material');


    Route::get("customer/vendor", [Customer::class, "vendor"])->name("customer/vendor");
    Route::post("customer/saveVendor", [Customer::class, "saveVendor"])->name("customer/saveVendor");

    Route::get("customer/gst", [Customer::class, "gst"])->name("customer/gst");
    Route::post("customer/saveGST", [Customer::class, "saveGST"])->name("customer/saveGST");



    Route::get("customer/unit-type", [Customer::class, "unitType"])->name("customer/unit-type");
    Route::post("customer/saveUnitType", [Customer::class, "saveUnitType"])->name("customer/saveUnitType");

    Route::get("customer/department", [Customer::class, "department"])->name("customer/department");
    Route::post("customer/saveDepartment", [Customer::class, "saveDepartment"])->name("customer/saveDepartment");

    //purchase management
    Route::get("customer/vendor-product/{id}", [PurchaseManagement::class, "vendorProduct"])->name("customer/vendor-product");
    Route::post("customer/saveVendorProduct", [PurchaseManagement::class, "saveVendorProduct"])->name("customer/saveVendorProduct");
    Route::post("customer/GetVendorProducts", [PurchaseManagement::class, "GetVendorProducts"])->name("customer/GetVendorProducts");



    Route::get("customer/generate-po", [PurchaseManagement::class, "generatePO"])->name("customer/generate-po");
    Route::post("customer/SavePO", [PurchaseManagement::class, "SavePO"])->name("customer/SavePO");

    Route::get("customer/po/{status}", [PurchaseManagement::class, "po"])->name("customer/po");
    Route::get("customer/purchase-view/{id}", [PurchaseManagement::class, "PurchaseView"])->name("customer/purchase-view");
    Route::post("customer/UpdateCharges", [PurchaseManagement::class, "UpdateCharges"])->name("customer/UpdateCharges");
    Route::post("customer/DeletePOProduct", [PurchaseManagement::class, "DeletePOProduct"])->name("customer/DeletePOProduct");
    Route::post("customer/SavePOProduct", [PurchaseManagement::class, "SavePOProduct"])->name("customer/SavePOProduct");

    Route::get("customer/inward-stock", [PurchaseManagement::class, "InwardStock"])->name("customer/inward-stock");
    Route::post("customer/SaveInwardStock", [PurchaseManagement::class, "SaveInwardStock"])->name("customer/SaveInwardStock");

    Route::post("customer/GetPO", [PurchaseManagement::class, "GetPO"])->name("customer/GetPO");
    Route::post("customer/GetPODet", [PurchaseManagement::class, "GetPODet"])->name("customer/GetPODet");

    Route::get("customer/inward-report", [PurchaseManagement::class, "InwardReport"])->name("customer/inward-report");
    Route::get("customer/inward-report-view/{id}", [PurchaseManagement::class, "InwardReportView"])->name("customer/inward-report-view");


    //outward management
    Route::get("customer/outward-stock", [OutwardManagement::class, "outwardStock"])->name("customer/outward-stock");
    Route::post("customer/SaveOutward", [OutwardManagement::class, "SaveOutward"])->name("customer/SaveOutward");

    Route::get("customer/outward-report", [OutwardManagement::class, "outwardReport"])->name("customer/outward-report");

    Route::post("customer/DispatchChallan", [OutwardManagement::class, "DispatchChallan"])->name("customer/DispatchChallan");
    Route::post("customer/DeliveredChallan", [OutwardManagement::class, "DeliveredChallan"])->name("customer/DeliveredChallan");
    Route::get("customer/outward-challan-view/{id}", [OutwardManagement::class, "OutwardChallanView"])->name("customer/outward-challan-view");
});


Route::middleware([CustomerFrontend::class])->group(function () {

    Route::get('profile', [CustomerFrontendController::class, 'Profile'])->name('profile');
    Route::post('AddToCart', [CustomerFrontendController::class, 'AddToCart'])->name('AddToCart');
    Route::get('cart', [CustomerFrontendController::class, 'Cart'])->name('cart');
    Route::get('checkout', [CustomerFrontendController::class, 'Checkout'])->name('checkout');
    Route::post('SaveOrder', [CustomerFrontendController::class, 'SaveOrder'])->name('SaveOrder');
    Route::get('logout', [CustomerFrontendController::class, 'Logout'])->name('Logout');
    Route::post('UpdateCompanyDetails', [CustomerFrontendController::class, 'UpdateCompanyDetails'])->name('UpdateCompanyDetails');
    Route::post('UpdateCustomerDetails', [CustomerFrontendController::class, 'UpdateCustomerDetails'])->name('UpdateCustomerDetails');
    Route::get('invoice/{id}', [CustomerFrontendController::class, 'Invoice'])->name('invoice');
    Route::post('UploadDocument', [Supplier::class, 'UploadDocument'])->name('UploadDocument');
    Route::post('shopAddToCart', [CustomerFrontendController::class, 'shopAddToCart'])->name('shopAddToCart');

});

Route::middleware([staffAuth::class])->group(function () {
    Route::get('staff/dashboard', [StaffManagement::class, 'StaffDashboard'])->name('staff/dashboard');
    Route::get('staff/orders/{status}', [StaffManagement::class, 'Orders'])->name('staff/orders');
    Route::get('staff/order-details/{id}', [StaffManagement::class, 'OrderDetails'])->name('staff/order-details');
    Route::get('staff/logout', [StaffManagement::class, 'Logout'])->name('staff/logout');
});
