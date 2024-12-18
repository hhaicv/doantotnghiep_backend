<?php

use App\Events\SeatUpdatedEvent;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CancleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewCategoryController;
use App\Http\Controllers\PromotionCategoryController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TicketBookingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [LoginAdminController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginAdminController::class, 'adminLogin'])->name('admin.login.submit');

// Route cho admin (sử dụng middleware để bảo vệ các route)
Route::middleware(['admin'])->prefix('admin')->as('admin.')->group(function () {
    // Route cho đăng xuất
    Route::post('logout', [LoginAdminController::class, 'logout'])->name('logout');

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'totalPrice'])->name('dashboard');


    Route::resource('contacts', ContactController::class);
    Route::post('/status-contacts/{id}', [ContactController::class, 'statusContact']);

    Route::resource('roles', RoleController::class);
    Route::post('/status-roles/{id}', [RoleController::class, 'statusRole']);

    Route::resource('buses', BusController::class);
    Route::post('/status-buses/{id}', [BusController::class, 'statusBuses']);

    Route::resource('drivers', DriverController::class);
    Route::post('/status-drivers/{id}', [DriverController::class, 'statusDriver']);

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
    Route::resource('promotion_categories', PromotionCategoryController::class);
    Route::post('/status-promotion-categories/{id}', [PromotionCategoryController::class, 'statusPromotionCategory']);



    Route::resource('trips', TripController::class);
    Route::post('/status-trip/{id}', [TripController::class, 'statusTrip']);

    Route::resource('tickets', TicketBookingController::class);
    Route::get('/list', [TicketBookingController::class, 'list'])->name('ticket_list');

    Route::resource('cancel', CancleController::class);



    Route::resource('reviews', ReviewController::class);
    Route::get('/send-notification', [PromotionController::class, 'sendPromotionNotification']);



    Route::get('/fetch-trips', [TicketBookingController::class, 'store'])->name('fetch.trips');


    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index'); // Danh sách tất cả người dùng
        Route::get('/employees', [UserController::class, 'employeeIndex'])->name('employees'); // Danh sách nhân viên
        Route::get('/customers', [UserController::class, 'userIndex'])->name('customers'); // Danh sách khách hàng
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::post('/status-users/{id}', [UserController::class, 'statusUser']);


    Route::get('/statistics-trip', [StatisticsController::class, 'tripStatistical'])->name('statistics.tripStatistical');

    Route::resource('admins', App\Http\Controllers\AdminController::class);
    Route::post('/status-admins/{id}', [App\Http\Controllers\AdminController::class, 'statusAdmin']);


    Route::get('/fetch-trips', [TicketBookingController::class, 'uploadTicket'])->name('fetch.trips');
    Route::get('/thanks', [TicketBookingController::class, 'thanks'])->name('thanks');
    Route::get('/momo_return', [TicketBookingController::class, 'momo_return'])->name('momo_return');
    Route::get('/vnpay_return', [TicketBookingController::class, 'vnpay_return'])->name('vnpay_return');
    Route::get('/qr_code_return', [TicketBookingController::class, 'qr_code_return'])->name('qr_code_return');

    Route::get('/change/{id}', [TicketBookingController::class, 'change'])->name('change');
    Route::get('/load', [TicketBookingController::class, 'load'])->name('load');


    Route::post('/apply-voucher', [PromotionController::class, 'applyVoucher'])->name('apply.voucher');


    // readtime ghế


    // Route::post('/seat/update-status', [TicketBookingController::class, 'updateStatus']);

    // Route::get('/', function () {
    //     // Render the realtime seat management page
    //     return view('realtime_seat');
    // });

    Route::post('/update-seat-status', function (Illuminate\Http\Request $request) {
        $seatName = $request->input('name');
        $seatStatus = $request->input('status');
        $tripId = $request->input('trip_id');
        $userId = $request->input('userId'); // Lấy user_id từ yêu cầu
        $date = $request->input('date'); // Lấy user_id từ yêu cầu

        // Xử lý cập nhật trạng thái ghế
        $seat = [
            'name' => $seatName,
            'status' => $seatStatus,
            'trip_id' => $tripId,
            'userId' => $userId,
            'date' => $date,
        ];

        // Phát sự kiện
        event(new App\Events\SeatUpdatedEvent($seat));

        return response()->json(['success' => true, 'seat' => $seat]);
    });



    // Route::post('/cancel/{id}', [TicketBookingController::class, 'cancel'])->name('cancel');

    // Route::post('/cancel-ticket', [TicketBookingController::class, 'requestCancelTicket']);
    Route::get('/test-email', function () {
        // Dữ liệu gửi email
        $data = [
            'name' => 'Nguyễn Văn A',
            'email' => 'example@example.com',  // Thay bằng email thực tế bạn muốn gửi đến
            'order_code' => 'ABC123',
            'reason' => 'Lý do hủy vé',
            'phone' => '0123456789',
            'account_number' => '123456789',
            'bank' => 'Ngân hàng XYZ'
        ];

        try {
            // Gửi email với template 'cancel'
            Mail::send('cancel', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                        ->subject('Thông báo Hủy Đơn Hàng Thành Công');
            });

            return "Email đã được gửi thành công!";
        } catch (\Exception $e) {
            return "Lỗi khi gửi email: " . $e->getMessage();
        }
    });


});
