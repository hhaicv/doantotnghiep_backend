<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewCategoryController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\StopController;
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



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);

});

Route::apiResource('banners', BannerController::class);
Route::apiResource('contacts', ContactController::class);
Route::patch('contacts/{id}/status', [ContactController::class, 'statusContact']);
Route::apiResource('routes', RouteController::class);
Route::patch('routes/{id}/status', [RouteController::class, 'statusRoute']);
Route::apiResource('buses', BusController::class);
Route::apiResource('new-categories', NewCategoryController::class);
Route::patch('new-categories/{id}/status', [NewCategoryController::class, 'statusNewCategory']);
Route::apiResource('information', InformationController::class);




Route::apiResource('stops', StopController::class);

Route::apiResource('home', HomeController::class);
Route::get('/my_ticket/{user_id}', [StopController::class, 'my_ticket'])->name('my_ticket');
Route::post('check', [StopController::class, 'check']);
Route::get('/bill',         [StopController::class, 'bill'])->name('bill');
Route::get('/ticket-booking/{order_code}', [StopController::class, 'show']);
Route::get('/momo_return', [StopController::class, 'momo_return'])->name('momo_return');
Route::get('/vnpay_return', [StopController::class, 'vnpay_return'])->name('vnpay_return');




