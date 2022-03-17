<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StageController;
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


//stagiaire
Route::post("/stages/register",[StageController::class,"register"]);
Route::post("/stages/login",[StageController::class,"login"]);

//post request
Route::post("/users/register",[AuthController::class,"register"]);
Route::post("/users/login",[AuthController::class,"login"]);
Route::post('/stage',[stageController::class,'store']);





//protected routes
Route::group(['middleware' => ['auth:sanctum','banned']], function () {
    //all users
Route::put("/users/{id}",[AuthController::class,"update"]);
  //service rh
Route::get("/users",[AuthController::class,"index"])->middleware('service');
Route::get("/users/{id}",[AuthController::class,"show"])->middleware('service');
// coordinator & admin
Route::post("/users",[AuthController::class,"store"])->middleware('coordinator');

Route::delete("/users/{id}",[AuthController::class,"destroy"]);

});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
