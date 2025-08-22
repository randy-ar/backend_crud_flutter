<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products', \App\Http\Controllers\ProductController::class); 
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
