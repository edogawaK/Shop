<?php

use App\Http\Controllers\Private\AuthController as AdminAuth;
use App\Http\Controllers\Private\CategoryController;
use App\Http\Controllers\Private\ImageController;
use App\Http\Controllers\Private\OrderController;
use App\Http\Controllers\Private\ProductController;
use App\Http\Controllers\Private\SaleController;
use App\Http\Controllers\Private\SizeController;
use App\Http\Controllers\Private\StatisticController;
use App\Http\Controllers\Private\UserController;
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

//---------------------------------------------private route
Route::group(['prefix' => 'admin'], function () {
    Route::apiResource('images', ImageController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('sizes', SizeController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('statistic', StatisticController::class)->only(['index']);
    Route::apiResource('users', UserController::class);
    // Route::apiResource('profile', UserController::class)->only(['show', 'update']);
    Route::group(['prefix' => 'auth'], function () {
        Route::post('signin', [AdminAuth::class, 'signin']);
        // Route::post('forgot', [AuthController::class, 'forgot']);
        // Route::put('reset', [AuthController::class, 'reset']);
    });
});
