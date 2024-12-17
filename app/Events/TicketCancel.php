<?php

namespace App\Events;

use App\Models\Cancle;
use App\Models\TicketBooking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class TicketCancel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $cancel;

    public function __construct(Cancle $cancel)
    {
        $cancel = $this->cancel = $cancel;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
    public function cancelOrder(Request $request)
{
    // Lưu yêu cầu hủy đơn hàng vào bảng cancels
    $cancel = Cancle::create([
        'name' => $request->name,
        'email' => $request->email,
        'order_code' => $request->order_code,
        'reason' => $request->reason,
        'phone' => $request->phone,
        'account_number' => $request->account_number,
        'bank' => $request->bank,
    ]);

    // Gọi Event để gửi mail xác nhận
    event(new TicketCancel($cancel));

    return response()->json(['message' => 'Yêu cầu hủy đơn hàng đã được gửi và email thông báo sẽ được gửi tới bạn.']);
}
}
