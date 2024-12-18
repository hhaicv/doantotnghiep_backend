<?php

namespace App\Mail;

use App\Models\Cancle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CancelOrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cancel;

    /**
     * Create a new message instance.
     */
    public function __construct(Cancle $cancel)
    {
        $this->cancel = $cancel;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.cancel_order_confirmation')
                    ->with(['cancel' => $this->cancel]);
    }
}
