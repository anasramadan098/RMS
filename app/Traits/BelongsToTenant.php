<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    /**
     * Boot the trait.
     */
    public static function bootBelongsToTenant(): void
    {
        // Automatically scope queries to the current tenant (only for SELECT queries)
        static::addGlobalScope('tenant', function (Builder $query) {
            // Avoid infinite loop by checking if auth is resolving
            if (!app()->resolved('auth')) {
                return;
            }
            
            // Use session directly instead of auth() helper to avoid infinite loop
            if (session()->has('tenant_id')) {
                $query->where('tenant_id', session('tenant_id'));
            }
        });

        // Automatically set tenant_id when creating new models
        static::creating(function ($model) {
            // Use session directly instead of auth() helper to avoid infinite loop
            if (session()->has('tenant_id')) {
                $model->tenant_id = session('tenant_id');
            }
        });
    }

    /**
     * Get the tenant that owns this model.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Set a new tenant for this model.
     */
    public function setTenant(Tenant $tenant): void
    {
        $this->tenant_id = $tenant->id;
    }

    /**
     * Check if the model belongs to a specific tenant.
     */
    public function isOwnedBy(Tenant $tenant): bool
    {
        return $this->tenant_id === $tenant->id;
    }

    /**
     * Scope a query to only include models for a specific tenant.
     */
    public function scopeForTenant(Builder $query, $tenantId): Builder
    {
        return $query->where($query->getModel()->getTable() . '.tenant_id', $tenantId);

    }

    /**
     * Get all tenants - bypass tenant scope.
     */
    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}
