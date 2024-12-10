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

    public function index(Request $request)
    {
        $driverId = auth('driver')->id();

        // Lấy ngày từ request (hoặc mặc định là hôm nay)
        $date = $request->input('date', Carbon::now()->toDateString());

        // Lấy danh sách vé theo tài xế và ngày
        $trips = TicketBooking::with(['bus', 'route', 'ticketDetails'])
            ->whereHas('bus', function ($query) use ($driverId) {
                $query->where('driver_id', $driverId);
            })
            ->where('date', $date)
            ->get()
            ->groupBy(function ($trip) {
                // Nhóm theo tuyến đường, thời gian khởi hành, và ngày
                return $trip->route->route_name . '_' . $trip->time_start;
            });

        // Chuẩn bị dữ liệu gộp lại cho từng nhóm
        $groupedTrips = $trips->map(function ($group) {
            return [
                'route_name' => $group->first()->route->route_name,
                'time_start' => $group->first()->time_start,
                'total_tickets' => $group->sum(fn($trip) => $trip->ticketDetails->count()),
                'total_price' => $group->sum(fn($trip) => $trip->ticketDetails->sum('price')),
                'details' => $group, // Chi tiết từng chuyến trong nhóm
            ];
        });

        return view('driver.drivers.index', compact('groupedTrips', 'date'));
    }

    public function show($tripId)
    {
        $driverId = auth('driver')->id();

        // Lấy thông tin chuyến và tất cả vé thuộc chuyến đó
        $tickets = TicketBooking::with(['bus.driver', 'route', 'ticketDetails'])
            ->whereHas('bus', function ($query) use ($driverId) {
                $query->where('driver_id', $driverId);
            })
            ->where('trip_id', $tripId) // Lọc theo trip_id (mã chuyến)
            ->get();

        // Kiểm tra nếu không có vé nào
        if ($tickets->isEmpty()) {
            abort(404, 'Không tìm thấy chuyến này.');
        }

        // Lấy thông tin chung của chuyến
        $tripInfo = [
            'route_name' => $tickets->first()->route->route_name,
            'time_start' => $tickets->first()->time_start,
            'date' => $tickets->first()->date,
            'bus' => $tickets->first()->bus,
            'total_tickets' => $tickets->sum(fn($ticket) => $ticket->ticketDetails->count()),
            'total_price' => $tickets->sum(fn($ticket) => $ticket->ticketDetails->sum('price')),
        ];

        return view('driver.drivers.show', compact('tripInfo', 'tickets'));
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

        // Lấy danh sách vé của tài xế
        $tickets = TicketBooking::with(['bus.driver', 'route', 'ticketDetails'])
            ->whereHas('bus.driver', function ($query) use ($driverId) {
                $query->where('id', $driverId);
            })
            ->orderByDesc('date')
            ->get();

        // Nhóm vé theo bus_id
        $busStats = $tickets->groupBy('bus_id')->map(function ($group) {
            $bus = $group->first()->bus; // Lấy thông tin bus từ vé đầu tiên trong nhóm
            $route = $group->first()->route->route_name ?? 'Không xác định';
            $capacity = $bus->total_seats;

            // Tổng số vé bán
            $soldSeats = $group->reduce(function ($carry, $ticket) {
                return $carry + $ticket->ticketDetails->count();
            }, 0);

            // Tính tỷ lệ lấp đầy
            $fillRate = ($soldSeats / $capacity) * 100;

            return [
                'name_bus' => $bus->name_bus ?? 'Không rõ tên xe',
                'route' => $route,
                'total_seats' => $capacity,
                'soldSeats' => $soldSeats,
                'fillRate' => round($fillRate, 2),
                'totalRevenue' => $group->sum('total_price'),

            ];
        });

        // Tính tổng số chuyến và tổng doanh thu
        $totalTrips = $tickets->count();
        $totalRevenue = $tickets->sum('total_price');

        return view('driver.dashboard', compact('busStats', 'totalTrips', 'totalRevenue'));
    }
//    public function showDashboard(Request $request)
//    {
//        $trip_id = $request->query('trip_id');
//        $date = $request->query('date');
//
//
//
//        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
//        $seatCount = $trip->bus->total_seats;
//
//        // Lấy danh sách ghế bị "lock" quá 15 phút
//        TicketDetail::where('status', 'lock')
//            ->whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
//                $query->where('date', $date)
//                    ->where('trip_id', $trip_id);
//            })
//            ->where('updated_at', '<=', Carbon::now()->subMinutes(1))
//            ->delete();
//
//
//        // Lấy danh sách ghế đã đặt
//        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
//            $query->where('date', $date)
//                ->where('trip_id', $trip_id);
//        })->get();
//
//        $seatsStatus = [];
//        foreach ($seatsBooked as $seat) {
//            $seatsStatus[$seat->name_seat] = $seat->status;
//        }
//
//        return view('driver.dashboard', compact('seatsStatus', 'seatCount'));
//    }






}
