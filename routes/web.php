<?php


use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SeatController;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route để hiển thị form nhập mã khuyến mãi
Route::get('/apply-voucher', function() {
    return view('apply-voucher');
})->name('apply-voucher.form');
Route::post('/apply-voucher', [PromotionController::class, 'applyVoucher'])->name('apply-voucher');


