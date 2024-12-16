<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SeatUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $seat;

    public function __construct($seat)
    {
        $this->seat = $seat;
    }

    public function broadcastOn()
    {
        return new Channel('seat-channel'); // Tên kênh
    }

    public function broadcastWith()
    {
        return [
            'seat' => $this->seat, // Dữ liệu ghế được gửi
        ];
    }
}
