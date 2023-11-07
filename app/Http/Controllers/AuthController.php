<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "user" => ["required", "string", "max:20"],
            "password" => ["required", "string", "max:24", "min:8"],
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->error("Credenciales incorrectas", 401);
        }

        $user = User::where("user", $credentials["user"])->firstOrFail();

        return $this->success([
            "user" => $user->user,
            "rol" => $user->rol,
            "token" => $user->createToken($user->user)->plainTextToken,
        ]);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            "user" => ["required", "string", "max:20"],
            "rol" => ["required", "integer", "numeric", "between:0,3"],
            "password" => ["required", "confirmed", "max:24", "min:8", Rules\Password::defaults()],
            "email" => ["required", "email", "max:255", "unique:users"],
        ]);

        $user = User::create($credentials);

        return $this->success([
            "user" => $user->user,
            "token" => $user->createToken($user->user)->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
