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

        // Lấy thông tin các điểm bắt đầu và kết thúc
        $startStop = Stop::find($ticketBooking->id_start_stop);
        $endStop = Stop::find($ticketBooking->id_end_stop);



        // Kiểm tra sự tồn tại của các điểm dừng
        $startLocation = $startStop ? $startStop->stop_name : 'N/A';
        $endLocation = $endStop ? $endStop->stop_name : 'N/A';

        $data = [
            'order_code' => $ticketBooking->order_code,
            'date' => $ticketBooking->date,
            'note' => $ticketBooking->note,
            'created_at' => $ticketBooking->created_at,
            'paymentMethod' => $ticketBooking->paymentMethod,
            'start_location' => $startLocation,
            'end_location' => $endLocation,
            'route' => $ticketBooking->route->route_name,
            'time_start' => $ticketBooking->time_start,
            'bus' => $ticketBooking->bus->license_plate ,
            'phone_bus' => $ticketBooking->bus->phone ,
            'code_ticket' => $ticketBooking->ticketDetails->ticket_code ,
            'email' => $ticketBooking->email,
            'name' => $ticketBooking->name,
            'phone' => $ticketBooking->phone,
            'seat' => $ticketBooking->ticketDetails->name_seat
        ];
        // Gửi email
        Mail::send('mail', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Thông tin đơn hàng');
        });
    }


}
