<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancle extends Model
{
    use HasFactory;

    protected $fillable = [
        "ticket_booking_id",
        "name",
        "phone",
        "email",
        "order_code",
        "account_number",
        "bank",
        "reason",
    ];

    public function ticketBooking()
    {
        return $this->belongsTo(TicketBooking::class, 'ticket_booking_id');
    }
}
