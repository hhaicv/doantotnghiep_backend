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
        'title',
        'image',
        'code',
        'description',
        'discount',
        'start_date',
        'end_date',
        'count',
        'status', 
        // 'new_customer_only',
        'route_id',
        // 'bus_type_id',
        'user_id'
    ];
    // protected $casts = [
    //     'is_active' => 'new_customer_only',
    // ];

    public function promotionUsers()
    {
        return $this->hasMany(PromotionUser::class, 'id_promotion');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_user', 'promotion_id', 'user_id');
    }
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'promotion_route','promotion_id','route_id');
    }
    public function promotionCategory()
    {
        return $this->belongsTo(PromotionCategory::class, 'promotion_category_id');
    }
    public function usePromotion()
    {
        // Kiểm tra trạng thái của khuyến mãi
        if ($this->status === 'closed') {
            throw new \Exception('Khuyến mãi này đã hết hiệu lực.');
        }

        // Kiểm tra số lượng còn lại
        if ($this->count > 0) {
            // Giảm số lượng
            $this->count -= 1;
            $this->save();

            // Nếu số lượng bằng 0, đóng khuyến mãi
            if ($this->count == 0) {
                $this->status = 'closed';
                $this->save();
            }
        } else {
            throw new \Exception('Khuyến mãi này không còn nữa.');
        }
    }
}
