<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\LoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource("paquetes", PaqueteController::class);
Route::post("paquetes/create/{id}", [PaqueteController::class, "store"]);
Route::get("cliente/carga/{id}/{matricula}", [PaqueteController::class, "cargaCliente"]);
Route::get("almacen/descarga/{id}/{almacen}", [PaqueteController::class, "descargaPaquete"]);
Route::get("almacen/carga/{id}/{matricula}", [PaqueteController::class, "cargaAlmacen"]);
Route::get("lotes/contenido", [LoteController::class, "paquetesEnLote"]);
Route::get("lotes", [LoteController::class, "index"]);
Route::post("lotes/create", [LoteController::class, "store"]);
