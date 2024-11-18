<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\productsController;
use App\Http\Controllers\Api\orderController;
use App\Http\Middleware\CorsMiddleware;

// Agrupar todas las rutas bajo el middleware CORS
Route::middleware([CorsMiddleware::class])->group(function () {

//Rutas productos

Route::get('/productos', [productsController::class,'index']);

Route::get('/productos/{id}',[productsController::class,'show']);

Route::post('/productos', [productsController::class,'store']);

Route::put('/productos/{id}',[productsController::class,'update']);

Route::delete('/productos/{id}', [productsController::class,'eliminate']);

// Rutas de órdenes

Route::get('/ordenes', [OrderController::class, 'index']);

Route::get('/ordenes/{id}', [OrderController::class, 'show']);

Route::post('/ordenes', [OrderController::class, 'store']);

Route::put('/ordenes/{id}', [OrderController::class, 'update']);

Route::delete('/ordenes/{id}', [OrderController::class, 'destroy']);
});
