<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PacServicioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hola', function () {
    return "gola";
});


Route::resource('PacServicio',PacServicioController::class);