<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'meal_id',
        'meal_size_id',
        'size_name',
        'size_price',
        'quantity',
        'unit_price',
        'total_price',
        'special_instructions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'size_price' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            // حساب السعر الإجمالي تلقائياً
            $orderItem->total_price = $orderItem->quantity * $orderItem->unit_price;
        });
    }

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the meal that belongs to the order item.
     */
    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * العلاقة مع حجم الوجبة
     */
    public function mealSize(): BelongsTo
    {
        return $this->belongsTo(MealSize::class);
    }

    /**
     * العلاقة مع إضافات العنصر
     */
    public function extras()
    {
        return $this->hasMany(OrderItemExtra::class);
    }

    /**
     * Calculate the total price for this item including extras.
     */
    public function calculateTotalPrice(): float
    {
        $basePrice = $this->quantity * $this->unit_price;
        $extrasPrice = $this->extras->sum('total_price');
        return $basePrice + $extrasPrice;
    }

    /**
     * الحصول على السعر الإجمالي مع الإضافات
     */
    public function getTotalPriceWithExtrasAttribute()
    {
        return $this->calculateTotalPrice();
    }

    /**
     * الحصول على سعر الإضافات فقط
     */
    public function getExtrasPriceAttribute()
    {
        return $this->extras->sum('total_price');
    }
}
