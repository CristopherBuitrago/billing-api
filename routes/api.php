<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas abiertas (no protegidas con JWT)
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Grupo de rutas protegidas con JWT
Route::group(['middleware' => 'auth:api'], function () {
    
    // Obtener todos los clientes
    Route::get('/customers', [CustomerController::class, 'index']);

    // Obtener cliente por nombre
    Route::get('/customers/by-name/{name}', [CustomerController::class, 'show']);

    // Obtener cliente por id
    Route::get('/customers/{id}', [CustomerController::class, 'showById']);

    // Crear nuevo cliente
    Route::post('/customers/create', [CustomerController::class, 'store']);

    // Actualizar cliente
    Route::put('/customers/update/{id}', [CustomerController::class, 'update']);

    // Eliminar cliente
    Route::delete('/customers/delete/{id}', [CustomerController::class, 'destroy']);

    // Perfil de usuario autenticado
    Route::get('/profile', [UserController::class, 'profile']);
});
