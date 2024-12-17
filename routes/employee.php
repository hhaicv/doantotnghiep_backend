<?php

use App\Http\Controllers\Auth\EmployeeController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HomeEmployeeController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\TicketBookingController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [EmployeeController::class, 'showEmployeeLoginForm'])->name('employee.login');
Route::post('/login', [EmployeeController::class, 'employeeLogin'])->name('employee.login.submit');
Route::middleware(['employee'])->prefix('employee')->as('employee.')->group(function () {
    Route::post('/logout', [EmployeeController::class, 'employeeLogout'])->name('logout');

    // Route::get('/', function () {
    //     return view('employee.dashboard');
    // })->name('dashboard');
    Route::get('/', [HomeEmployeeController::class, 'tripStatistical'])->name('dashboard');

    // Route::get('/dashboard', [HomeEmployeeController::class, 'tripStatistical'])->name('tripStatistical');
    Route::get('/contacts', [HomeEmployeeController::class, 'contacts'])->name('contacts');
    Route::post('/status-contacts/{id}', [HomeEmployeeController::class, 'statusContact']);

    Route::get('/banners', [HomeEmployeeController::class, 'banners'])->name('banners');
    Route::get('/banners/create', [HomeEmployeeController::class, 'createBanner'])->name('banners.create');
    Route::post('/banners', [HomeEmployeeController::class, 'storeBanner'])->name('banners.store');
    Route::post('/status-banners/{id}', [HomeEmployeeController::class, 'statusBanners']);
    Route::get('/banners/{id}/edit', [HomeEmployeeController::class, 'editBanner'])->name('banners.edit');
    Route::put('/banners/{id}', [HomeEmployeeController::class, 'updateBanner'])->name('banners.update');
    Route::delete('/banners/{id}', [HomeEmployeeController::class, 'destroyBanner'])->name('banners.destroy');



    Route::get('/buses', [HomeEmployeeController::class, 'buses'])->name('buses');
    Route::post('/status-buses/{id}', [HomeEmployeeController::class, 'statusBuses']);
    Route::get('/buses/{id}/edit', [HomeEmployeeController::class, 'editBus'])->name('buses.edit');
    Route::put('/buses/{id}', [HomeEmployeeController::class, 'updateBus'])->name('buses.update');
    Route::get('/buses/create', [HomeEmployeeController::class, 'createBus'])->name('buses.create');
    Route::post('/buses', [HomeEmployeeController::class, 'storeBus'])->name('buses.store');
    Route::delete('/buses/{id}', [HomeEmployeeController::class, 'destroyBus'])->name('buses.destroy');

    // Routes
    // Routes
    Route::get('/routes', [HomeEmployeeController::class, 'routes'])->name('routes');
    Route::post('/status-route/{id}', [HomeEmployeeController::class, 'statusRoute']);
    Route::get('/routes/{id}/edit', [HomeEmployeeController::class, 'editRoute'])->name('routes.edit');
    Route::put('/routes/{id}', [HomeEmployeeController::class, 'updateRoute'])->name('routes.update');
    Route::get('/routes/create', [HomeEmployeeController::class, 'createRoute'])->name('routes.create');
    Route::post('/routes', [HomeEmployeeController::class, 'storeRoute'])->name('routes.store');
    Route::delete('/routes/{id}', [HomeEmployeeController::class, 'destroyRoute'])->name('routes.destroy');

    // Stops
    Route::get('/stops', [HomeEmployeeController::class, 'stops'])->name('stops');
    Route::post('/status-stop/{id}', [HomeEmployeeController::class, 'statusStop']);
    Route::get('/stops/{id}/edit', [HomeEmployeeController::class, 'editStop'])->name('stops.edit');
    Route::put('/stops/{id}', [HomeEmployeeController::class, 'updateStop'])->name('stops.update');
    Route::get('/stops/create', [HomeEmployeeController::class, 'createStop'])->name('stops.create');
    Route::post('/stops', [HomeEmployeeController::class, 'storeStop'])->name('stops.store');
    Route::delete('/stops/{id}', [HomeEmployeeController::class, 'destroyStop'])->name('stops.destroy');

    // Promotions
    Route::get('/promotions', [HomeEmployeeController::class, 'promotions'])->name('promotions');
    Route::get('/promotions/{id}/edit', [HomeEmployeeController::class, 'editPromotion'])->name('promotions.edit');
    Route::put('/promotions/{id}', [HomeEmployeeController::class, 'updatePromotion'])->name('promotions.update');
    Route::get('/promotions/create', [HomeEmployeeController::class, 'createPromotion'])->name('promotions.create');
    Route::post('/promotions', [HomeEmployeeController::class, 'storePromotion'])->name('promotions.store');
    Route::delete('/promotions/{id}', [HomeEmployeeController::class, 'destroyPromotion'])->name('promotions.destroy');



    // Trips
    Route::get('/trips', [HomeEmployeeController::class, 'trips'])->name('trips');
    Route::post('/status-trip/{id}', [HomeEmployeeController::class, 'statusTrip']);
    Route::get('/trips/create', [HomeEmployeeController::class, 'createTrip'])->name('trips.create');
    Route::post('/trips', [HomeEmployeeController::class, 'storeTrip'])->name('trips.store');
    Route::get('/trips/{id}/edit', [HomeEmployeeController::class, 'editTrip'])->name('trips.edit');
    Route::put('/trips/{id}', [HomeEmployeeController::class, 'updateTrip'])->name('trips.update');
    Route::delete('/trips/{id}', [HomeEmployeeController::class, 'destroyTrip'])->name('trips.destroy');
    Route::get('/routes/{id}/cycle', [HomeEmployeeController::class, 'getRouteCycle'])->name('routes.cycle');



    Route::get('/tickets', [HomeEmployeeController::class, 'tickets'])->name('tickets');
    Route::get('/list', [HomeEmployeeController::class, 'listtickets'])->name('ticket_list');
    Route::get('/show/{id}', [HomeEmployeeController::class, 'show'])->name('show');
    Route::post('/upload-ticket', [HomeEmployeeController::class, 'uploadTicket'])->name('tickets.upload');
    Route::get('/tickets/create', [HomeEmployeeController::class, 'create'])->name('tickets_create');
    Route::get('/change/{id}', [HomeEmployeeController::class, 'change'])->name('tickets_change');
    Route::get('/load', [HomeEmployeeController::class, 'load'])->name('tickets_load');

    Route::post('/store-tickets', [HomeEmployeeController::class, 'storeTicket'])->name('tickets.store');

    Route::get('/reviews', [HomeEmployeeController::class, 'reviews'])->name('reviews');
    Route::get('/send-notification', [HomeEmployeeController::class, 'sendPromotionNotification']);

    Route::get('/fetch-trips', [HomeEmployeeController::class, 'store'])->name('fetch.trips');
    Route::get('/fetch-trips', [HomeEmployeeController::class, 'uploadTicket'])->name('fetch.trips');
    Route::get('/thanks', [HomeEmployeeController::class, 'thanks'])->name('thanks');
    Route::get('/momo_return', [HomeEmployeeController::class, 'momo_return'])->name('momo_return');
    Route::get('/vnpay_return', [TicketBookingController::class, 'vnpay_return'])->name('vnpay_return');
});
