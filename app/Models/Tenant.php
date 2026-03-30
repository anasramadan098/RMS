<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{

    public $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'subscribtion_type',
        'subscribtion_created',
        'subscribtion_amount',
        'is_subscribe',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Check if tenant has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        if (!$this->is_subscribe) {
            return false;
        }

        // If subscription was created more than 30 days ago, it's expired
        if ($this->subscribtion_created) {
            $subscriptionDate = \Carbon\Carbon::parse($this->subscribtion_created);
            $daysSinceSubscription = $subscriptionDate->diffInDays(now());
            
            // Subscription valid for 30 days
            if ($daysSinceSubscription > 30) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get remaining days in subscription
     */
    public function getRemainingDaysAttribute(): int
    {
        if (!$this->subscribtion_created) {
            return 0;
        }

        $subscriptionDate = \Carbon\Carbon::parse($this->subscribtion_created);
        $expiryDate = $subscriptionDate->copy()->addDays(30);
        
        return max(0, now()->diffInDays($expiryDate, false));
    }

    /**
     * Get subscription status
     */
    public function getSubscriptionStatusAttribute(): string
    {
        if ($this->hasActiveSubscription()) {
            return 'active';
        }

        return $this->is_subscribe ? 'expired' : 'inactive';
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }


}
