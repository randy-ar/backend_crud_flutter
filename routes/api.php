<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    // Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::prefix('products')->group(function () {
        Route::get('/', [\App\Http\Controllers\ProductController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\ProductController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\ProductController::class, 'show']);
        Route::post('/{id}', [\App\Http\Controllers\ProductController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\ProductController::class, 'destroy']);
    });
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
