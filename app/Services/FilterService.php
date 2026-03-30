<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FilterService
{
    /**
     * Extract filters from request
     */
    public function extractFilters(Request $request, array $allowedFilters = []): array
    {
        $filters = [];
        
        foreach ($request->all() as $key => $value) {
            // Skip pagination and other non-filter parameters
            if (in_array($key, ['page', '_token', '_method'])) {
                continue;
            }

            // If allowed filters are specified, only include those
            if (!empty($allowedFilters) && !in_array($key, $allowedFilters)) {
                continue;
            }

            // Skip empty values
            if (is_null($value) || $value === '') {
                continue;
            }

            $filters[$key] = $value;
        }

        return $filters;
    }

    /**
     * Get filter data for a model instance
     */
    public function getFilterData(Model $model, array $currentFilters = []): array
    {
        if (!method_exists($model, 'getFilterConfig')) {
            return [];
        }

        $config = $model->getFilterConfig();
        $filterData = [];

        foreach ($config as $field => $settings) {
            $filterData[$field] = [
                'field' => $field,
                'type' => $settings['type'],
                'label' => $settings['label'],
                'placeholder' => $settings['placeholder'],
                'value' => $currentFilters[$field] ?? '',
                'options' => $this->getFieldOptions($model, $field, $settings),
                'required' => $settings['required'] ?? false,
            ];
        }

        return $filterData;
    }

    /**
     * Get options for a specific field
     */
    protected function getFieldOptions(Model $model, string $field, array $settings): array
    {
        if ($settings['type'] !== 'select') {
            return [];
        }

        if (method_exists($model, 'getSelectOptions')) {
            return $model->getSelectOptions($field);
        }

        return $settings['options'] ?? [];
    }

    /**
     * Build query string from filters
     */
    public function buildQueryString(array $filters): string
    {
        $queryParams = [];
        
        foreach ($filters as $key => $value) {
            if (!is_null($value) && $value !== '') {
                $queryParams[$key] = $value;
            }
        }

        return http_build_query($queryParams);
    }

    /**
     * Check if any filters are active
     */
    public function hasActiveFilters(array $filters): bool
    {
        foreach ($filters as $value) {
            if (!is_null($value) && $value !== '') {
                return true;
            }
        }

        return false;
    }

    /**
     * Clear all filters (return empty array)
     */
    public function clearFilters(): array
    {
        return [];
    }

    /**
     * Validate filter values
     */
    public function validateFilters(array $filters, array $config): array
    {
        $validatedFilters = [];

        foreach ($filters as $field => $value) {
            if (!isset($config[$field])) {
                continue;
            }

            $fieldConfig = $config[$field];
            $validatedValue = $this->validateFieldValue($value, $fieldConfig);

            if ($validatedValue !== null) {
                $validatedFilters[$field] = $validatedValue;
            }
        }

        return $validatedFilters;
    }

    /**
     * Validate a single field value
     */
    protected function validateFieldValue($value, array $config)
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        switch ($config['type']) {
            case 'number':
                return is_numeric($value) ? (float) $value : null;

            case 'date':
                return $this->isValidDate($value) ? $value : null;

            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;

            case 'select':
                // For select fields, validate against available options
                $options = $config['options'] ?? [];
                return in_array($value, array_keys($options)) ? $value : null;

            default:
                return $value;
        }
    }

    /**
     * Check if a value is a valid date
     */
    protected function isValidDate($date): bool
    {
        return $date && strtotime($date) !== false;
    }
}
