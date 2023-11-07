<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use GrahamCampbell\ResultType\Success;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "user" => ["required", "string", "max:128"],
            "password" => ["required", "string", "max:24", "min:8"],
        ]);

        // return $credentials;
        if (!Auth::attempt($credentials)) {
            return $this->error("Credenciales incorrectas", 401);
        }

        $user = User::where("user", $credentials["user"])->firstOrFail();

        return $this->success([
            "user" => $user,
            "rol" => $user->rol,
            "token" => $user->createToken("Api token of" . $user->user)->plainTextToken
        ]);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            "user" => ["required", "string", "max:20"],
            "rol" => ["required", "integer", "numeric", "between:0,3"],
            "password" => ["required", "confirmed", "max:24", "min:8", Rules\Password::defaults()],
            "email" => ["required", "email", "max:255", "unique:users,email"],
        ]);

        $user = User::create($credentials);

        return $this->success([
            "user" => $user->user,
            "token" => $user->createToken("API token of " . $user->user)->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success("Logged out successfully");
    }
}
