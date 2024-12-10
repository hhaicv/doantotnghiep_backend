<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SeatSelected implements ShouldBroadcast
{
    use SerializesModels;

    public $seatId;

    public function __construct($seatId)
    {
        $this->seatId = $seatId;
    }

    public function broadcastOn()
    {
        return ['seat-channel'];
    }
}

