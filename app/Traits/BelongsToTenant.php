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
        static::addGlobalScope('tenant', function (Builder $query) {
            if (!app()->resolved('auth')) {
                return;
            }
            
            if (session()->has('tenant_id')) {
                // التعديل هنا: استخدمنا qualifyColumn لضمان إضافة اسم الجدول أوتوماتيكياً
                // هيتحول من: WHERE tenant_id = 1 
                // إلى: WHERE ingredients.tenant_id = 1
                $query->where($query->qualifyColumn('tenant_id'), session('tenant_id'));
            }
        });

        static::creating(function ($model) {
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
        // بنستخدم الفانكشن qualifyColumn عشان لارايفل يضيف اسم الجدول أوتوماتيك
        // فتبقي ingredients.tenant_id بدلاً من tenant_id بس
        return $query->where($query->qualifyColumn('tenant_id'), $tenantId);
    }

    /**
     * Get all tenants - bypass tenant scope.
     */
    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}
