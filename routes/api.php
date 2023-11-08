<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login", [AuthController::class, "login"]);
Route::post("logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
Route::post("register", [AuthController::class, "register"]);
Route::post("authenticated", [AuthController::class, "authenticated"])->middleware("auth:sanctum");
