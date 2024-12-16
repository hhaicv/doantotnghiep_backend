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
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\VNPayController;
use App\Http\Controllers\API\PromotionController;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Route để lấy thông tin người dùng đã đăng nhập
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Route để đăng xuất
    Route::post('logout', [AuthController::class, 'logout']);

    // Route để cập nhật thông tin tài khoản
    Route::put('account/update', [AuthController::class, 'updateAccount']);

    // Route gửi OTP cho người dùng
    Route::post('request-password-reset', [AuthController::class, 'requestPasswordReset']);  // Gửi OTP yêu cầu thay đổi mật khẩu
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});


// Thêm các route API cho các tài nguyên khác
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



Route::apiResource('promotions', PromotionController::class);
Route::get('promotions/category/{categoryId}', [PromotionController::class, 'getByCategory']);
Route::post('request-password-reset', [AuthController::class, 'requestPasswordReset']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('/apply-voucher', [App\Http\Controllers\API\PromotionController::class, 'applyVoucher']);


Route::get('promotions/{id}', [PromotionController::class, 'show']);


// Đổi chuyến
Route::get('/change/{id}', [StopController::class, 'change'])->name('change');
Route::get('/load', [StopController::class, 'load'])->name('load');

// tuyến nổi bật
Route::get('/popular', [RouteController::class, 'popular'])->name('popular');

Route::post('/update-seat-status', function (Illuminate\Http\Request $request) {
    $seatName = $request->input('name');
    $seatStatus = $request->input('status');
    $tripId = $request->input('trip_id');
    $userId = $request->input('userId'); // Lấy user_id từ yêu cầu


    // Xử lý cập nhật trạng thái ghế
    $seat = [
        'name' => $seatName,
        'status' => $seatStatus,
        'trip_id' => $tripId,
        'userId' => $userId,

    ];

    // Phát sự kiện
    event(new App\Events\SeatUpdatedEvent($seat));

    return response()->json(['success' => true, 'seat' => $seat]);
});




