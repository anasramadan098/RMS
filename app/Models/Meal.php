<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'price',
        'preparation_time',
        'image',
        'is_available',
        'is_active',
        'category_id',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'preparation_time' => 'integer',
        'is_available' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the category that owns the meal.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the ingredients for the meal.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredients')
                    ->withPivot('quantity', 'notes')
                    ->withTimestamps();
    }

    /**
     * Calculate total cost of ingredients for this meal.
     */
    public function calculateIngredientsCost(): float
    {
        return $this->ingredients->sum(function ($ingredient) {
            return $ingredient->price_per_unit * $ingredient->pivot->quantity;
        });
    }

    /**
     * Check if all ingredients are available for this meal.
     */
    public function hasAvailableIngredients(): bool
    {
        foreach ($this->ingredients as $ingredient) {
            if ($ingredient->stock_quantity < $ingredient->pivot->quantity) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get meal name based on current locale
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Get meal description based on current locale
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->description_ar : $this->description_en;
    }

    /**
     * Get localized name
     */
    public function getLocalizedName($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Get localized description
     */
    public function getLocalizedDescription($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $locale === 'ar' ? $this->description_ar : $this->description_en;
    }

    /**
     * Scope a query to only include active meals.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include available meals.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope a query to only include meals from active categories.
     */
    public function scopeWithActiveCategory($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('is_active', true);
        });
    }

    /**
     * Get the order items for the meal.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * العلاقة مع أحجام الوجبة
     */
    public function sizes()
    {
        return $this->hasMany(MealSize::class);
    }

    /**
     * العلاقة مع إضافات الوجبة
     */
    public function extras()
    {
        return $this->hasMany(MealExtra::class);
    }

    /**
     * الحصول على الأحجام النشطة
     */
    public function activeSizes()
    {
        return $this->hasMany(MealSize::class)->active()->ordered();
    }

    /**
     * الحصول على الإضافات النشطة
     */
    public function activeExtras()
    {
        return $this->hasMany(MealExtra::class)->active()->ordered();
    }



    /**
     * التحقق من وجود أحجام للوجبة
     */
    public function hasSizes()
    {
        return $this->sizes()->active()->exists();
    }

    /**
     * التحقق من وجود إضافات للوجبة
     */
    public function hasExtras()
    {
        return $this->extras()->active()->exists();
    }
    /**
     * Get meal statistics by date range
     */
    public static function sortByDate($date)
    {
        // Get all meals
        $all_results = static::all();

        // Get meals within the specified date range
        $target_results = static::where('created_at', '>=', now()->subDays($date))->get();

        // Calculate percentage
        $per = $all_results->count() > 0 ? ($target_results->count() / $all_results->count()) * 100 : 0;

        // Determine if increase or decrease
        $symbol = '';
        if ($per > 0) {
            $symbol = '+';
        } elseif ($per < 0) {
            $symbol = '-';
        } else {
            $symbol = '';
        }

        // Format percentage
        $percentage = abs($per);
        $percentage = $symbol . number_format($percentage, 1) . '%';

        return [
            'target_results' => $target_results,
            'percentage' => $percentage,
        ];
    }

    /**
     * Scope for filtering meals by date (proper scope usage)
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
