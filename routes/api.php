<?php

use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\StopController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\VNPayController;
use App\Http\Controllers\PromotionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('stops', StopController::class);

Route::apiResource('home', HomeController::class);

Route::get('/bill',         [StopController::class, 'bill'])->name('bill');
Route::get('/momo_return', [StopController::class, 'momo_return'])->name('momo_return');
Route::get('/vnpay_return', [StopController::class, 'vnpay_return'])->name('vnpay_return');




