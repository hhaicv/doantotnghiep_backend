<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buses extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_bus',
        'model',
        'fare_multiplier',
        'license_plate',
        'total_seats',
        'image',
        'phone',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
