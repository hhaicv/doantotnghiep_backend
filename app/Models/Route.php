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
        "start_route_id",
        "end_route_id",
        "cycle",
        "description",
        "route_price",
        "length",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class, 'route_id'); // Giả định rằng 'route_id' là khóa ngoại trong bảng stages
    }
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_route', 'route_id', 'promotion_id');
    }
}
