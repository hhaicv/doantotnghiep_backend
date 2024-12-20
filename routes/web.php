<?php

use App\Http\Controllers\Auth\DriverLoginController;
use App\Http\Controllers\HomeDriverController;



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

Route::get('/', function () {

    return view('welcome');
});


Route::get('/driver', [DriverLoginController::class, 'showLogin'])->name('driver.login');
Route::post('/driver', [DriverLoginController::class, 'driverLogin'])->name('driver.login.submit');
Route::middleware('driver')->group(function () {
    Route::post('/logout', [DriverLoginController::class, 'driverLogout'])->name('driver.logout');

    Route::get('/driver/dashboard', function () {
        return view('driver.dashboard');
    })->name('driver.dashboard');

    Route::resource('drivers', HomeDriverController::class);
    Route::get('/driver/dashboard', [HomeDriverController::class, 'showDashboard'])->name('driver.dashboard');
});


require __DIR__ . '/auth.php';



