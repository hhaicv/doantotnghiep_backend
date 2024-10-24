<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        "route_id",
        "bus_id",
        "departure_time",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Mối quan hệ với Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // Mối quan hệ với booked_seats
    public function bookedSeats()
    {
        return $this->hasMany(BookedSeat::class, 'trip_id');
    }

    // Mối quan hệ với ticket_bookings
    public function ticketBookings()
    {
        return $this->hasMany(TicketBooking::class, 'trip_id');
    }
}
