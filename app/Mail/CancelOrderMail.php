<?php

namespace App\Mail;

use App\Models\Cancle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancelOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public $cancel;

    public function __construct(Cancle $cancel)
    {
        $this->cancel = $cancel;
    }

    public function build()
    {
        return $this->subject('Thông báo Hủy Đơn Hàng Thành Công')
                    ->view('emails.cancel')
                    ->with([
                        'name' => $this->cancel->name,
                        'email' => $this->cancel->email,
                        'order_code' => $this->cancel->order_code,
                        'reason' => $this->cancel->reason,
                        'phone' => $this->cancel->phone,
                        'account_number' => $this->cancel->account_number,
                        'bank' => $this->cancel->bank,
                    ]);
    }
}
