<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'path',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'path_en',
        'start_time',
        'end_time',
        'active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'active' => 'boolean',
    ];

    /**
     * Check if the ad is currently active based on time range and active status
     */
    public function isActiveNow(): bool
    {
        if (!$this->active) {
            return false;
        }
        
        return $this->active ;
    }

    /**
     * Get the name in the current locale
     */
    public function getName($locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        if ($locale === 'ar') {
            return $this->name_ar ?? $this->name_en ?? 'إعلان بدون عنوان';
        } else {
            return $this->name_en ?? $this->name_ar ?? 'Untitled Ad';
        }
    }

    /**
     * Get the description in the current locale
     */
    public function getDescription($locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        
        if ($locale === 'ar') {
            return $this->description_ar ?? $this->description_en;
        } else {
            return $this->description_en ?? $this->description_ar;
        }
    }

    /**
     * Get the image path in the current locale
     */
    public function getImagePath($locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        
        if ($locale === 'en' && $this->path_en) {
            return $this->path_en;
        }
        
        return $this->path;
    }
}
