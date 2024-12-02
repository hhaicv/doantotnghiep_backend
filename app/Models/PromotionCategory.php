<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'id_promotion');
    }
}
