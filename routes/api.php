<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/productos', function () {
    return 'Ver productos';
});

Route::get('/productos/{id}', function () {
    return 'Ver producto';
});

Route::post('/productos', function () {
    return 'Crear productos';
});

Route::put('/productos/{id}', function () {
    return 'Actualizar productos';
});

Route::delete('/productos/{id}', function () {
    return 'Eliminar productos';
});
