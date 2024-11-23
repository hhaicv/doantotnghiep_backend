<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\EmployeeController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeEmployeeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\TicketBookingController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('employee/login', [EmployeeController::class, 'showEmployeeLoginForm'])->name('employee.login');
Route::post('employee/login', [EmployeeController::class, 'employeeLogin'])->name('employee.login.submit');
Route::middleware(['employee'])->prefix('employee')->as('employee.')->group(function () {
    // Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/', function () {
        return view('employee.dashboard');
    })->name('dashboard');

    Route::resource('contacts', ContactController::class);
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);

    Route::resource('buses', BusController::class);
    Route::post('/status-buses/{id}', [BusController::class, 'statusBuses']);

    // Route::resource('drivers', DriverController::class);
    // Route::post('/status-drivers/{id}', [DriverController::class, 'statusDriver']);


    Route::resource('routes', RouteController::class);
    Route::post('/status-route/{id}', [RouteController::class, 'statusRoute']);

    Route::resource('stops', StopController::class);
    Route::post('/status-stop/{id}', [StopController::class, 'statusStop']);

    Route::resource('promotions', PromotionController::class);
    Route::post('/status-promotion/{id}', [PromotionController::class, 'statusPromotion']);

    Route::resource('trips', TripController::class);
    Route::post('/status-trip/{id}', [TripController::class, 'statusTrip']);

    Route::resource('tickets', TicketBookingController::class);
    Route::get('/list', [TicketBookingController::class, 'list'])->name('ticket_list');
    

    Route::resource('reviews', ReviewController::class);
    Route::get('/send-notification', [PromotionController::class, 'sendPromotionNotification']);



    Route::get('/fetch-trips', [TicketBookingController::class, 'store'])->name('fetch.trips');

    Route::get('/fetch-trips', [TicketBookingController::class, 'uploadTicket'])->name('fetch.trips');
    Route::get('/thanks', [TicketBookingController::class, 'thanks'])->name('thanks');
    Route::get('/momo_return', [TicketBookingController::class, 'momo_return'])->name('momo_return');
    Route::get('/vnpay_return', [TicketBookingController::class, 'vnpay_return'])->name('vnpay_return');
});
