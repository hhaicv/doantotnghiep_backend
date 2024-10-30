<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable = [
        "route_name",
        "start_route",
        "end_route",
        "execution_time",
        "description",
        "distance_km",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class);
    }
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_route');
    }
}
