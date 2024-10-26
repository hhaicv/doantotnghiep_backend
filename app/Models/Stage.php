<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\SoftDeletes;
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56

class Stage extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
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
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
}
