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
        "time_start",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function stages()
    {
        return $this->hasMany(Stage::class, 'route_id', 'route_id'); // 'route_id' là khóa ngoại trong bảng 'stages' liên kết với 'route_id' trong bảng 'trips'
    }
    // kh biết nó là gì dùng như nào
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Mối quan hệ với Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }


    // Mối quan hệ với ticket_bookings
    public function ticketBookings()
    {
        return $this->hasMany(TicketBooking::class, 'trip_id');
    }
}
