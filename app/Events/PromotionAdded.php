<?php

namespace App\Events;

use App\Models\Promotion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PromotionAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $promotion;

    /**
     * Create a new event instance.
     */
    public function __construct(Promotion $promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new Channel('promotions');  // Đảm bảo tên kênh là 'promotions'
    }

    /**
     * Specify broadcast data
     */
    public function broadcastWith()
    {
        return [
            'title' => $this->promotion->title,
            'code' => $this->promotion->code,
            'discount' => $this->promotion->discount,
        ];
    }
}
