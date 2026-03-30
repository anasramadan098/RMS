<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory, Filterable, BelongsToTenant;
    protected $fillable = [
        'tenant_id',
        'name',
        'amount',
        'created_at'
    ];

    /**
     * Get filterable attributes for this model
     */
    public function getFilterableAttributes(): array
    {
        return [
            'name' => [
                'type' => 'text',
                'label' => __('costs.name'),
                'placeholder' => __('costs.placeholders.enter_cost_name')
            ],
            'amount' => [
                'type' => 'number',
                'label' => __('costs.amount'),
                'placeholder' => __('costs.placeholders.enter_amount')
            ],
            'created_at' => [
                'type' => 'date',
                'label' => __('app.created_at'),
            ]
        ];
    }

    // Sort By Date That Taken Like (Last Month, Last Week, Last Year)
    public static function getStatsByDate($date)
    {
        // Get all costs
        $all_results = static::all();

        // Get costs within the specified date range
        $target_results = static::where('created_at', '>=', now()->subDays($date))
                               ->get();

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

    // Sum All Prices And Percentage Depends On Date
    public static function getSumStatsByDate($date)
    {
        // Get all costs
        $all_results = static::all();

        // Get costs within the specified date range
        $target_results = static::where('created_at', '>=', now()->subDays($date))
                               ->get();

        // Calculate percentage based on sum
        $per = $all_results->sum('amount') > 0 ? ($target_results->sum('amount') / $all_results->sum('amount')) * 100 : 0;

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
        $percentage = abs(number_format($per, 2));
        $percentage = $symbol . $percentage . '%';

        return [
            'target_results' => $target_results,
            'percentage' => $percentage,
        ];
    }

}
