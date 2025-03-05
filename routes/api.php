<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\TipoContactoController;
use App\Http\Controllers\UserController;
use App\Models\Perfil;
use App\Models\TipoContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/saludo', function () {
    return response()->json(['mensaje' => '¡Hola desde la API!']);
});

Route::controller(UserController::class)->prefix('user')->group(function(){
    Route::get('/', 'index')->name('user.index');
    Route::post('/login', 'login')->name('user.login');
    Route::post('/store', 'store')->name('user.store');
    Route::put('/update', 'update')->name('user.update');
    Route::put('/baja', 'baja')->name('user.baja');
    Route::delete('/delete', 'destroy')->name('user.destroy');
});

Route::controller(TipoContactoController::class)->prefix('tipo-contacto')->group(function(){
    Route::get('/', 'index')->name('tipo-contacto.index');
    Route::post('/store', 'store')->name('tipo-contacto.store');
    Route::put('/update', 'update')->name('tipo-contacto.update');
    Route::put('/baja', 'baja')->name('tipo-contacto.baja');
    Route::delete('/delete', 'destroy')->name('tipo-contacto.destroy');
});

Route::controller(PerfilController::class)->prefix('perfil')->group(function(){
    Route::get('/', 'index')->name('perfil.index');
    Route::post('/store', 'store')->name('perfil.store');
    Route::put('/update', 'update')->name('perfil.update');
    Route::put('/baja', 'baja')->name('perfil.baja');
    Route::delete('/delete', 'destroy')->name('perfil.destroy');
});