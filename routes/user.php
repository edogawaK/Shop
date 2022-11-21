<?php
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\OrderController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\RateController;
use App\Http\Controllers\Public\UserController;
use Illuminate\Support\Facades\Route;

//---------------------------------------------public route
Route::group([], function () {

    Route::apiResource('products', ProductController::class)->only(['index', 'show']);

    Route::apiResource('products.rates', RateController::class)->only(['index', 'store', 'update', 'destroy'])->parameters([
        'products' => 'productId',
        'rates' => 'id',
    ]);

    Route::apiResource('categories', CategoryController::class)->only(['index']);

    Route::apiResource('cart', CartController::class)->only(['index', 'update', 'store', 'destroy']);

    Route::apiResource('orders', OrderController::class);

    Route::apiResource('profile', UserController::class)->only(['show', 'update']);

    Route::group(['prefix' => 'auth'], function () {
        Route::post('signin', [AuthController::class, 'signin']);
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::get('verify-email', [AuthController::class, 'verifyAccount']);
        Route::get('forgot-password/{email}', [AuthController::class, 'forgotPassword']);
        Route::get('logout', [AuthController::class, 'logout']);
    });

});
