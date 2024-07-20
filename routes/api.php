<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;

Route::name('api.')->group(function () {
    Route::post("register", [UserController::class, "register"])->name("register");
    Route::post("login", [UserController::class, "login"])->name("login");

    Route::get('ping', function (Request $request) {
        return "hola";
    });    
});


/*
Route::post("login", [UserController::class, "login"]);

Route::group([
        "middleware"=>["auth:sanctum"]
    ], function(){
        Route::post("profile", [UserController::class, "profile"]);
        Route::post("logout", [UserController::class, "logout"]);
    }

);

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/