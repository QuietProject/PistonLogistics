<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request){

        $credentials = $request->validate([
            "user" => ["required", "string"],
            "password" => ["required", "string"]
        ]);

        if(!Auth::attempt($credentials, true)){
            throw ValidationException::withMessages([
                "user" => __("auth.failed")
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended()->with("Te has loguedo");
    }
}
