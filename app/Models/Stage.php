<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        "route_id",
        "start_stop_id",
        "end_stop_id",
        "fare",
        "is_active"
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'route_id'); // Hoặc 'trip_id' nếu có trường này
    }
    
    public function startStop()
    {
        return $this->belongsTo(Stop::class, 'start_stop_id');
    }

    public function endStop()
    {
        return $this->belongsTo(Stop::class, 'end_stop_id');
    }
}
