<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\EmployeeController;

use App\Http\Controllers\HomeEmployeeController;



use Illuminate\Support\Facades\Route;

Route::get('employee/login', [EmployeeController::class, 'showEmployeeLoginForm'])->name('employee.login');
Route::post('employee/login', [EmployeeController::class, 'employeeLogin'])->name('employee.login.submit');
Route::middleware(['employee'])->prefix('employee')->as('employee.')->group(function () {
    // Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/', function () {
        return view('employee.dashboard');
    })->name('dashboard');

    Route::get('/contacts', [HomeEmployeeController::class, 'contacts'])->name('contacts');
    Route::get('/reviews', [HomeEmployeeController::class, 'reviews'])->name('reviews');

});
