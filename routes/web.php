<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view("/", "welcome")->name("index");

Route::view("/login", "login")->name("login");
Route::post("/login", [AuthenticatedSessionController::class, "store"]);

Route::view("/camionero", "camionero")->name("camionero");

Route::view("/cliente", "cliente")->name("cliente");

Route::view("/almacen", "almacen")->name("almacen");
