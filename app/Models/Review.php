<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "trip_id",
        "user_id",
        "rating",
        "comment",
        "is_active"
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
