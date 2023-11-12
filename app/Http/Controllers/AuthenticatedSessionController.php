<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "user" => ["required", "string", "max:128"],
            "password" => ["required", "string", "max:24", "min:8"],
        ]);

        $userResponse = Http::post(env("AUTH_API_URL") . "login", [
            'user' => $credentials['user'],
            'password' => $credentials['password'],
        ]);

        $user = $userResponse->json();

        if (isset($user['data']['rol'])) {
            $token = $user['data']['token'];
            $nombre = $user['data']['user'];

            switch ($user['data']['rol']) {
                case 0:
                    $redirect = route("administrador");
                    break;
                case 1:
                    $redirect = route("almacen");
                    break;
                case 2:
                    $redirect = route("camionero");
                    break;
                case 3:
                    $redirect = route("cliente");
                    break;
                default:
                    $redirect = route("login");
                    break;
            }

            session(['nombre' => $nombre, 'token' => $token]);

            return redirect()->to($redirect);
        }

        return redirect()->route("login");
    }

    public function logout(Request $request)
    {
        $a = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->post(env('AUTH_API_URL') . 'logout');
        return redirect()->route("login");
    }
}
