<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromotionAdded extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $promotion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('xekhachhongnhung@gmail.com', 'Xe khách Hồng Nhung') // Đổi tên và email gửi
                    ->view('emails.promotion_added')
                    ->with(['promotion' => $this->promotion])
                    ->subject('Khuyến mãi mới');
    }
}
