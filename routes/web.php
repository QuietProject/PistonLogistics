<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransitController;
use App\Http\Middleware\LocaleCookieMiddleware;

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

Route::middleware(LocaleCookieMiddleware::class)->group(function () {

    Route::view("/", "welcome")->name("home");
    Route::view("/rastreo", "rastreo")->name("rastreoView");
    Route::post("/", [TransitController::class, "rastreo"])->name("rastreo");


    Route::view("/login", "login")->name("login");
    Route::post("/login", [AuthenticatedSessionController::class, "store"])->name("login.algo");

    Route::view("/camionero", "camionero")->name("camionero");

    Route::view("/cliente/scanner", "scanner")->name("scanner");

    Route::view("/cliente", "cliente")->name("cliente");
    Route::post("/cliente", [PackageController::class, "carga"])->name("cliente.scan");

    Route::view("/almacen", "almacen")->name("almacen");

    Route::get("/verPaquetes", [PackageController::class, "showPaquetes"])->name("verPaquetes.show");
    Route::get("/verPaquetes/asignar/{idPaquete}/{idLote}", [PackageController::class, "asignar"])->name("verPaquetes.asignar");

    Route::get("/verLotes", [PackageController::class, "showLotes"])->name("verLotes.show");

    Route::view("/crearLote", "crearLote")->name("crearLote");

    Route::view("/almacenCarga", "almacenCarga")->name("almacenCarga");
    Route::post("/almacenCarga", [PackageController::class, "cargaAlmacen"])->name("almacenCarga.scan");
    Route::view("/almacenDescarga", "almacenDescarga")->name("almacenDescarga");
    Route::post("/almacenDescarga", [PackageController::class, "descargaAlmacen"])->name("almacenDescarga.scan");

    Route::view("/administrador", "administrador")->name("administrador");

});