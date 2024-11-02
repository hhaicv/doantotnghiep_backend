<?php

namespace App\Http\Controllers;

use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\UpdateTicketBookingRequest;

use App\Models\PaymentMethod;

use App\Models\Stop;
use App\Models\TicketDetail;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketBookingController extends Controller
{
    const PATH_VIEW = "admin.tickets.";
    public function index()
    {

        $data = Stop::query()->get();


        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function uploadTicket(Request $request)
    {
        $data = $request->validate([
            'start_stop_id' => 'required|integer',
            'end_stop_id' => 'required|integer',
            'date' => 'required|date'
        ]);

        $startRouteId = $data['start_stop_id'];
        $endRouteId = $data['end_stop_id'];
        $date = $data['date'];
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();


        // Lấy tên điểm bắt đầu và điểm kết thúc theo `id`
        $startStopName = Stop::where('id', $startRouteId)->value('stop_name');
        $endStopName = Stop::where('id', $endRouteId)->value('stop_name');

        // Lấy tất cả các chuyến có giai đoạn phù hợp
        $trips = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
            $query->where('start_stop_id', $startRouteId)
                ->where('end_stop_id', $endRouteId);
        }])
            ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
                $query->where('start_stop_id', $startRouteId)
                    ->where('end_stop_id', $endRouteId);
            })
            ->when($date === $today, function ($query) use ($currentTime) {
                // Nếu là ngày hôm nay, chỉ lấy các chuyến có time_start lớn hơn giờ hiện tại
                return $query->where('time_start', '>', $currentTime);
            })
            ->orderBy('time_start', 'asc') // Sắp xếp theo time_start từ bé đến lớn
            ->get();

        // Map dữ liệu chuyến
        $tripData = $trips->map(function ($trip) use ($startStopName, $endStopName, $date, $startRouteId, $endRouteId) {
            $stage = $trip->stages->first();

            return [
                'bus_id' => $trip->bus->id,
                'route_id' => $trip->route->id,
                'trip_id' => $trip->id,
                'time_start' => $trip->time_start,
                'route_name' => $trip->route->route_name,
                'fare' => $stage ? $stage->fare : null,
                'name_bus' => $trip->bus->name_bus,
                'total_seats' => $trip->bus->total_seats,
                'date' => $date,
                'start_stop_name' => $startStopName, // Tên điểm bắt đầu
                'end_stop_name' => $endStopName,     // Tên điểm kết thúc
                'start_stop_id' => $startRouteId,
                'end_stop_id' => $endRouteId,
            ];
        });

        if ($tripData->isEmpty()) {
            return response()->json(['message' => 'Không có chuyến nào.'], 404);
        }

        return response()->json($tripData);
    }



    public function create()
    {
        $methods = PaymentMethod::query()->get();
        $data = Stop::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data', 'methods'));
    }

    public function store(StoreTicketBookingRequest $request)
    {

        DB::transaction(function () use ($request) {
            // 1. Thêm thông tin người dùng vào bảng users
            $userData = $request->only('name', 'phone', 'email');
            $user = User::create($userData); // Tạo bản ghi user mới và lấy ID

            // 2. Chuẩn bị và thêm thông tin vào bảng ticket_bookings
            $ticketBookingData = $request->except('name', 'phone', 'email', 'name_seat', 'fare'); // Trừ name_seat và fare
            $ticketBookingData['user_id'] = $user->id; // Gắn ID user vừa tạo
            $ticketBooking = TicketBooking::create($ticketBookingData); // Tạo bản ghi ticket_booking mới và lấy ID

            // 3. Thêm từng ghế vào bảng ticket_detail
            $seatNames = explode(', ', $request->input('name_seat')); // Giả sử ghế được nhập cách nhau bằng dấu phẩy

            foreach ($seatNames as $seatName) {
                TicketDetail::create([
                    'ticket_code' => strtoupper(Str::random(8)), // Mã vé ngẫu nhiên 8 ký tự
                    'ticket_booking_id' => $ticketBooking->id, // ID của vé từ ticket_bookings
                    'name_seat' => $seatName,
                    'price' => $request->input('fare')
                ]);
            }
        });

        return view(self::PATH_VIEW . __FUNCTION__);
    }




    public function show(TicketBooking $ticketBooking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketBooking $ticketBooking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketBookingRequest $request, TicketBooking $ticketBooking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketBooking $ticketBooking)
    {
        //
    }
}
