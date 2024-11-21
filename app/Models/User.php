<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const TYPE_EMPLOYEE = "employee";
    const TYPE_USER = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'image',
        'address',
        'email',
        'password',
        'type',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean', 
    ];

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_user', 'user_id', 'promotion_id');
    }
    public function isEmployee(){
        return $this->type == self::TYPE_EMPLOYEE;
    }
    
    public function isUser(){
        return $this->type == self::TYPE_USER;
    }

    public function tickets()
    {
        return $this->hasMany(TicketBooking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);

    }
}
