<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
