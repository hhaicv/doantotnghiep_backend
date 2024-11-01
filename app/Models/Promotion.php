<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory;
    use SoftDeletes;



    protected $fillable = [
        'code',
        'description',
        'discount',
        'start_date',
        'end_date',
        'new_customer_only',
        'route_id',
        'bus_type_id',
        'user_id'
    ];
    protected $casts = [
        'is_active' => 'new_customer_only',
    ];

    public function promotionUsers()
    {
        return $this->hasMany(PromotionUser::class, 'id_promotion');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function routes()
    {
        return $this->hasMany(Route::class, 'route_id');

    }
}
