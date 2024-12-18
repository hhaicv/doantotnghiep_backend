<?php

namespace App\Listeners;

use App\Events\TicketCancel;



use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

<<<<<<< HEAD
class SendCancelConfirmation 
=======
class SendCancelConfirmation

>>>>>>> 129dcd65bf63265b69e7512772929ddd0ca9f660
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
    public function handle(TicketCancel $event): void
{
    $cancel = $event->cancel;

        // Lấy thông tin cần thiết từ ticket
        $data = [
            'name' => $cancel->name,
            'email' => $cancel->email,
            'order_code' => $cancel->order_code,
            'reason' => $cancel->reason,
            'phone' => $cancel->phone,
            'account_number' => $cancel->account_number,
            'bank' => $cancel->bank,
        ];
        Log::info("Chạy vào đây rồi nhé hihihihihihihhiihhi.");

    try {
        Log::info("Bắt đầu gửi email cho {$data['email']}.");

        // Gửi email
        Mail::send('cancel', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                    ->subject('Thông báo Hủy Đơn Hàng Thành Công');
        });

        Log::info("Email đã gửi thành công cho {$data['email']}."); // Log khi gửi thành công
    } catch (\Exception $e) {
        Log::error("Lỗi khi gửi email cho {$data['email']}: " . $e->getMessage(), [
            'exception' => $e,
            'data' => $data
        ]);
    }
}
}
