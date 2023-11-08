<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("login", [AuthController::class, "login"]);
Route::post("logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
Route::post("register", [AuthController::class, "register"]);
Route::post("admin", [AuthController::class, "isAdmin"])->middleware("auth:sanctum");
Route::post("almacen", [AuthController::class, "isAlmacen"])->middleware("auth:sanctum");
Route::post("camionero", [AuthController::class, "isCamionero"])->middleware("auth:sanctum");
Route::post("cliente", [AuthController::class, "isCliente"])->middleware("auth:sanctum");
