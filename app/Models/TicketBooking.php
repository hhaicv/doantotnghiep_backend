<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function busType()
    {
        return $this->belongsTo(Bus::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    protected $fillable = [
        "trip_id",
        "bus_id",
        "route_id",
        "user_id",
        "payment_method_id",
        "location_start",
        "id_start_stop",
        "location_end",
        "id_end_stop",
        "note",
        "date",
        "total_price",
        "total_tickets"
    ];
}
