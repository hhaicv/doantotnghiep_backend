<?php

namespace App\Listeners;

use App\Events\OrderTicket;
use App\Models\Stop;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderTicket $event): void
    {
        $ticketBooking = $event->ticket;
        $startStop = Stop::find($ticketBooking->id_start_stop);
        $endStop = Stop::find($ticketBooking->id_end_stop);

        $driver = $ticketBooking->bus->driver;
        $data = [
            'name' => $ticketBooking->name,
            'phone' => $ticketBooking->phone,
            'email' => $ticketBooking->email,
            'driver_name' => $driver->name ?? null,
            'driver_phone' => $driver->phone ?? null,
            'license_plate' => $ticketBooking->bus->license_plate,
            'route_name' => $ticketBooking->route->route_name,
            'start_point' => $startStop->stop_name ?? $ticketBooking->location_start,
            'end_point' => $endStop->stop_name ?? $ticketBooking->location_end,
            'time_start' => $ticketBooking->trip->time_start ?? null,
            'point_up' => $ticketBooking->location_start,
            'point_down' => $ticketBooking->location_end,
            'date_start' => $ticketBooking->date,
            'payment_method' => $ticketBooking->paymentMethod->name,
            'booking_date' => $ticketBooking->created_at->format('Y-m-d'),
            'name_seat' => $ticketBooking->ticketDetails->pluck('name_seat')->toArray(),
            'note' => $ticketBooking->note,
            'ticket_price' => $ticketBooking->total_price,
            'total_price' => $ticketBooking->total_price,
            'status' => $ticketBooking->status,
            'order_code' => $ticketBooking->order_code,
            'ticket_codes' => $ticketBooking->ticketDetails->pluck('ticket_code')->toArray(),
        ];
        try {
            Mail::send('mail', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                    ->subject('Thông tin đơn hàng');
            });

            // Log khi gửi email thành công
            Log::info("Email đã được gửi đến: {$data['email']}.");
        } catch (\Exception $e) {
            // Log lỗi khi gửi email thất bại
            Log::error("Lỗi khi gửi email: " . $e->getMessage());
        }
    }
}
