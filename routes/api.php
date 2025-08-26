<?php

use App\Http\Controllers\ApiController\ApiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ApiController\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\CustomerFrontend;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

Route::post('/customer-login', [LoginController::class, 'customerLoginApi']);
Route::post('/send-otp', [LoginController::class, 'sendOtp']);
Route::post('/verify-otp', [LoginController::class, 'verifyOtp']);
Route::post('/customer-signup', [LoginController::class, 'saveCustomerApi']);
Route::get('/get-category', [ApiController::class, 'getCategory'])->name('get-category');
Route::get('/get-sub-category', [ApiController::class, 'getSubCategory'])->name('get-sub-category');
Route::get('/get-brands', [ApiController::class, 'getBrands'])->name('get-brands');
Route::get('/get-products', [ApiController::class, 'getProducts'])->name('get-products');
Route::get('/get-all-products', [ApiController::class, 'getAllProducts'])->name('get-all-products');
Route::get('/get-products-deal', [ApiController::class, 'dealOnDay'])->name('get-products-deal');
Route::get('/get-slider', [ApiController::class, 'SlidersApi'])->name('get-slider');
Route::get('/get-banner', [ApiController::class, 'BannerApi'])->name('get-banner');
Route::get('/get-footer-banner', [ApiController::class, 'FooterBannerApi'])->name('get-footer-banner');
Route::get('/get-product-detail/{id}', [ApiController::class, 'ProductDetailsApi'])->name('get-product-detail');


Route::middleware([CustomerFrontend::class])->group(function () {
    Route::post('add-to-cart', [ApiController::class, 'shopAddToCart'])->name('add-to-Cart');
    Route::post('remove-cart', [ApiController::class, 'removeItem'])->name('remove-cart');
    Route::post('add-to-wishlist', [ApiController::class, 'shopAddToWhishlist'])->name('add-to-wishlist');
    Route::post('remove-wishlist', [ApiController::class, 'removewishlist'])->name('remove-wishlist');
    Route::get('cart-view', [ApiController::class, 'cartApi'])->name('cart-view');
    Route::get('whishlist-view', [ApiController::class, 'whishList'])->name('whishlist-view');
    Route::get('get-cart', [ApiController::class, 'getCartByCustomer'])->name('get-cart');
    Route::get('get-product', [ApiController::class, 'getproduct'])->name('get-product');
    Route::get('checkout', [ApiController::class, 'Checkout'])->name('checkout');
    Route::get('invoice/{id}', [ApiController::class, 'getInvoiceData'])->name('invoice');
    Route::post('place-order', [ApiController::class, 'SaveOrder'])->name('place-order');
    Route::get('customer-detail', [ApiController::class, 'customerProfileApi'])->name('customer-detail');
    Route::post('customer-logout', [ApiController::class, 'apiLogout'])->name('customer-logout');
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/users', function (Request $request) {
    // ...
});

Route::get('/subCategories', function () {
    $category_id = request('category_id');
    return DB::table('product_sub_category')
        ->where('category_id', $category_id)
        ->get();
});
