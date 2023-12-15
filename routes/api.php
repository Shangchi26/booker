<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RoomController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/uploadImage/{id}', [ProvinceController::class, 'image']);
Route::post('/roomImage/{id}', [RoomController::class, 'addImage']);
Route::post('/roomimage', [RoomController::class, 'addRoomImage']);
Route::post('/banner', [BannerController::class,'create']);
