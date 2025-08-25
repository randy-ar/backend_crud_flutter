<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json('Hello World!');
});

Route::get('/login', function () {
    return response()->json('Please Login!');
})->name('login');
