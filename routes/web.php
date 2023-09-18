<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\PackageController;
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

Route::view("/", "welcome")->name("home");

Route::view("/login", "login")->name("login.index");
Route::post("/login", [AuthenticatedSessionController::class, "store"])->name("login.algo");

Route::view("/camionero", "camionero")->name("camionero");

Route::view("/cliente/scanner", "scanner")->name("scanner");

Route::view("/cliente", "cliente")->name("cliente");
Route::post("/cliente", [PackageController::class, "carga"])->name("cliente.scan");

Route::view("/almacen", "almacen")->name("almacen");
