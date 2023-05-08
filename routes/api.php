<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WaitNumberController;
use App\Http\Controllers\Api\ShopStatusController;
use App\Http\Controllers\Api\CardRegistController;

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
Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::get('/v1/waiting', [WaitNumberController::class, 'index']);
Route::get('/v1/status', [ShopStatusController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/v1/auth/check', [AuthController::class, 'check']);
    Route::delete('/v1/auth/logout', [AuthController::class, 'logout']);
    Route::post('/v1/waiting', [WaitNumberController::class, 'store']);
    Route::patch('/v1/waiting', [WaitNumberController::class, 'update']);
    Route::delete('/v1/waiting', [WaitNumberController::class, 'destroy']);
    Route::patch('/v1/status', [ShopStatusController::class, 'update']);
    Route::get('/v1/card', [CardRegistController::class, 'index']);
    Route::post('/v1/card', [CardRegistController::class, 'store']);
});
