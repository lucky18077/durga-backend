<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $state = DB::table("state_city")->distinct('state')->select("state")->get();
        $setting = DB::table("company_settings")->where("id", 1)->first();
        $header_supplier = DB::table("suppliers")->get();





        View::share('state', $state);
        View::share('setting', $setting);
        View::share('header_supplier', $header_supplier);


        // Bootstrap 5
        Paginator::useBootstrapFive();

        // Bootstrap 4
        Paginator::useBootstrapFour();

        // Bootstrap 4
        Paginator::useBootstrap();
    }
}
