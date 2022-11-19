<?php

use App\Mail\GuiEmail;
use Illuminate\Support\Facades\Mail;
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

Route::group([], __DIR__ . '/admin.php');
Route::group([], __DIR__ . '/user.php');
Route::get('/nkkn',function(){
    Mail::to('kisenguyen1410263@gmail.com')->send(new GuiEmail());
});