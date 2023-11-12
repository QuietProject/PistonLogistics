<?php

use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\camionerosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ConducenController;
use App\Http\Controllers\LlevaController;
use App\Http\Controllers\ReparteController;
use App\Http\Controllers\TraeController;
use App\Http\Controllers\TroncalesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehiculosController;
use App\Http\Middleware\LocaleCookieMiddleware;
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
Route::get('/home', function () {
    return to_route('inicio');
});

Route::middleware(LocaleCookieMiddleware::class)->group(function () {

    Route::view('/login', 'login')->name('login')->middleware('guest');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::view('/forgot-password', 'password.request')->middleware('guest')->name('password.request');
    Route::post('/forgot-password', [UsersController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
    Route::view('/reset-password/{token}', 'password.reset-password')->middleware('guest')->name('password.reset');
    Route::post('/reset-password', [UsersController::class, 'resetPassword'])->middleware('guest')->name('password.update');
    Route::get('/email/verify/{id}/{hash}', [UsersController::class, 'verify'])->name('verification.verify')->middleware('signed');
});

Route::middleware('auth', LocaleCookieMiddleware::class)->group(function () {

    Route::view('/', 'index')->name('inicio');
    Route::view('/asignar', 'asignar')->name('asignar');

    Route::resource('camioneros', CamionerosController::class)->except(['create', 'edit']);
    Route::resource('clientes', ClientesController::class)->except(['create', 'edit','update']);
    Route::resource('almacenes', AlmacenesController::class)->except(['create', 'edit'])->parameters(['almacenes' => 'almacen']);

    Route::resource('troncales', TroncalesController::class)->except(['create', 'edit'])->parameters(['troncales' => 'troncal']);
    Route::get('/ordenes/{troncal}/edit', [TroncalesController::class, 'ordenes'])->name('ordenes.edit');
    Route::patch('/ordenes/{troncal}', [TroncalesController::class, 'ordenesUpdate'])->name('ordenes.update');

    Route::resource('vehiculos', VehiculosController::class)->except(['create', 'edit']);
    Route::patch('/vehiculo/{vehiculo}/baja', [VehiculosController::class, 'baja'])->name('vehiculos.baja');
    Route::patch('/vehiculo/{vehiculo}/operativo', [VehiculosController::class, 'operativo'])->name('vehiculos.operativo');

    Route::resource('usuarios', UsersController::class)->except(['create', 'edit'])->parameters(['usuarios' => 'user']);
    Route::post('/usuarios/{user}/reenviarNotificacionEmail', [UsersController::class, 'resendEmailNotification'])->name('usuarios.resendEmailNotification')->middleware('throttle:6,1');
    Route::post('/usuarios/{user}/reenviarNotificacionPassword', [UsersController::class, 'resendPasswordNotification'])->name('usuarios.resendPasswordNotification')->middleware('throttle:6,1');

    Route::patch('/conducen/hasta/{matricula}/{ci}', [ConducenController::class, 'hasta'])->name('conducen.hasta');
    Route::get('/conducen/vehiculo/{vehiculo}', [ConducenController::class, 'vehiculo'])->name('conducen.vehiculo');
    Route::get('/conducen/camionero/{camionero}', [ConducenController::class, 'camionero'])->name('conducen.camionero');
    Route::patch('/conducen/desde', [ConducenController::class, 'desde'])->name('conducen.desde');

    Route::get('/asignar/lleva', [LlevaController::class, 'index'])->name('lleva.index');
    Route::get('/asignar/lleva/{lote}', [LlevaController::class, 'show'])->name('lleva.show');
    Route::post('/asignar/lleva/{lote}', [LlevaController::class, 'store'])->name('lleva.store');

    Route::get('/asignar/reparte', [ReparteController::class, 'index'])->name('reparte.index');
    Route::get('/asignar/reparte/{paquete}', [ReparteController::class, 'show'])->name('reparte.show');
    Route::post('/asignar/reparte/{paquete}', [ReparteController::class, 'store'])->name('reparte.store');

    Route::get('/asignar/trae', [TraeController::class, 'index'])->name('trae.index');
    Route::get('/asignar/trae/{paquete}', [TraeController::class, 'show'])->name('trae.show');
    Route::post('/asignar/trae/{paquete}', [TraeController::class, 'store'])->name('trae.store');


});

Route::get('/locale/{locale}', function ($locale) {
    if ($locale == 'es' || $locale == 'en') return redirect()->back()->withCookie('locale', $locale);
    return redirect()->back()->with('error', 'Ha ocurrido un error');
})->name('locale');

