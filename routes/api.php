<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\productsController;

Route::get('/productos', [productsController::class,'index']);


Route::get('/productos/{id}',[productsController::class,'show']);

Route::post('/productos', [productsController::class,'store']);

Route::put('/productos/{id}',[productsController::class,'update']);

Route::delete('/productos/{id}', [productsController::class,'eliminate']);

