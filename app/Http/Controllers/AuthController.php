<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

use function PHPSTORM_META\map;

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

        if ($user->email_verified_at === null) {
            return $this->error("Email no verificado", 401);
        }

        $roleToAbilities = [
            0 => ["admin"],
            1 => ["almacen"],
            2 => ["camionero"],
            3 => ["cliente"],
        ];
        $tokenAbilities = $roleToAbilities[$user->rol];

        return $this->success([
            "user" => $user->user,
            "rol" => $user->rol,
            "token" => $user->createToken($user->user, $tokenAbilities)->plainTextToken,
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

        $roleToAbilities = [
            0 => ["admin"],
            1 => ["almacen"],
            2 => ["camionero"],
            3 => ["cliente"],
        ];
        $tokenAbilities = $roleToAbilities[$user->rol];

        return $this->success([
            "user" => $user->user,
            "rol" => $user->rol,
            "token" => $user->createToken($user->user, $tokenAbilities)->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->success("Sesión cerrada");
    }

    public function authenticated(Request $request){
        $user = $request->user();

        if ($user === null) {
            return "No hay usuario";
        }

        if ($user->email_verified_at === null) {
            return 0;
        }
        return $this->success([
            "user" => $user->user,
            "rol" => $user->rol,
        ]);
    }
}
