<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\SoftDeletes;
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56

class BusSeat extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
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
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
}
