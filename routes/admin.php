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
// Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


// Route cho admin (sử dụng middleware để bảo vệ các route)
Route::middleware(['admin'])->prefix('admin')->as('admin.')->group(function () {
    // Route cho đăng xuất
    Route::post('logout', [AdminController::class, 'logout'])->name('logout');

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

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index'); // Danh sách tất cả người dùng
        Route::get('/employees', [UserController::class, 'employeeIndex'])->name('employees'); // Danh sách nhân viên
        Route::get('/customers', [UserController::class, 'userIndex'])->name('customers'); // Danh sách khách hàng
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit'); // Chỉnh sửa người dùng
        Route::put('/{id}', [UserController::class, 'update'])->name('update'); // Cập nhật người dùng
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy'); // Xóa người dùng
    });

    Route::get('/fetch-trips', [TicketBookingController::class, 'uploadTicket'])->name('fetch.trips');
});
