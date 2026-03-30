<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToTenant;

class Category extends Model
{
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'tenant_id',
        'description_en',
        'image',
        'is_active',
        'type',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the meals for the category.
     */
    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Get active meals for the category.
     */
    public function activeMeals(): HasMany
    {
        return $this->hasMany(Meal::class)->where('is_active', true);
    }

    /**
     * Get available meals for the category.
     */
    public function availableMeals(): HasMany
    {
        return $this->hasMany(Meal::class)->where('is_available', true)->where('is_active', true);
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get category statistics by date range
     */
    public static function getStatsByDate($date)
    {
        // Get all categories
        $all_results = static::all();

        // Get categories within the specified date range
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
     * Scope for filtering categories by date (proper scope usage)
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get category name based on current locale
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Get category description based on current locale
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
}
