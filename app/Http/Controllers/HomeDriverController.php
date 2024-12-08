<?php
namespace App\Http\Controllers;

use App\Http\Requests\updateDriverRequest;
use App\Models\TicketBooking;
use App\Models\TicketDetail;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Bus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class HomeDriverController extends Controller{

    const PATH_UPLOAD = 'drivers';

    public function index()
    {
        $driverId = auth('driver')->id();

        $trips = TicketBooking::with(['bus', 'trip'])
            ->whereHas('bus', function ($query) use ($driverId) {
                $query->where('driver_id', $driverId);
            })
            ->orderByDesc('date')
            ->get();

        return view('driver.drivers.index', compact('trips'));
    }


    public function show($ticketId) {

        $driverId = auth('driver')->id();

        // Sử dụng get() thay vì findOrFail để trả về collection
        $tickets = TicketBooking::with(['bus.driver', 'route', 'ticketDetails'])
            ->whereHas('bus.driver', function ($query) use ($driverId) {
                $query->where('id', $driverId);
            })
            ->where('id', $ticketId) // Thêm điều kiện để tìm vé theo ID
            ->get(); // Trả về collection

        return view('driver.drivers.show', compact('tickets'));
    }
    public function edit($id)
    {
        $driver = Driver::findOrFail(auth('driver')->id());
        return view('driver.drivers.edit', compact('driver'));
    }


    public function update(UpdateDriverRequest $request)
    {
        $driver = Driver::findOrFail(auth('driver')->id());

        $model = $request->except('profile_image');

        // Định dạng ngày sinh
        if ($request->filled('date_of_birth')) {
            $model['date_of_birth'] = Carbon::createFromFormat('Y-m-d', $request->date_of_birth)->format('Y-m-d');
        }

        // Cập nhật mật khẩu nếu cần
        if ($request->filled('password')) {
            $model['password'] = Hash::make($request->password);
        }

        // Xử lý ảnh đại diện
        if ($request->hasFile('profile_image')) {
            $model['profile_image'] = Storage::put('drivers', $request->file('profile_image'));

            // Xóa ảnh cũ
            if ($driver->profile_image && Storage::exists($driver->profile_image)) {
                Storage::delete($driver->profile_image);
            }
        }

        $driver->update($model);

        return redirect()->route('drivers.edit', $driver->id)
            ->with('success', 'Thông tin tài khoản đã được cập nhật.');
    }


    public function showDashboard()
    {
        $driverId = auth('driver')->id();

        // Lấy tất cả các vé của tài xế
        $tickets = TicketBooking::with(['bus.driver', 'route', 'ticketDetails'])
            ->whereHas('bus.driver', function ($query) use ($driverId) {
                $query->where('id', $driverId);
            })
            ->get();

        // Tính tổng số chuyến đã đi
        $totalTrips = $tickets->count();

        // Tính tổng doanh thu (Giả sử bạn tính doanh thu từ các vé đã bán)
        $totalRevenue = $tickets->sum('total_price');

        return view('driver.dashboard', compact('tickets', 'totalTrips', 'totalRevenue'));
    }



}
