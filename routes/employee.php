<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\EmployeeController;

use App\Http\Controllers\HomeEmployeeController;
use App\Http\Controllers\TicketBookingController;
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
    Route::get('/routes', [HomeEmployeeController::class, 'routes'])->name('routes');
    Route::get('/stops', [HomeEmployeeController::class, 'stops'])->name('stops');
    Route::get('/trips', [HomeEmployeeController::class, 'trips'])->name('trips');
    Route::get('/bus_seats', [HomeEmployeeController::class, 'bus_seats'])->name('bus_seats');
    Route::get('/buses', [HomeEmployeeController::class, 'buses'])->name('buses');
    Route::get('/information', [HomeEmployeeController::class, 'information'])->name('information');

    // Route group cho tickets
    Route::get('/tickets', [HomeEmployeeController::class, 'tickets'])->name('tickets');
    Route::post('/upload-ticket', [HomeEmployeeController::class, 'uploadTicket'])->name('uploadTicket');
    Route::get('/tickets/create', [HomeEmployeeController::class, 'create'])->name('tickets.create');
    Route::post('/tickets/store', [HomeEmployeeController::class, 'store'])->name('tickets.store');
    Route::get('/fetch-trips', [HomeEmployeeController::class, 'uploadTicket'])->name('fetch.trips'); // Lấy danh sách chuyến đi
});
