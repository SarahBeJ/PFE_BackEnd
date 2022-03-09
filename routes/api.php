<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\stageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




//post request
Route::post("/users/register",[AuthController::class,"register"]);
Route::post("/users/login",[AuthController::class,"login"]);
Route::post('/stage',[stageController::class,'store']);

//get request
Route::get("/stage",[stageController::class,'index']);
Route::get('/stage/search/{nom}',[stage::class,'search']);
Route::get('/stage/{id}',[stage::class,'show']);



//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
Route::get("/users",[AuthController::class,"index"]);
Route::post('/stage',[stageController::class,'store']);
Route::put('/stage/{id}',[stageController::class,'update']);
Route::put('/stage/{id}',[stageController::class,'destroy']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
