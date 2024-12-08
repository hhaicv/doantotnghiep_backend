<?php

use App\Http\Controllers\Auth\DriverLoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HomeDriverController;
use App\Http\Controllers\ProfileController;


use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SeatController;

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

Route::get('/driver', [DriverLoginController::class, 'showLogin'])->name('driver.login');
Route::post('/driver', [DriverLoginController::class, 'driverLogin'])->name('driver.login.submit');
Route::middleware('driver')->group(function () {
    Route::post('/driver/logout', [DriverLoginController::class, 'driverLogout'])->name('driver.logout');

    Route::get('/driver/dashboard', function () {
        return view('driver.dashboard');
    })->name('driver.dashboard');

    Route::resource('drivers', HomeDriverController::class);
    Route::get('/driver/dashboard', [HomeDriverController::class, 'showDashboard'])->name('driver.dashboard');


});


require __DIR__ . '/auth.php';
// Route để hiển thị form nhập mã khuyến mãi
// Route::get('/apply-voucher', function() {
//     return view('apply-voucher');
// })->name('apply-voucher.form');
// Route::post('/apply-voucher', [PromotionController::class, 'applyVoucher'])->name('apply-voucher');


