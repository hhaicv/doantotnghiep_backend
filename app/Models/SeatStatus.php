<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SeatStatus extends Model
{
    use HasFactory;
    protected $table = 'seat_status';


    protected $fillable = ['bus_id', 'is_available'];

    public function busSeat()
    {
        return $this->belongsTo(BusSeat::class, 'bus_id');
    }
}
