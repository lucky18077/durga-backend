<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin extends Controller
{
    public function Dashboard(Request $request){
        return view("admin.dashboard");
    }
}
