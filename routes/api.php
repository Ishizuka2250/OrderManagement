<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WaitNumberController;
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
Route::post('/v1/login', [AuthController::class, 'login']);
Route::get('/v1/waiting/', [WaitNumberController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::delete('/v1/logout', [AuthController::class, 'logout']);
    Route::get('/v1/check', [AuthController::class, 'check']);
});
