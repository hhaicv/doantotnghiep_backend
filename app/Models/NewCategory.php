<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NewCategory extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable=[

        'category_name',
       
    ];
}
