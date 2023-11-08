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

Route::resource("paquetes", PaqueteController::class);
Route::post("paquetes/create", [PaqueteController::class, "store"]);
Route::get("cliente/carga/{id}/{matricula}", [PaqueteController::class, "cargaCliente"]);
Route::get("almacen/descarga/{id}/{almacen}", [PaqueteController::class, "descargaPaquete"]);
Route::get("almacen/carga/reparte", [PaqueteController::class, "cargaReparte"]);

Route::get("lotes/cargar", [LoteController::class, "cargaLote"]);
Route::get("lotes/descargar", [LoteController::class, "descargaLote"]);
Route::get("lotes/contenido", [LoteController::class, "paquetesEnLote"]);
Route::get("lotes", [LoteController::class, "index"]);
Route::post("lotes/create", [LoteController::class, "store"]);
Route::get("lotes/agregar/paquete", [LoteController::class, "agregarPaqueteToLote"]);
Route::post("lotes/eliminar/paquete", [LoteController::class, "quitarPaquete"]);
Route::get("/lotes/pronto", [LoteController::class, "lotePronto"]);

Route::get("ordenes/almacen/{almacen}", [OrdenController::class, "almacen"]);
Route::get("ordenes/troncal/{troncal}", [OrdenController::class, "troncal"]);
