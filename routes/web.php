<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\camionerosController;
use App\Http\Controllers\VehiculosController;
use Illuminate\Support\Facades\Hash;
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
Route::get('/prueba', [AuthenticatedSessionController::class, 'prueba']);

Route::get('/home', function(){
    return to_route('inicio');
});
Route::view('/', 'index')->name('inicio')->middleware('auth');

Route::resource('camioneros', CamionerosController::class);//->middleware('auth');

Route::resource('vehiculos', VehiculosController::class);//->middleware('auth');

Route::view('/login','login')->name('login')->middleware('guest');
Route::post('/login',[AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::get('/logout',[AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');



