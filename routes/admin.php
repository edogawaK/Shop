<?php

use App\Http\Controllers\Private\AuthController as AdminAuth;
use App\Http\Controllers\Private\CategoryController;
use App\Http\Controllers\Private\ImageController;
use App\Http\Controllers\Private\ProductController;
use App\Http\Controllers\Private\SizeController;
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

    Route::apiResource('products', ProductController::class);
    Route::apiResource('products.images', ImageController::class)->parameters([
        'products'=>'productId',
        'images'=>'id',
    ]);
    // Route::apiResource('products.rates', RateController::class)->only(['index', 'store', 'update', 'destroy'])->parameters([
    //     'products' => 'productId',
    //     'rates' => 'id',
    // ]);
    // Route::apiResource('user.locates', RateController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('sizes', SizeController::class);
    // Route::apiResource('cart', CartController::class)->only(['index', 'update', 'store', 'destroy']);

    // Route::apiResource('orders', OrderController::class);

    // Route::apiResource('profile', UserController::class)->only(['show', 'update']);

    Route::group(['prefix' => 'auth'], function () {
        Route::post('signin', [AdminAuth::class, 'signin']);
        Route::post('signup', [AdminAuth::class, 'signup']);
        // Route::post('forgot', [AuthController::class, 'forgot']);
        // Route::put('reset', [AuthController::class, 'reset']);
    });

});
