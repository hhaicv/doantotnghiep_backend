<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateDriverRequest;
use App\Models\PaymentMethod;
use App\Models\TicketBooking;
use App\Models\TicketDetail;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Bus;
use App\Models\Stop;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class HomeDriverController extends Controller
{

    const PATH_UPLOAD = 'drivers';

    // public function index(Request $request)
    // {
    //     $driverId = auth('driver')->id();

    //     $date = $request->input('date', Carbon::now()->toDateString());

    //     $trips = TicketBooking::with(['bus', 'route', 'ticketDetails'])
    //         ->whereHas('bus', function ($query) use ($driverId) {
    //             $query->where('driver_id', $driverId);
    //         })
    //         ->where('date', $date)
    //         ->get()
    //         ->groupBy(function ($trip) {
    //             return $trip->route->route_name . '_' . $trip->time_start;
    //         });

    //     $groupedTrips = $trips->map(function ($group) {
    //         return [
    //             'route_name' => $group->first()->route->route_name,
    //             'time_start' => $group->first()->time_start,
    //             'total_tickets' => $group->sum(fn($trip) => $trip->ticketDetails->count()),
    //             'total_price' => $group->sum(fn($trip) => $trip->ticketDetails->sum('price')),
    //             'details' => $group,
    //             'tickets' => $group->flatMap(fn($trip) => $trip->ticketDetails),

    //         ];
    //     });

    //     return view('driver.drivers.index', compact('groupedTrips', 'date'));
    // }
    public function showTicket(Request $request)
    {
        $driverId = auth('driver')->id();

        $date = $request->input('date', Carbon::now()->toDateString());

        $trips = TicketBooking::with(['bus', 'route', 'ticketDetails', 'bus.driver'])
            ->whereHas('bus', function ($query) use ($driverId) {
                $query->where('driver_id', $driverId);
            })
            ->where('status', 'paid')
            ->where('date', $date)
            ->get()
            ->groupBy(function ($trip) {
                return $trip->route->route_name . '_' . $trip->time_start;
            });

        $groupedTrips = $trips->map(function ($group) {
            return [
                'route_name' => $group->first()->route->route_name,
                'time_start' => $group->first()->time_start,
                'total_tickets' => $group->sum(fn($trip) => $trip->ticketDetails->count()),
                'total_price' => $group->sum(fn($trip) => $trip->ticketDetails->sum('price')),
                'details' => $group,
                'tickets' => $group->flatMap(fn($trip) => $trip->ticketDetails),
                'driver_name' => $group->first()->bus->driver->name ?? 'N/A',
                'bus_license_plate' => $group->first()->bus->license_plate ?? 'N/A',
            ];
        });

        //         dd($groupedTrips);

        return view('driver.drivers.show', compact('groupedTrips', 'date'));
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


    public function showDashboard(Request $request)
    {
        $driverId = auth('driver')->id();

        // Lấy danh sách vé của tài xế và phân trang
        $tickets = TicketBooking::with(['bus.driver', 'route', 'ticketDetails'])
            ->whereHas('bus.driver', function ($query) use ($driverId) {
                $query->where('id', $driverId);
            })
            ->where('status', 'paid')
            ->orderByDesc('date')
            ->paginate(10); // Hiển thị 10 bản ghi mỗi trang
        //        dd($tickets);

        // Nhóm vé theo ngày
        $tripStatsByDate = $tickets->groupBy('date')->map(function ($group) {
            return $group->groupBy(function ($trip) {
                return $trip->route->route_name . '_' . $trip->time_start;
            })->map(function ($subGroup) {
                return [
                    'bus_name' => $subGroup->first()->bus->name_bus ?? 'Không rõ tên xe',
                    'route' => $subGroup->first()->route->route_name ?? 'Không xác định',
                    'total_seats' => $subGroup->first()->bus->total_seats,
                    'soldSeats' => $subGroup->sum(fn($trip) => $trip->ticketDetails->count()),
                    'fillRate' => round($subGroup->sum(fn($trip) => $trip->ticketDetails->count()) / $subGroup->first()->bus->total_seats * 100, 2),
                    'totalRevenue' => $subGroup->sum(fn($trip) => $trip->total_price),
                ];
            });
        });

        // Tính tổng số chuyến và doanh thu
        $totalTrips = $tickets->total(); // Lấy tổng số bản ghi trong phân trang
        $totalRevenue = $tickets->sum('total_price'); // Tổng doanh thu của tất cả vé

        return view('driver.dashboard', compact('tripStatsByDate', 'tickets', 'totalTrips', 'totalRevenue'));
    }



    public function showSeats(Request $request)
    {
        $driverId = Auth::guard('driver')->id();
        $date = $request->query('date', Carbon::today()->toDateString());

        $methods = PaymentMethod::query()->get();

        // Lấy danh sách chuyến đi theo tài xế và ngày, kèm trạng thái ghế
        $trips = Trip::with([
            'bus',
            'route',
            'ticketBookings.ticketDetails' => function ($query) use ($date) {
                $query->whereHas('ticketBooking', function ($q) use ($date) {
                    $q->where('date', $date);
                });
            }
        ])
            ->whereHas('bus', function ($query) use ($driverId) {
                $query->where('driver_id', $driverId);
            })
            ->whereHas('ticketBookings', function ($query) use ($date) {
                $query->where('date', $date)->where('status', 'paid');
            })
            ->get();



        // Tạo mảng trạng thái ghế và thông tin người đặt
        $prices = []; // Biến ngoài scope để lưu tất cả giá trị price

        $seatStatusFlat = $trips->flatMap(function ($trip) use (&$prices) { // Sử dụng biến ngoài scope
            return $trip->ticketBookings->flatMap(function ($booking) use (&$prices) {
                return $booking->ticketDetails->mapWithKeys(function ($seat) use (&$prices) {
                    // Lưu giá trị price vào mảng $prices
                    $prices[] = $seat->price;

                    return [
                        $seat->name_seat => [
                            'id' => $seat->id,
                            'status' => $seat->status,
                            'phone' => $seat->ticketBooking->phone,
                            'name' => $seat->ticketBooking->name,
                            'email' => $seat->ticketBooking->email,
                            'note' => $seat->ticketBooking->note,
                            'price' => $seat->price,
                            'is_active' => $seat->is_active,
                        ]
                    ];
                });
            });
        });


        // Tổng số ghế của tất cả các xe trong chuyến đi (nếu cần tổng)
        $totalSeatCount = $trips->sum(function ($trip) {
            return $trip->bus->total_seats;
        });

        // Hoặc số ghế của từng xe trong mỗi chuyến đi
        $seatCounts = $trips->mapWithKeys(function ($trip) {
            return [$trip->id => $trip->bus->total_seats];
        });

        $show = TicketBooking::with(['bus', 'route', 'ticketDetails'])
            ->whereHas('bus', function ($query) use ($driverId) {
                $query->where('driver_id', $driverId);
            })
            ->where('status', 'paid')
            ->where('date', $date)
            ->get()
            ->groupBy(function ($trip) {
                return $trip->route->route_name . '_' . $trip->time_start;
            });

        $groupedTrips = $show->map(function ($group) {
            return [
                'route_name' => $group->first()->route->route_name,
                'time_start' => $group->first()->time_start,
                'date' => $group->first()->date,
                'total_tickets' => $group->sum(fn($show) => $show->ticketDetails->count()),
                'total_price' => $group->sum(fn($show) => $show->ticketDetails->sum('price')),
                'details' => $group,
                'tickets' => $group->flatMap(fn($show) => $show->ticketDetails),
                'bus_id' => $group->first()->bus_id,
                'route_id' => $group->first()->route_id,


            ];
        });
        $firstTripId = $show->first()?->pluck('trip_id')->first(); // This will return the first trip_id or null if no trips are found

        $stops = Stop::query()->get();


        return view('driver.drivers.showDetail', compact('trips', 'methods', 'date', 'totalSeatCount', 'seatCounts', 'seatStatusFlat', 'groupedTrips', 'stops', 'firstTripId'));
    }
    public function updateSeatActiveStatus($seatId, Request $request)
    {
        $seat = TicketDetail::findOrFail($seatId); // Lấy thông tin ghế dựa trên ID
        $seat->is_active = $request->input('is_active'); // Cập nhật trạng thái is_active
        $seat->save(); // Lưu vào cơ sở dữ liệu

        return response()->json(['message' => 'Trạng thái ghế đã được cập nhật']);
    }
    public function bookSeat(Request $request, $seatName)
    {
        $seat = TicketDetail::where('name_seat', $seatName)->first();

        if (!$seat) {
            return response()->json(['success' => false, 'message' => 'Ghế không tồn tại.'], 404);
        }

        // Cập nhật trạng thái ghế
        $seat->status = 'booked';
        $seat->is_active = 1; // Đặt ghế ở trạng thái đang hoạt động
        $seat->save();

        return response()->json(['success' => true, 'message' => 'Ghế đã được đặt.']);
    }


    public function listPrice(Request $request)
    {
        $data = $request->validate([
            'start_stop_id' => 'required|integer',
            'end_stop_id' => 'required|integer',
            'trip_id' => 'required|integer', // Thêm trip_id vào yêu cầu
        ]);

        $startRouteId = $data['start_stop_id'];
        $endRouteId = $data['end_stop_id'];
        $tripId = $data['trip_id']; // Lấy trip_id

        // Lấy chuyến cụ thể theo trip_id và start_stop_id, end_stop_id
        $trip = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
            $query->where('start_stop_id', $startRouteId)
                ->where('end_stop_id', $endRouteId);
        }])->where('id', $tripId) // Lọc theo trip_id
            ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
                $query->where('start_stop_id', $startRouteId)
                    ->where('end_stop_id', $endRouteId);
            })
            ->first();

        if (!$trip) {
            return response()->json(['message' => 'Chuyến xe không tồn tại hoặc không hợp lệ.'], 404);
        }

        // Lấy giai đoạn của chuyến xe
        $stage = $trip->stages->first();
        $fare = $stage ? $stage->fare : null; // Lấy giá vé từ giai đoạn nếu có

        return response()->json([
            'fare' => $fare,
        ]);
    }


    public function submit(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = strtoupper(Str::random(8));
            $ticketBookingData['name'] =  $request->input('hoten');
            $ticketBookingData['phone'] =  $request->input('sdt');
            $ticketBookingData['order_code'] = $orderCode;
            $ticketBookingData['total_tickets'] = $totalTickets;

            // Thiết lập status của TicketBooking dựa trên payment_method_id
            $ticketBookingData['status'] = $request->input('payment_method_id') == 1
                ? TicketBooking::PAYMENT_STATUS_PAID
                : TicketBooking::PAYMENT_STATUS_UNPAID;

            $ticketBooking = TicketBooking::create($ticketBookingData);

            foreach ($seatNames as $seatName) {
                $ticketCode = $totalTickets == 1 ? $orderCode : strtoupper(Str::random(8));

                TicketDetail::create([
                    'ticket_code' => $ticketCode,
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'booked'
                ]);
            }
            return redirect()->back()->with('success', 'Bạn tạo vé thành công');

        });
    }
}
