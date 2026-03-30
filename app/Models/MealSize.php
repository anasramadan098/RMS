<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealSize extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'meal_id',
        'name_ar',
        'name_en',
        'price',
        'is_active',
        'sort_order',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع الوجبة
     */
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * العلاقة مع عناصر الطلبات
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope للأحجام النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }



    /**
     * Scope للترتيب
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name_ar');
    }

    /**
     * الحصول على الاسم المناسب حسب اللغة
     */
    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : ($this->name_en ?? $this->name_ar);
    }
}
