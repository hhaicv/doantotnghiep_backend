<?php

namespace App\Http\Controllers;

use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\UpdateTicketBookingRequest;
use App\Models\Stage;
use App\Models\Stop;
use App\Models\Trip;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Ticket;
use Carbon\Carbon;

class TicketBookingController extends Controller
{
    const PATH_VIEW = "admin.tickets.";
    public function index()
    {

        $data = Stop::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }


    public function create()
    {
        $data = Stop::query()->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'start_stop_id' => 'required|integer',
            'end_stop_id' => 'required|integer',
            'date' => 'required|date'
        ]);

        $startRouteId = $data['start_stop_id'];
        $endRouteId = $data['end_stop_id'];
        $date = $data['date'];

        // Lấy tất cả các chuyến có giai đoạn phù hợp
        $trips = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
            $query->where('start_stop_id', $startRouteId)
                ->where('end_stop_id', $endRouteId);
        }])
            ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
                $query->where('start_stop_id', $startRouteId)
                    ->where('end_stop_id', $endRouteId);
            })
            ->get();

        // Map dữ liệu chuyến
        $tripData = $trips->map(function ($trip) use ($startRouteId, $endRouteId, $date) {
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
                'start_stop_id' => $startRouteId,
                'end_stop_id' => $endRouteId,
            ];
        });

        if ($tripData->isEmpty()) {
            return response()->json(['message' => 'Không có chuyến nào.'], 404);
        }

        return response()->json($tripData);
    }

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'start_stop_id' => 'required|integer',
    //         'end_stop_id' => 'required|integer',
    //         'date' => 'required|date'
    //     ]);

    //     $startRouteId = $data['start_stop_id'];
    //     $endRouteId = $data['end_stop_id'];
    //     $date = $data['date'];
    //     $currentTime = now()->format('H:i');


    //     // Lấy tất cả các chuyến có giai đoạn phù hợp và thời gian khởi hành hợp lệ
    //     $trips = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
    //         $query->where('start_stop_id', $startRouteId)
    //             ->where('end_stop_id', $endRouteId);
    //     }])
    //         ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
    //             $query->where('start_stop_id', $startRouteId)
    //                 ->where('end_stop_id', $endRouteId);
    //         })
    //         // Thêm điều kiện thời gian khởi hành cho ngày hiện tại
    //         ->when($date == today()->toDateString(), function ($query) use ($currentTime) {
    //             $query->where('time_start', '>', $currentTime);
    //         })
    //         ->get();

    //     // Map dữ liệu chuyến
    //     $tripData = $trips->map(function ($trip) use ($startRouteId, $endRouteId, $date, $currentTime) {
    //         $stage = $trip->stages->first();

    //         return [
    //             'bus_id' => $trip->bus->id,
    //             'route_id' => $trip->route->id,
    //             'trip_id' => $trip->id,
    //             'time_start' => $trip->time_start,
    //             'route_name' => $trip->route->route_name,
    //             'fare' => $stage ? $stage->fare : null,
    //             'name_bus' => $trip->bus->name_bus,
    //             'total_seats' => $trip->bus->total_seats,
    //             'date' => $date,
    //             'start_stop_id' => $startRouteId,
    //             'end_stop_id' => $endRouteId,
    //             'currentTime'=>$currentTime,
    //         ];
    //     });

    //     if ($tripData->isEmpty()) {
    //         return response()->json(['message' => 'Không có chuyến nào.'], 404);
    //     }

    //     return response()->json($tripData);
    // }





    /**
     * Display the specified resource.
     */
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
