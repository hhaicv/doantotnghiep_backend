<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stop extends Model
{
    use HasFactory;

    use SoftDeletes;

<<<<<<< HEAD
    protected $fillable = ['stop_name', 'parent_id', 'is_active', 'description'];

    // Quan hệ con
    public function children()
    {
        return $this->hasMany(Stop::class, 'parent_id');
    }

    // Quan hệ cha
    public function parent()
    {
        return $this->belongsTo(Stop::class, 'parent_id');
    }
    
=======
    protected $fillable=[

        'stop_name',
        'description',
        'is_active'
    ];

>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
