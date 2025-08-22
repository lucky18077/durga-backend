<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $web_token = session('web_token');

            if ($web_token) {
                $customer = DB::table('customer_users as a')
                ->select("a.*", "b.wallet", "b.used_wallet")
                ->join("customers as b", "a.customer_id", "b.id")
                ->where('a.web_token', $web_token)
                ->where("b.active",1)
                ->first();



                if ($customer) {
                    $cart =  DB::table("cart")->where("customer_id", $customer->customer_id)->get();
                    $view->with('isCustomerLoggedIn', true);
                    $view->with('customer', $customer);
                    $view->with('cart', $cart);
                } else {
                    session()->forget('web_token');
                    $view->with('isCustomerLoggedIn', false);
                    $view->with('customer', null);
                    $view->with('cart', collect());
                }
            } else {
                $view->with('isCustomerLoggedIn', false);
                $view->with('customer', null);
                $view->with('cart', collect());
            }
        });
    }
}
