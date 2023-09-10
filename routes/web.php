<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/regUser',[UserController::class,'regUser']);
Route::post('/logUser',[UserController::class,'logUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);
Route::get('/getUser',[UserController::class,'getUser']);

Route::post('/dodajGrupu',[GroupController::class,'dodajGrupu']);
Route::get('/getGroup',[GroupController::class,'getGroup']);
Route::post('/izbrisiGrupu/{id}',[GroupController::class,'izbrisiGrupu']);
Route::post('/urediGrupu/{id}',[GroupController::class,'urediGrupu']);
Route::get('/getGroup/{id}',[GroupController::class,'getGrupu']);

Route::post('/dodajClana',[MemberController::class,'dodajClana']);
Route::get('/getMember',[MemberController::class,'getMember']);
Route::get('/getMember/{id}',[MemberController::class,'getClan']);

Route::post('/addPost',[PostController::class,'addPost']);
Route::get('/getPost/{id}',[PostController::class,'getPost']);
Route::post('/izbrisiPost/{id}',[PostController::class,'izbrisiPost']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
