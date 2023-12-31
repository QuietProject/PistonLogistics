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
    Route::post("/login", [AuthenticatedSessionController::class, "login"])->name("login");

    Route::post('/logout', [AuthenticatedSessionController::class, "logout"])->name('logout');

    Route::middleware("authorize:2")->group(function () {
        Route::get("/camionero", [TransitController::class, "mapa"])->name("camionero");
        Route::view("/reparte", "reparte")->name("reparte");
        Route::view("/trae", "trae")->name("trae");
    });

    Route::middleware("authorize:3")->group(function () {
        Route::view("/cliente/scanner", "scanner")->name("scanner");
        Route::view("/cliente", "cliente")->name("cliente");
        Route::get("/cliente/{paquetes}", [PackageController::class, "carga"])->name("cliente.carga");
        Route::view("/crearPaquete", "crearPaquete")->name("crearPaquete");
        Route::post("/crearPaquete", [PackageController::class, "crearPaquete"])->name("crearPaquete.store");
        Route::get("/generadorQr", [PackageController::class, "getPaquetesQr"])->name("generadorQr");
    });


    Route::middleware("authorize:1")->group(function () {

        Route::view("/almacen", "almacen")->name("almacen");

        Route::get("/verPaquetes", [PackageController::class, "showPaquetes"])->name("verPaquetes.show");
        Route::get("/verPaquetes/asignar/{idPaquete}/{idLote}", [PackageController::class, "asignar"])->name("verPaquetes.asignar");

        Route::get("/entregarPaquete", [PackageController::class, "getPaquetesEntregar"])->name("entregarPaquete.show");
        Route::get("/entregar/{id}", [PackageController::class, "entregarPaquete"])->name("entregarPaquete.entregar");

        Route::get("/verLotes", [PackageController::class, "showLotes"])->name("verLotes.show");
        Route::get("/quitarPaquete/{idLote}/{idPaquete}", [PackageController::class, "quitarPaqueteDeLote"])->name("quitarPaquete");

        Route::get("/crearLote", [PackageController::class, "getOrdenes"])->name("createLote.show");
        Route::post("/crearLote", [PackageController::class, "crearLote"])->name("crearLote.store");

        Route::view("/almacenCarga", "almacenCarga")->name("almacenCarga");
        Route::get("/almacenCarga/{paquetes}/{lotes}", [PackageController::class, "cargaAlmacen"])->name("almacenCarga.carga");

        Route::view("/almacenDescarga", "almacenDescarga")->name("almacenDescarga");
        Route::get("/almacenDescarga/{paquetes}/{lotes}", [PackageController::class, "descargaAlmacen"])->name("almacenDescarga.descarga");
        // Route::post("/almacenDescarga/descargaAlmacen", [PackageController::class, "descargaAlmacen"])->name("almacenDescarga.scan");
        Route::view("/paquetePeso", "paquetePeso")->name("paquetePeso");
        Route::post("/paquetePeso", [PackageController::class, "asignarPeso"])->name("paquetePeso.asignar");

        Route::get("/pronto/{idLote}", [PackageController::class, "lotePronto"])->name("lotePronto");

    });


    Route::view("/administrador", "administrador")->name("administrador");
    Route::get('/clear-message', function () {
        session()->forget('message');
        return redirect()->back();
    })->name('clear.message');
    
    Route::get('/locale/{locale}', function ($locale) {
        if ($locale == 'es' || $locale == 'en') return redirect()->back()->withCookie('locale', $locale);
        return redirect()->back()->with('error', 'Ha ocurrido un error');
    })->name('locale');
});