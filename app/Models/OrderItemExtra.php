<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'meal_extra_id',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * العلاقة مع عنصر الطلب
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * العلاقة مع الإضافة
     */
    public function mealExtra()
    {
        return $this->belongsTo(MealExtra::class);
    }

    /**
     * حساب السعر الإجمالي للإضافة
     */
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
