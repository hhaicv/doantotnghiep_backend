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
        "stage_order",
        "fare",
        "is_active"
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
