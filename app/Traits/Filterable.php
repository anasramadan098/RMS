<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    /**
     * Get filterable attributes for this model
     * Override this method in your model to define custom filterable attributes
     */
    public function getFilterableAttributes(): array
    {
        return [];
    }

    /**
     * Get the filter configuration for this model
     * This includes field types, labels, and options
     */
    public function getFilterConfig(): array
    {
        $filterableAttributes = $this->getFilterableAttributes();
        $config = [];

        foreach ($filterableAttributes as $attribute => $settings) {
            if (is_numeric($attribute)) {
                // Simple attribute name without settings
                $attribute = $settings;
                $settings = [];
            }

            $config[$attribute] = array_merge([
                'type' => $this->guessFieldType($attribute),
                'label' => $this->generateLabel($attribute),
                'placeholder' => 'Filter by ' . $this->generateLabel($attribute),
                'options' => [],
                'relationship' => null,
            ], $settings);
        }

        return $config;
    }

    /**
     * Guess the field type based on attribute name and database column
     */
    protected function guessFieldType(string $attribute): string
    {
        // Check if it's a relationship
        if (str_ends_with($attribute, '_id')) {
            return 'select';
        }

        // Check common patterns
        if (in_array($attribute, ['email'])) {
            return 'email';
        }

        if (in_array($attribute, ['phone', 'contact_number'])) {
            return 'tel';
        }

        if (str_contains($attribute, 'date') || str_contains($attribute, 'created_at') || str_contains($attribute, 'updated_at')) {
            return 'date';
        }

        if (in_array($attribute, ['price', 'amount', 'total', 'stock', 'quantity'])) {
            return 'number';
        }

        if (in_array($attribute, ['status', 'category', 'payment_method'])) {
            return 'select';
        }

        return 'text';
    }

    /**
     * Generate a human-readable label from attribute name
     */
    protected function generateLabel(string $attribute): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $attribute));
    }

    /**
     * Apply filters to the query
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $filterConfig = $this->getFilterConfig();

        foreach ($filters as $field => $value) {
            if (empty($value) || !isset($filterConfig[$field])) {
                continue;
            }

            $config = $filterConfig[$field];

            // Handle relationship filters
            if ($config['relationship']) {
                $this->applyRelationshipFilter($query, $field, $value, $config);
                continue;
            }

            // Handle direct attribute filters
            $this->applyAttributeFilter($query, $field, $value, $config);
        }

        return $query;
    }

    /**
     * Apply filter for direct model attributes
     */
    protected function applyAttributeFilter(Builder $query, string $field, $value, array $config): void
    {
        switch ($config['type']) {
            case 'text':
            case 'email':
            case 'tel':
                $query->where($field, 'LIKE', "%{$value}%");
                break;

            case 'number':
                if (is_numeric($value)) {
                    $query->where($field, '>=', $value);
                }
                break;

            case 'select':
                $query->where($field, '=', $value);
                break;

            case 'date':
                if ($this->isValidDate($value)) {
                    $query->whereDate($field, '=', $value);
                }
                break;

            case 'date_range':
                if (is_array($value) && count($value) === 2) {
                    [$from, $to] = $value;
                    if ($this->isValidDate($from) && $this->isValidDate($to)) {
                        $query->whereBetween($field, [$from, $to]);
                    }
                }
                break;
        }
    }

    /**
     * Apply filter for relationship attributes
     */
    protected function applyRelationshipFilter(Builder $query, string $field, $value, array $config): void
    {
        $relationship = $config['relationship'];

        if (str_ends_with($field, '_id')) {
            // Direct foreign key filter
            $query->where($field, '=', $value);
        } else {
            // Filter through relationship
            $query->whereHas($relationship, function ($q) use ($field, $value, $config) {
                $this->applyAttributeFilter($q, $field, $value, $config);
            });
        }
    }

    /**
     * Check if a value is a valid date
     */
    protected function isValidDate($date): bool
    {
        return $date && strtotime($date) !== false;
    }

    /**
     * Get options for select fields
     */
    public function getSelectOptions(string $field): array
    {
        $config = $this->getFilterConfig();

        if (!isset($config[$field]) || $config[$field]['type'] !== 'select') {
            return [];
        }

        // If options are predefined, return them
        if (!empty($config[$field]['options'])) {
            return $config[$field]['options'];
        }

        // If it's a relationship field, get related model options
        if ($config[$field]['relationship']) {
            return $this->getRelationshipOptions($field, $config[$field]);
        }

        // Get distinct values from the database
        return $this->getDistinctValues($field);
    }

    /**
     * Get options from related model
     */
    protected function getRelationshipOptions(string $field, array $config): array
    {
        $relationship = $config['relationship'];

        if (!method_exists($this, $relationship)) {
            return [];
        }

        try {
            $relatedModel = $this->$relationship()->getRelated();
            $displayField = $config['display_field'] ?? 'name';
            $valueField = $config['value_field'] ?? 'id';

            return $relatedModel->pluck($displayField, $valueField)->toArray();
        } catch (\Exception $e) {
            // If there's an error getting relationship options, return empty array
            return [];
        }
    }

    /**
     * Get distinct values for a field from the database
     */
    protected function getDistinctValues(string $field): array
    {
        return $this->distinct()
            ->whereNotNull($field)
            ->where($field, '!=', '')
            ->pluck($field, $field)
            ->toArray();
    }
}
