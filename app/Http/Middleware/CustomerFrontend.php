<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CustomerFrontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken(); // Gets token from Authorization header

        if (empty($token)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized. Token missing.'], 401);
        }

        $user = DB::table("customer_users as a")
            ->select("a.*")
            ->join("customers as b", "a.customer_id", "b.id")
            ->where('a.web_token', $token)
            ->where("b.active", 1)
            ->first();

        if (empty($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Invalid token.',
            ], 401);
        }

        $child_ids = [];
        $visited = [];
        $iterable = [$user->id];
        $depth = 0;
        $maxDepth = 10;

        while (!empty($iterable) && $depth < $maxDepth) {
            $iterable = array_diff($iterable, $visited);
            $visited = array_merge($visited, $iterable);
            $child_ids = array_merge($child_ids, $iterable);

            $users = DB::table("customer_users")->whereIn("parent_id", $iterable)->get();
            $iterable = $users->pluck('id')->toArray();
            $depth++;
        }
        $request->merge([
            "user" => (array)$user,
            "userIds" => $child_ids,
        ]);

        return $next($request);
    }
}
