<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Jenssegers\Agent\Agent;

class CommonAjax extends Controller
{
 public function GetCity(Request $request){
    return DB::table('state_city')->where("state",$request->state)->get();
 }
}
