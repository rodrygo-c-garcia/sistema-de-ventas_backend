<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\FotoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\SanctumAuthController;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas protegidas con AUTH_SANCTUM
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('producto', ProductoController::class);
    Route::apiResource('pedido', PedidoController::class);
    // ruta para especificar el metodo de SearchProduct
    Route::get('search', [ProductoController::class, 'searchProduct']);
    // recurso para buscar cliente usando el metodo searchCustomer
    Route::get('searchCustomer', [ClienteController::class, 'searchCustomer']);

    Route::apiResource('imagen', FotoController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('cliente', ClienteController::class);
});

// Rutas Publicas
Route::post('login', [SanctumAuthController::class, 'login']);
Route::post('register', [SanctumAuthController::class, 'register']);

// AUTH_SANCTUM para Usuario
Route::middleware('auth:sanctum')->group(function () {
    Route::get('perfil', [SanctumAuthController::class, 'perfil']);
    Route::post('refresh', [SanctumAuthController::class, 'refresh']);
    Route::post('logout', [SanctumAuthController::class, 'logout']);
});
