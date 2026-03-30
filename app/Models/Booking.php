<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToTenant;
use Carbon\Carbon;

class Booking extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'guests',
        'datetime',
        'event',
        'status',
        'client_id'
    ];

    protected $casts = [
        'datetime' => 'datetime',
        'guests' => 'integer'
    ];

    /**
     * Relationship with Client
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get formatted datetime
     */
    public function getFormattedDatetimeAttribute()
    {
        return $this->datetime ? $this->datetime->format('Y-m-d H:i') : null;
    }

    /**
     * Get formatted date only
     */
    public function getFormattedDateAttribute()
    {
        return $this->datetime ? $this->datetime->format('Y-m-d') : null;
    }

    /**
     * Get formatted time only
     */
    public function getFormattedTimeAttribute()
    {
        return $this->datetime ? $this->datetime->format('H:i') : null;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'confirmed' => 'bg-success',
            'cancelled' => 'bg-danger',
            'completed' => 'bg-info',
            default => 'bg-secondary'
        };
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed', 
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => ucfirst($this->status)
        };
    }

    /**
     * Check if booking is upcoming
     */
    public function getIsUpcomingAttribute()
    {
        return $this->datetime && $this->datetime->isFuture();
    }

    /**
     * Check if booking is past
     */
    public function getIsPastAttribute()
    {
        return $this->datetime && $this->datetime->isPast();
    }

    /**
     * Scope for upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('datetime', '>', now());
    }

    /**
     * Scope for past bookings
     */
    public function scopePast($query)
    {
        return $query->where('datetime', '<', now());
    }

    /**
     * Scope for today's bookings
     */
    public function scopeToday($query)
    {
        return $query->whereDate('datetime', today());
    }

    /**
     * Scope for bookings by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get filterable attributes for search/filter functionality
     */
    public function getFilterableAttributes()
    {
        return [
            'name' => [
                'type' => 'text',
                'label' => 'Name',
                'placeholder' => 'Search by name...'
            ],
            'phone' => [
                'type' => 'text', 
                'label' => 'Phone',
                'placeholder' => 'Search by phone...'
            ],
            'status' => [
                'type' => 'select',
                'label' => 'Status',
                'options' => [
                    '' => 'All Statuses',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'cancelled' => 'Cancelled',
                    'completed' => 'Completed'
                ]
            ],
            'datetime' => [
                'type' => 'date',
                'label' => 'Date'
            ]
        ];
    }
}
