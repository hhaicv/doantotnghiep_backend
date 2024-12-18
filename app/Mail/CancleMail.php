<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $cancel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cancel)
    {
        $this->cancel = $cancel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('xekhachhongnhung@gmail.com', 'Xe khách Hồng Nhung') // Đổi tên và email gửi
                    ->view('emails.cancel_confirmation')
                    ->with(['cancel' => $this->cancel])
                    ->subject('Thông báo xác nhận hủy đơn hàng thành công');
    }
}
