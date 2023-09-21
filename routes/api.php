<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Http\Controllers\CamionController;

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

Route::get("camion/paquetes", [CamionController::class, "verPaquetes"]);
Route::get("camion/lotes", [CamionController::class, "verLotes"]);
Route::get("camion/arranque/{matricula}", [CamionController::class, "arranque"]);
Route::get("camion/parada", [CamionController::class, "parada"]);
Route::get("verEstado/{id}", [CamionController::class, "verEstado"]);
