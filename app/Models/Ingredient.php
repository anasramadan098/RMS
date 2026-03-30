<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory, Filterable, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'unit',
        'price_per_unit',
        'stock_quantity',
        'min_stock_level',
        'expiry_date',
        'image',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_level' => 'integer',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];
    // Filters
    public function getFilterableAttributes(): array
    {
        return [
            'name' => [
                'type' => 'text',
                'label' => __('ingredients.name'),
                'placeholder' => __('ingredients.placeholders.enter_ingredient_name')
            ],
            'unit' => [
                'type' => 'text',
                'label' => __('ingredients.unit'),
                'placeholder' => __('ingredients.placeholders.enter_unit')
            ],
            'price_per_unit' => [
                'type' => 'number',
                'label' => __('ingredients.cost'),
                'placeholder' => __('ingredients.placeholders.enter_cost')
            ],
            'stock_quantity' => [
                'type' => 'number',
                'label' => __('ingredients.quantity'),
                'placeholder' => __('ingredients.placeholders.enter_quantity')
            ],
            'min_stock_level' => [
                'type' => 'number',
                'label' => __('ingredients.min_stock_level'),
                'placeholder' => __('ingredients.placeholders.enter_min_stock_level')
            ],
            'expiry_date' => [
                'type' => 'date',
                'label' => __('ingredients.expiry_date'),
            ]
        ];
    }

    /**
     * Get the meals that use this ingredient.
     */
    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Meal::class, 'meal_ingredients')
                    ->withPivot('quantity', 'notes')
                    ->withTimestamps();
    }
    public function supplier()
    {
        return $this->belongsTo(Supply::class, 'supplier_id');
    }

    /**
     * Check if ingredient is low in stock.
     */
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->min_stock_level;
    }

    /**
     * Check if ingredient is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }



    /**
     * Scope a query to only include active ingredients.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include low stock ingredients.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'min_stock_level');
    }

    /**
     * Scope a query to only include out of stock ingredients.
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', '<=', 0);
    }


}
