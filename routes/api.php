<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\LoteController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
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
Route::post('auth/register',[ApiController::class,'register']);
Route::post('auth/login', [ApiController::class,'authenticate']);
Route::group([

    'middleware' => ['jwtVerify'],
    'prefix' => 'v1'

], function ($router) {

    Route::apiResource('users',UserController::class);
    Route::apiResource('orders',OrderController::class);
    Route::apiResource('products',ProductController::class);
    Route::apiResource('lotes',LoteController::class);
    Route::apiResource('clients',ClientController::class);



});


