<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "ticket_code",
        "ticket_booking_id",
        "name_seat",
        "price",
        "status"
    ];

    public function ticketBooking()
    {
        return $this->belongsTo(TicketBooking::class, 'ticket_booking_id');
    }

    
}
