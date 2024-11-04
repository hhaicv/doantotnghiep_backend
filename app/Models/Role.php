<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name_role',
        'description',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function Admins()
    {
        return $this->hasMany(Admin::class); // Một Role có thể có nhiều admin
    }
}
