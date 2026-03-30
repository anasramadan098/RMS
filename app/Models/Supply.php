<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Supply extends Model
{
    use HasFactory, Filterable, BelongsToTenant;

    protected $table = 'suppliers';

    /**
     * Get the products for this supplier
     */
    public function meals()
    {
        return $this->hasMany(Meal::class, 'supply_id');
    }
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'supplier_id');
    }

    protected $fillable = [
        'tenant_id',
        'supplier_name',
        'contact_number',
        'email',
        'notes' , 
        'is_active',
        'created_at',
        'updated_at',
    ];

    /**
     * Get filterable attributes for this model
     */
    public function getFilterableAttributes(): array
    {
        return [
            'supplier_name' => [
                'type' => 'text',
                'label' => __('suppliers.supplier_name'),
                'placeholder' => __('suppliers.placeholders.enter_supplier_name')
            ],
            'contact_number' => [
                'type' => 'tel',
                'label' => __('suppliers.contact_person'),
                'placeholder' => __('suppliers.placeholders.enter_contact_person')
            ],
            'email' => [
                'type' => 'email',
                'label' => __('suppliers.email'),
                'placeholder' => __('suppliers.placeholders.enter_email')
            ],
            'created_at' => [
                'type' => 'date',
                'label' => 'Created Date',
            ]
        ];
    }

    /**
     * Get supply statistics by date range
     */
    public static function getStatsByDate($date)
    {
        $user_id = Auth::id();

        // Get all supplies for the user
        $all_results = static::where('user_id', $user_id)->get();

        // Get supplies within the specified date range
        $target_results = static::where('user_id', $user_id)
                               ->where('created_at', '>=', now()->subDays($date))
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
        $percentage = abs(number_format($per, 2));
        $percentage = $symbol . $percentage . '%';

        return [
            'target_results' => $target_results,
            'percentage' => $percentage,
        ];
    }

}
