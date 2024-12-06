<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Contact;
use App\Models\Information;
use App\Models\Review;
use App\Models\Route;
use App\Models\Stop;
use App\Models\Trip;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\TicketBooking;
use App\Models\TicketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomeEmployeeController extends Controller
{
    
    public function contacts()
    {
        $data = Contact::all();
        return view('employee.contacts.index', compact('data'));
    }
    public function reviews()
    {
        $data = Review::all();
        return view('employee.reviews.index', compact('data'));
    }
    public function information()
    {
        $data = Information::all();
        return view('employee.information.index', compact('data'));
    }
    public function routes()
    {
        $stops = Stop::all(); // Lấy tất cả các điểm dừng
        $data = Route::with(['stages.startStop', 'stages.endStop'])->get()->map(function ($route) {
            // Gộp start_stop_id và end_stop_id vào một mảng duy nhất cho mỗi route
            $stopIds = $route->stages->flatMap(function ($stage) {
                return [$stage->start_stop_id, $stage->end_stop_id];
            })
                ->unique() // Loại bỏ các ID trùng lặp
                ->sort() // Sắp xếp theo thứ tự tăng dần
                ->values(); // Đặt lại các key để đảm bảo tuần tự

            // Gán mảng đã xử lý vào thuộc tính stages của route để truyền vào view
            $route->stages = $stopIds;

            return $route;
        });
        return view('employee.routes.index', compact('data', 'stops'));
    }
    public function stops()
    {
        $data = Stop::whereNull('parent_id')->with('children')->get();
        return view('employee.stops.index', compact('data'));
    }
    public function buses()
    {
        $data = Bus::all();
        return view('employee.buses.index', compact('data'));
    }
    public function trips()
    {
        $data = Trip::with(['route', 'bus'])->get();
        return view('employee.trips.index', compact('data'));
    }

    public function tickets()
    {

        $data = Stop::query()->get();
        return view('employee.tickets.index', compact('data'));

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

        $startStopName = Stop::where('id', $startRouteId)->value('stop_name');
        $endStopName = Stop::where('id', $endRouteId)->value('stop_name');

        $trips = Trip::with(['bus', 'route', 'stages' => function ($query) use ($startRouteId, $endRouteId) {
            $query->where('start_stop_id', $startRouteId)
                ->where('end_stop_id', $endRouteId);
        }])
            ->whereHas('stages', function ($query) use ($startRouteId, $endRouteId) {
                $query->where('start_stop_id', $startRouteId)
                    ->where('end_stop_id', $endRouteId);
            })
            ->when($date === $today, function ($query) use ($currentTime) {
                return $query->where('time_start', '>', $currentTime);
            })
            ->orderBy('time_start', 'asc')
            ->get();

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
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');
        $methods = PaymentMethod::query()->get();
        $data = Stop::query()->get();
        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);

        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }

        return view('employee.tickets.create', compact('data', 'methods', 'trip', 'seatsStatus'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $userData = $request->only('name', 'phone', 'email');
            $user = User::create($userData);

            $ticketBookingData = $request->except('name', 'phone', 'email', 'name_seat', 'fare');
            $ticketBookingData['user_id'] = $user->id;

            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);
            $ticketBookingData['total_tickets'] = $totalTickets;
            $ticketBooking = TicketBooking::create($ticketBookingData);

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
}
