<?php

use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/regUser',[UserController::class,'regUser']);
Route::post('/logUser',[UserController::class,'logUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);

Route::post('/dodajPredmet',[SubjectController::class,'dodajPredmet']);

Route::get('/getUser',[UserController::class,'getUser']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
