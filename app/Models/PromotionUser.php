<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionUser extends Model
{
    use HasFactory;
    use SoftDeletes;


  

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'promotion_id',
         'used_at',

    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'id_promotion');
    }
}
