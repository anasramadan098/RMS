<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant;

class Competitor extends Model
{
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'website',
        'email',
        'phone',
        'avg_price_range',
        'twitter',
        'youtube',
        'facebook',
        'instagram',
        'tiktok',
        'linkedin',
        'strengths',
        'weaknesses',
        'notes',
        'tenant_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'avg_price_range' => 'decimal:2',
    ];
}
