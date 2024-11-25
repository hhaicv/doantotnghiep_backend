<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PromotionCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $promotion;
    public function __construct($promotion)
    {
        $this->promotion = $promotion;
    }

    public function broadcastOn(): Channel
    {

           return new Channel('promotions');

    }
    public function broadcastWith(): array
    {
        return [
          'title' => $this->promotion->title,
          'description' => $this->promotion->description,
          'discount' => $this->promotion->discount,
            'code' => $this->promotion->code,
        ];
    }
}
