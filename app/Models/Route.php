<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        "route_name",
        "start_route",
        "end_route",
        "execution_time",
        "base_fare_per_km",
        "distance_km",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
