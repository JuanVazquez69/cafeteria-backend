<?php

use App\Http\Controllers\AlimentosController;
use App\Http\Controllers\EntregaUbicacionController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PlantillaEncabezadosController;
use App\Http\Controllers\TipoCampoController;
use App\Http\Controllers\TipoContactoController;
use App\Http\Controllers\TipoPagoController;
use App\Http\Controllers\TipoPlantillaController;
use App\Http\Controllers\UserController;
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

Route::controller(TipoContactoController::class)->prefix('tipo_contacto')->group(function(){
    Route::get('/', 'index')->name('tipo-contacto.index');
    Route::post('/store', 'store')->name('tipo-contacto.store');
    Route::put('/update/{id}', 'update')->name('tipo-contacto.update');
    Route::put('/baja', 'baja')->name('tipo-contacto.baja');
    Route::delete('/delete', 'destroy')->name('tipo-contacto.destroy');
});

Route::controller(PerfilController::class)->prefix('perfil')->group(function(){
    Route::get('/', 'index')->name('perfil.index');
    Route::post('/store', 'store')->name('perfil.store');
    Route::put('/update/{id}', 'update')->name('perfil.update');
    Route::put('/baja', 'baja')->name('perfil.baja');
    Route::delete('/delete', 'destroy')->name('perfil.destroy');
});

Route::controller(PlantillaEncabezadosController::class)->prefix('plantillas')->group(function(){
    Route::get('/', 'index')->name('plantillas.index');
    Route::post('/store', 'store')->name('plantillas.store');
    Route::put('/update', 'update')->name('plantilla.update');
    Route::put('/baja', 'baja')->name('plantillas.baja');
    Route::put('/alta', 'alta')->name('plantillas.alta');
});

Route::controller(TipoPlantillaController::class)->prefix('tipo_plantilla')->group(function(){
    Route::get('/', 'index')->name('tipo_plantila.index');
    Route::post('/store', 'store')->name('tipo_plantilla.store');
    Route::put('/update/{id}', 'update')->name('tipo_plantilla.update');
    Route::put('/baja', 'baja')->name('tipo_plantilla.baja');
    Route::delete('/delete', 'delete')->name('tipo_plantilla.delete');
});

Route::controller(TipoCampoController::class)->prefix('tipo_campo')->group(function(){
    Route::get('/', 'index')->name('tipo_campo.index');
    Route::post('/store', 'store')->name('tipo_campo.store');
    Route::post('/storeList', 'storeList')->name('tipo_campo.storeList');
    Route::put('/update/{id}', 'update')->name('tipo_campo.update');
    Route::put('/baja', 'baja')->name('tipo_campo.baja');
    Route::delete('/delete', 'delete')->name('tipo_campo.delete');
});

Route::controller(AlimentosController::class)->prefix('alimentos')->group(function(){
   Route::get('/', 'index')->name('alimentos.index');     
});

Route::controller(TipoPagoController::class)->prefix('tipo_pago')->group(function(){
    Route::get('/', 'index')->name('tipo_pago.index');
    Route::post('/store', 'store')->name('tipo_pago.store');
    Route::put('/update', 'update')->name('tipo_pago.update');
    Route::put('/baja', 'baja')->name('tipo_pago.baja');
    Route::delete('/delete', 'delete')->name('tipo_pago.delete');
});

Route::controller(EntregaUbicacionController::class)->prefix('ubicacion')->group(function(){
    Route::get('/', 'index')->name('ubicacion.index');
    Route::post('/store', 'store')->name('ubicacion.store');
    Route::put('/update', 'update')->name('ubicacion.update');
    Route::put('/baja', 'baja')->name('ubicacion.baja');
    Route::delete('/delete', 'delete')->name('ubicacion.delete');
});

Route::controller(PedidosController::class)->prefix('pedido')->group(function(){
    Route::get('/', 'index')->name('pedido.index');
    Route::post('/store', 'store')->name('pedido.store');
    Route::put('/update', 'update')->name('pedido.update');
    Route::put('/baja', 'baja')->name('pedido.baja');
    Route::delete('/delete', 'delete')->name('pedido.delete');
});