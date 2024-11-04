<?php

namespace App\Http\Controllers\API;

use App\Models\TicketBooking;
use App\Http\Requests\StoreTicketBookingRequest;
use App\Http\Requests\UpdateTicketBookingRequest;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\TicketDetail;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $trip_id = $request->query('trip_id');
        $date = $request->query('date');

        // Get all available payment methods
        $methods = PaymentMethod::query()->get();

        // Retrieve the trip and its bus information
        $trip = Trip::with(['bus', 'route'])->findOrFail($trip_id);
        $seatCount = $trip->bus->total_seats;

        // Get booked seats for the specified trip and date
        $seatsBooked = TicketDetail::whereHas('ticketBooking', function ($query) use ($date, $trip_id) {
            $query->where('date', $date)
                ->where('trip_id', $trip_id);
        })->get();

        // Build seats status array
        $seatsStatus = [];
        foreach ($seatsBooked as $seat) {
            $seatsStatus[$seat->name_seat] = $seat->status;
        }

        // Prepare data for JSON response
        return response()->json([
            'methods' => $methods,
            'seatsStatus' => $seatsStatus,
            'seatCount' => $seatCount,
        ]);
    }

    public function store(StoreTicketBookingRequest $request)
    {
        $response = DB::transaction(function () use ($request) {
            // Extract user data and create a new user record
            $userData = $request->only('name', 'phone', 'email');
            $user = User::create($userData);

            // Prepare ticket booking data, excluding certain fields
            $ticketBookingData = $request->except('name', 'phone', 'email', 'name_seat', 'fare');
            $ticketBookingData['user_id'] = $user->id;

            // Split seat names by comma and calculate total number of seats
            $seatNames = explode(', ', $request->input('name_seat'));
            $totalTickets = count($seatNames);
            $ticketBookingData['total_tickets'] = $totalTickets;

            // Create ticket booking record
            $ticketBooking = TicketBooking::create($ticketBookingData);

            // Create ticket details for each seat
            $ticketDetails = [];
            foreach ($seatNames as $seatName) {
                $ticketDetails[] = TicketDetail::create([
                    'ticket_code' => strtoupper(Str::random(8)),
                    'ticket_booking_id' => $ticketBooking->id,
                    'name_seat' => $seatName,
                    'price' => $request->input('fare'),
                    'status' => 'booked'
                ]);
            }

            // Return a structured response with created data
            return [
                'user' => $user,
                'ticket_booking' => $ticketBooking,
                'ticket_details' => $ticketDetails,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $response
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
