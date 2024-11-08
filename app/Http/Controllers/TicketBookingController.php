<?php

namespace App\Http\Controllers;

use App\Events\OrderTicket;
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
            $bookedSeatsCount = 0;

            if ($trip->ticketBookings) {
                // Đếm số ghế đã đặt theo chuyến và ngày
                $bookedSeatsCount = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip) {
                    $query->where('trip_id', $trip->id)
                        ->where('date', $date);
                })->count();
            }

            return [
                'bus_id' => $trip->bus->id,
                'route_id' => $trip->route->id,
                'trip_id' => $trip->id,
                'time_start' => $trip->time_start,
                'route_name' => $trip->route->route_name,
                'fare' => $stage ? $stage->fare : null,
                'name_bus' => $trip->bus->name_bus,
                'total_seats' => $trip->bus->total_seats,
                'booked_seats_count' => $bookedSeatsCount, // Số ghế đã đặt
                'available_seats' => $trip->bus->total_seats - $bookedSeatsCount, // Số ghế còn trống
                'date' => $date,
                'start_stop_name' => $startStopName,
                'end_stop_name' => $endStopName,
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
        return view(self::PATH_VIEW . 'create', compact('methods', 'seatsStatus', 'seatCount'));
    }

    public function store(StoreTicketBookingRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $ticketBookingData = $request->except('name_seat', 'fare');
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);

            $orderCode = strtoupper(Str::random(8));
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

            event(new OrderTicket($ticketBooking));
            return redirect()->back()->with('success', 'Đặt vé thành công!');
        });
    }




    public function list()
    {
        $data = TicketBooking::with(['route', 'paymentMethod', 'trip'])->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    public function show(string $id)
    {
        $data = TicketBooking::query()
            ->with(['trip', 'bus', 'route', 'user', 'paymentMethod'])
            ->findOrFail($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketBooking $ticketBooking)
    {
        $data = TicketBooking::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
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
