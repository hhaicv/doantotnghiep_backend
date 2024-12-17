<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'date_of_birth',
        'email',
        'password',
        'phone',
        'profile_image',
        'license_number',
        'address',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }
    public function buses()
    {
        return $this->belongsToMany(Bus::class);
    }
}
