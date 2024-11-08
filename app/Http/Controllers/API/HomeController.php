<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Stop;
use App\Models\TicketDetail;
use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $data = Stop::query()->where('is_active', true)->get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
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

            // Đếm số ghế đã đặt
            $bookedSeatsCount = 0;

            if ($trip->ticketBookings) {
                // Đếm số ghế đã đặt dựa trên các ticket_booking_id
                $bookedSeatsCount = TicketDetail::whereIn('ticket_booking_id', $trip->ticketBookings->pluck('id'))
                    ->count();
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



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
