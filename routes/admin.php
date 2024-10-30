<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\BusSeatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewCategoryController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TicketBookingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AdminController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'adminLogin'])->name('admin.login.submit');

Route::middleware(['admin'])->prefix('admin')->as('admin.')->group(function () {
    // Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('contacts', ContactController::class);
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);

    Route::resource('roles', RoleController::class);
    Route::post('/status-roles/{id}', [RoleController::class, 'statusRole']);

    Route::resource('buses', BusController::class);
    Route::post('/status-buses/{id}', [BusController::class, 'statusBuses']);

    Route::resource('banners', BannerController::class);
    Route::post('/status-banners/{id}', [BannerController::class, 'statusBanner']);

    Route::resource('new_categories', NewCategoryController::class);
    Route::post('/status-new-category/{id}', [App\Http\Controllers\NewCategoryController::class, 'statusNewCategory']);
    Route::resource('information', InformationController::class);



    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);
    Route::resource('information', InformationController::class);


    Route::resource('routes', RouteController::class);
    Route::post('/status-route/{id}', [RouteController::class, 'statusRoute']);

    Route::resource('stops', StopController::class);
    Route::post('/status-stop/{id}', [StopController::class, 'statusStop']);


    Route::resource('promotions', PromotionController::class);
    Route::post('/status-promotion/{id}', [PromotionController::class, 'statusPromotion']);

    Route::resource('trips', TripController::class);
    Route::post('/status-trip/{id}', [TripController::class, 'statusTrip']);


    Route::resource('tickets', TicketBookingController::class);

    Route::resource('bus_seats', BusSeatController::class);
    Route::post('/status-bus-seat/{id}', [BusSeatController::class, 'statusBusSeat']);

    Route::resource('reviews', ReviewController::class);

    // Route cho thống kê doanh thu
    Route::get('/statistics/revenue', [StatisticsController::class, 'showRevenue'])->name('statistics.revenue');

    // Route cho thống kê vé
    Route::get('/statistics/tickets', [StatisticsController::class, 'ticketStatistics'])->name('statistics.tickets');

    // Route cho thống kê số lượng vé đặt theo tuyến đường
    Route::get('/statistics/tickets-by-route', [StatisticsController::class, 'ticketsByRoute'])->name('statistics.ticketsByRoute');

    // Route cho thống kê số lượng vé đặt theo loại xe
    Route::get('/statistics/tickets-by-bus-type', [StatisticsController::class, 'ticketsByBusType'])->name('statistics.ticketsByBusType');

    // Route cho chuyến xe được đặt nhiều nhất
    Route::get('/statistics/most-booked-trip', [StatisticsController::class, 'mostBookedTrip'])->name('statistics.mostBookedTrip');

    // Route cho tỷ lệ lấp đầy của các chuyến
    Route::get('/statistics/trip-occupancy-rate', [StatisticsController::class, 'tripOccupancyRate'])->name('statistics.tripOccupancyRate');

    // Route cho thống kê người dùng
    Route::get('/statistics/new-users', [StatisticsController::class, 'newUserStatistics'])->name('statistics.newUsers');

    // Route cho tỷ lệ quay lại của khách hàng
    Route::get('/statistics/customer-return-rate', [StatisticsController::class, 'customerReturnRate'])->name('statistics.customerReturnRate');

    // Route cho khách hàng tiềm năng
    Route::get('/statistics/frequent-customers', [StatisticsController::class, 'frequentCustomers'])->name('statistics.frequentCustomers');

    // Route cho thống kê thanh toán
    Route::get('/statistics/successful-payment-rate', [StatisticsController::class, 'successfulPaymentRate'])->name('statistics.successfulPaymentRate');

    // Route cho phân tích phương thức thanh toán
    Route::get('/statistics/payment-methods', [StatisticsController::class, 'paymentMethodStatistics'])->name('statistics.paymentMethods');
});
