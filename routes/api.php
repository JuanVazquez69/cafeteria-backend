<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/saludo', function () {
    return response()->json(['mensaje' => '¡Hola desde la API!']);
});

Route::get('/usuarios', [UserController::class, 'index']);
Route::post('/usuarios/store', [UserController::class, 'store']);

Route::post('/perfil/store', [PerfilController::class, 'store']);