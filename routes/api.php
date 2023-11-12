<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use Carbon\Carbon;

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

Route::get("/getLotes", [PackageController::class, "getLotesAsignar"])->name('getLotes')->withoutMiddleware(['csrf']);

Route::get("/paquetesLote", [PackageController::class, "getPaquetesLote"])->name("getPaquetesLote");

Route::get("/pronto/{idLote}", [PackageController::class, "lotePronto"])->name("lotePronto");

Route::get("/almacenDescarga", [PackageController::class, "getPaqueteOrLoteCodigo"])->name("getPaqueteOrLoteCodigo");
