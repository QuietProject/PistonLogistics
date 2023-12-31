<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Authorize
{
    /**
     
Handle an incoming request.*
@param  \Illuminate\Http\Request  $request
@param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
@return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
*/
    public function handle(Request $request, Closure $next, $role)
    {

        if ($role == "1") {
            $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->post(env("AUTH_API_URL") . "almacen");

            if ($response->status() != 200 || $response["data"] == 0) {
                return redirect()->back();
            }
        }

        if ($role == "2") {
            $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->post(env("AUTH_API_URL") . "camionero");

            if ($response->status() != 200 || $response["data"] == 0) {
                return redirect()->back();
            }
        }

        if ($role == "3") {
            $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->post(env("AUTH_API_URL") . "cliente");

            if ($response->status() != 200 || $response["data"] == 0) {
                return redirect()->back();
            }
        }

        return $next($request);
    }
}