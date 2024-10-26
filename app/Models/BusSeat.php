<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class BusSeat extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'bus_seats';

    protected $fillable = [
        'bus_id',
        'seat_name',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    // Define the relationship with the Bus model
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
