<?php

use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\UserController;
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


//---------------------------------------------public route
Route::group([], function () {

    Route::apiResource('products', ProductController::class)->only(['index', 'show']);

    Route::apiResource('cart', CartController::class)->only(['index', 'update', 'store', 'destroy']);

    Route::apiResource('categories', CategoryController::class)->only(['index']);

    Route::apiResource('profile', UserController::class)->only(['show', 'update']);

    Route::group(['prefix' => 'auth'], function () {
        Route::post('signin', [AuthController::class, 'signin']);
        Route::post('signup', [AuthController::class, 'signup']);
        // Route::post('forgot', [AuthController::class, 'forgot']);
        // Route::put('reset', [AuthController::class, 'reset']);
    });

});
