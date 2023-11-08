<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role == "13") {
            return response($request->bearerToken());

        }


        return response($role);

        return $next($request);
    }
}
