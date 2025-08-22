<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class StaffServiceProvider extends ServiceProvider
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
        View::composer('staff.*', function ($view) {
            $app_token = session('app_token');

            if ($app_token) {
                $staff =  DB::table("supplier_users as a")
                    ->select("a.*")
                    ->join("supplier_role as b", "a.role_id", "b.id")
                    ->where("a.app_token", $app_token)->where("b.app_permission", 1)->first();
                if ($staff) {
                    $view->with('isStaffLoggedIn', true);
                    $view->with('staff', $staff);
                } else {
                    session()->forget('app_token');
                    $view->with('isStaffLoggedIn', false);
                    $view->with('staff', null);
                }
            } else {
                $view->with('isStaffLoggedIn', false);
                $view->with('staff', null);
            }
        });
    }
}
