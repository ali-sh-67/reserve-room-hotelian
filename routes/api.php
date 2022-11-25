<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReserveController;
use App\Http\Controllers\Api\RoomController;
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
Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
});

Route::get('rooms', [RoomController::class, 'showRooms'])->name('showRooms');

Route::post('reserve/{id}', [ReserveController::class, 'reserve'])->middleware('auth:api')->name('reserve');

Route::get('reserve/history', [ReserveController::class, 'history'])->middleware('auth:api')->name('reserveHistory');
