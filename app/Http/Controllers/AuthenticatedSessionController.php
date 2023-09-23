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
            "user" => ["required", "string", "max:20"],
            "password" => ["required", "string", "max:24", "min:8"],
        ]);
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return redirect()->back()->withErrors(['authError' => 'El usuario o la contraseña son incorrectoseeee']);
        }
        $user = User::where("user", $request->user)->firstOrFail();

        if ($user->rol != 0) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->back()->withErrors(['authError' => '2 El usuario o la contraseña son incorrectos']);
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
            'rol' => 0
        ]);

        return to_route('login');
    }
}
