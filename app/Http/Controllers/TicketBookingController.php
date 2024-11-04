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



    public function create(Request $request)
    {

        // lấy chuyến theo ngày, lấy trạng th

        $trip_id = $request->query('trip_id');
        $date = $request->query('date');

        $methods = PaymentMethod::query()->get();



        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }
        return view(self::PATH_VIEW . 'create', compact( 'methods', 'seatsStatus', 'seatCount'));
    }


    public function store(StoreTicketBookingRequest $request)
    {

        DB::transaction(function () use ($request) {
            $userData = $request->only('name', 'phone', 'email');
            $user = User::create($userData); // Tạo bản ghi user mới và lấy ID

            $ticketBookingData = $request->except('name', 'phone', 'email', 'name_seat', 'fare'); // Trừ name_seat và fare
            $ticketBookingData['user_id'] = $user->id; // Gắn ID user vừa tạo

            // Lấy danh sách ghế và tính tổng số lượng ghế
            $seatNames = explode(', ', $request->input('name_seat')); // Ghế được nhập cách nhau bằng dấu phẩy
            $totalTickets = count($seatNames); // Tính tổng số ghế

            $ticketBookingData['total_tickets'] = $totalTickets; // Gắn tổng số ghế vào dữ liệu vé
            $ticketBooking = TicketBooking::create($ticketBookingData); // Tạo bản ghi ticket_booking mới và lấy ID

            foreach ($seatNames as $seatName) {
                TicketDetail::create([
                    'ticket_code' => strtoupper(Str::random(8)),
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'booked'
                ]);
            }
        });
    }


    public function list()
    {
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
