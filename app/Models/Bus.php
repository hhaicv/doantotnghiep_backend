<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        'name_bus',
        'model',
        'license_plate',
        'total_seats',
        'driver_id',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    public function trips()
    {
        return $this->hasMany(Trip::class, 'bus_id');
    }
}
