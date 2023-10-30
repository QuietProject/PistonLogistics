<?php

use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\camionerosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ConducenController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehiculosController;
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



Route::view('/login', 'login')->name('login')->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/home', function () {
    return to_route('inicio');
});

Route::view('/', 'index')->name('inicio')->middleware('auth');

Route::resource('camioneros', CamionerosController::class)->middleware('auth')->except(['create', 'edit']);

Route::resource('vehiculos', VehiculosController::class)->middleware('auth')->except(['create', 'edit']);
Route::patch('/vehiculo/{vehiculo}/baja', [VehiculosController::class, 'baja'])->name('vehiculos.baja')->middleware('auth');
Route::patch('/vehiculo/{vehiculo}/operativo', [VehiculosController::class, 'operativo'])->name('vehiculos.operativo')->middleware('auth');

Route::patch('/conducen/hasta/{matricula}/{ci}', [ConducenController::class, 'hasta'])->name('conducen.hasta')->middleware('auth');
Route::get('/conducen/vehiculo/{vehiculo}', [ConducenController::class, 'vehiculo'])->name('conducen.vehiculo')->middleware('auth');
Route::get('/conducen/camionero/{camionero}', [ConducenController::class, 'camionero'])->name('conducen.camionero')->middleware('auth');
Route::patch('/conducen/desde', [ConducenController::class, 'desde'])->name('conducen.desde')->middleware('auth');

Route::resource('clientes', ClientesController::class)->middleware('auth')->except(['create', 'edit']);

Route::resource('almacenes', AlmacenesController::class)->middleware('auth')->except(['create', 'edit'])->parameters(['almacenes' => 'almacen']);;;

Route::resource('usuarios', UsersController::class)->middleware('auth')->except(['create', 'edit'])->parameters(['usuarios' => 'user']);;
Route::post('/usuarios/{user}/reenviarNotificacionEmail', [UsersController::class, 'resendEmailNotification'])->name('usuarios.resendEmailNotification')->middleware('auth', 'throttle:6,1');
Route::post('/usuarios/{user}/reenviarNotificacionPassword', [UsersController::class, 'resendPasswordNotification'])->name('usuarios.resendPasswordNotification')->middleware('auth', 'throttle:6,1');
Route::get('/email/verify/{id}/{hash}', [UsersController::class, 'verify'])->name('verification.verify')->middleware('signed');

Route::view('/forgot-password', 'password.request')->middleware('guest')->name('password.request');
Route::post('/forgot-password', [UsersController::class, 'forgotPassword'])->middleware('guest')->name('password.email');

Route::view('/reset-password/{token}', 'password.reset-password')->middleware('guest')->name('password.reset');


Route::post('/reset-password', [UsersController::class, 'resetPassword'])->middleware('guest')->name('password.update');
