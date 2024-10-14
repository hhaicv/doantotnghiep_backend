<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Information extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'title',
        'summary',
        'content',
        'thumbnail_image'
    ];
    public function newCategories()
    {
        return $this->belongsToMany(NewCategory::class);
    }
}
