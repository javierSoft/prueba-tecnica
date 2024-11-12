<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\productsController;

Route::get('/productos', [productsController::class,'index']);


Route::get('/productos/{id}', function () {
    return 'Ver producto';
});

Route::post('/productos', [productsController::class,'store']);

Route::put('/productos/{id}', function () {
    return 'Actualizar productos';
});

Route::delete('/productos/{id}', function () {
    return 'Eliminar productos';
});
