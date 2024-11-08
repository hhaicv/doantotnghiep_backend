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

        $data = [
            'order_code' => $ticketBooking->order_code,
            'date' => $ticketBooking->date,
            'note' => $ticketBooking->note,

            'created_at' => $ticketBooking->created_at,
            'paymentMethod' => $ticketBooking->paymentMethod,
            'start_location' => $startStop->name ?? 'N/A',
            'end_location' => $endStop->name ?? 'N/A',
            'route' => $ticketBooking->route->name ?? 'N/A',
            'time_start' => $ticketBooking->time_start,
            'bus' => $ticketBooking->bus->license_plate ?? 'N/A',
            'ticket_details' => $ticketBooking->ticketDetails,
        ];

        Mail::send('mail', $data, function ($message) use ($data) {
            $message->to($data['ticketBooking']->email, $data['ticketBooking']->name)
                    ->subject('Thông tin đơn hàng');
        });
    }

}
