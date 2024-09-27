<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PacServicioController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\HospitalizacionController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\OtrosServiciosController;
use App\Http\Controllers\ProcedimientosController;
use App\Http\Controllers\RecienNacidoController;
use App\Http\Controllers\UrgenciasController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/hola', function () {
    return "gola";
});


Route::resource('pac', PacServicioController::class);


Route::group(['as'=>'servicios.'  ,'prefix'=>'servicios'],function(){
    Route::resource('pac', PacServicioController::class);
    Route::resource('consultas', ConsultasController::class);
    Route::resource('hospitalizaciones', HospitalizacionController::class);
    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('otrosservicios', OtrosServiciosController::class);
    Route::resource('procedimientos', ProcedimientosController::class);
    Route::resource('reciennacidos', RecienNacidoController::class);
    Route::resource('urgencias', UrgenciasController::class);

});