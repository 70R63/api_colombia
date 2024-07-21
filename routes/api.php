<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PacServicioController;


Route::name('api.')->group(function () {
      


    Route::group([
        "middleware"=>["auth:sanctum"]
    ], function(){
        Route::post("profile", [UserController::class, "profile"]);
        Route::post("logout", [UserController::class, "logout"]);

        Route::get('pingAuth', function (Request $request) {
            return "hola";
        }); 


        Route::group(['prefix'=>'dian','as'=>'dian.'], function(){
            Route::post("/", [PacServicioController::class, "store"])->name("store");
            
        });
        

    }

    );


    Route::post("register", [UserController::class, "register"])->name("register");
    Route::post("login", [UserController::class, "login"])->name("login");

    Route::get('ping', function (Request $request) {
        return "hola";
    });  

});

