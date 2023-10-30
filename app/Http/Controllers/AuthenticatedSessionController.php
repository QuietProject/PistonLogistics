<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {

        $credentials = $request->validate([
            "user" => ["required", "string"],
            "password" => ["required", "string"],
        ]);
        if (!Auth::attemptWhen($credentials, function ($user) {
            return $user->rol==0;
        }, $request->has('remember'))) {
            return redirect()->back()->withErrors(['authError' => 'El usuario o la contraseña son incorrectos']);
        }
        if(is_null(Auth::user()->email_verified_at)){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->back()->withErrors(['authError' => 'El usuario no verificó su email']);
        }
               return to_route('inicio');
    }

    public function destroy(Request $request)
    {

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }

    public function prueba()
    {
        $user = User::create([
            'user' => 'prueba',
            'password' => bcrypt('submarino'),
            'email'=>'maiadasdad',
            'email_verified_at'=>'2023-10-29 19:49:20',
            'rol' => 0
        ]);

        return to_route('login');
    }
}
