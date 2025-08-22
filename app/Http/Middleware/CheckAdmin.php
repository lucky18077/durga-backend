<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (empty(session('token'))) {

            session()->flash('error', 'Session expired');
            return redirect('/');
        } else {

            $user = DB::table("users")->where('token', session('token'))->first();
            if (empty($user)) {
                session()->flush();
                session()->flash('error', 'Session expired or someone login your account');
                return redirect('/');
            } else {


                $child_ids = [];
                $iterable = [];


                array_push($iterable, $user->id);


                while (is_countable($iterable) && sizeof($iterable) > 0) {

                    $child_ids = array_merge($child_ids, $iterable);

                    try {

                        $users = DB::table("users")->whereIn("parent_id", $iterable)->get();


                        $iterable = [];


                        foreach ($users as $value) {
                            array_push($iterable, $value->id);
                        }
                    } catch (\Throwable $th) {

                        echo $msg = $th->getMessage();
                        break;
                    }
                }




                $child_id = implode(', ', $child_ids);
                $child_id = explode(',', $child_id);
                $rolePermissions = DB::table("role_permission")->where("role_id", $user->role_id)->get();
                $attendance = DB::table("attendance")->where("emp_id", $user->id)->whereDate("start_time", now())->first();

                View::share('rolePermissions', $rolePermissions);
                View::share('attendance', $attendance);

                $request->merge(["user" => (array)$user, "userIds" => $child_id]);

                return $next($request);
            }
        }
   
        return $next($request);
    }
}
