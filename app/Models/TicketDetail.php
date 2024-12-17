<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'ticket_booking_id',
        'name_seat',
        'price',
        'status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function ticketBooking()
    {
        return $this->belongsTo(TicketBooking::class, 'ticket_booking_id')->withDefault();
    }


}
