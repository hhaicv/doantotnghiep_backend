<?php

namespace App\Listeners;

use App\Events\TicketCancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCancelConfirmation implements ShouldQueue
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

        try {
            // Gửi email
            Mail::send('cancel', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'], $data['name'])
                    ->subject('Thông báo Hủy Đơn Hàng Thành Công');
            });

            // Log khi gửi email thành công
            Log::info("Email đã được gửi đến: {$data['email']}.");
        } catch (\Exception $e) {
            // Log chi tiết lỗi nếu gửi email thất bại
            Log::error("Lỗi khi gửi email cho {$data['email']}: " . $e->getMessage(), [
                'exception' => $e,
                'data' => $data,
                'error_code' => $e->getCode(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
