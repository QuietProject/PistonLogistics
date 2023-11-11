<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\OrdenController;
use App\Models\Paquete;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("prueba", [PaqueteController::class, "getOrCreateLote"])->middleware();

// Route::middleware("authorize:1")->group(function (){
    Route::resource("paquetes", PaqueteController::class)->except(["edit", "update", "destroy", "create", "show"]);
    Route::get("paquetes/{codigo}", [PaqueteController::class, "show"]);
    Route::get("almacen/descarga/{id}/{almacen}", [PaqueteController::class, "descargaPaquete"]);
    Route::post("almacen/carga", [PaqueteController::class, "cargaReparte"]);

    Route::get("lotes/cargar", [LoteController::class, "cargaLote"]);
    Route::get("lotes/descargar", [LoteController::class, "descargaLote"]);
    Route::get("lotes/contenido/{idsLote}", [LoteController::class, "paquetesEnLote"]);
    Route::get("lotes", [LoteController::class, "index"]);
    Route::post("lotes/create", [LoteController::class, "store"]);
    Route::get("lotes/agregar/paquete", [LoteController::class, "agregarPaqueteToLote"]);
    Route::post("lotes/eliminar/paquete", [LoteController::class, "quitarPaquete"]);
    Route::get("lotes/pronto", [LoteController::class, "lotePronto"]);
    Route::get("lotes/{codigo}", [LoteController::class, "show"]);
    Route::get("ordenes/almacen/{id}", [OrdenController::class, "almacen"]);
// });

// Route::middleware("authorize:13")->group(function (){
    Route::post("paquetes/create", [PaqueteController::class, "store"]);
    Route::get("cliente/carga/{id}/{matricula}", [PaqueteController::class, "cargaCliente"]);
// });

