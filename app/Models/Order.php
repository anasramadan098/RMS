<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\BelongsToTenant;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_number',
        'user_id',
        'tenant_id',
        'client_id',
        'status',
        'order_type',
        'table_number',
        'subtotal',
        'tax_amount',
        'delivery_fee',
        'discount_amount',
        'total_amount',
        'notes',
        'prepared_at',
        'delivered_at',
        'completed_at',
        'completed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'prepared_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(8));
            }
        });

        // منطق خصم المخزون تم نقله إلى OrderController
    }

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function bill()  
    {
        return $this->hasOne(Bill::class);
    }

    /**
     * Get the user that completed the order.
     */
    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Get the client that owns the order.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // تم نقل منطق خصم المخزون إلى OrderController

    /**
     * Calculate total amount including tax and delivery.
     */
    public function calculateTotal(): float
    {
        return $this->subtotal + $this->tax_amount + $this->delivery_fee - $this->discount_amount;
    }

    /**
     * Scope a query to only include orders with specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include orders of specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('order_type', $type);
    }

    /**
     * Check if order can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'preparing']);
    }

    /**
     * Get status label in Arabic.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'في الانتظار',
            'preparing' => 'قيد التحضير',
            'ready' => 'جاهز',
            'delivered' => 'تم التسليم',
            'cancelled' => 'ملغي',
            default => 'غير محدد',
        };
    }

    /**
     * Get order type label in Arabic.
     */
    public function getOrderTypeLabelAttribute(): string
    {
        return match($this->order_type) {
            'dine_in' => 'تناول في المطعم',
            'takeaway' => 'استلام',
            'delivery' => 'توصيل',
            default => 'غير محدد',
        };
    }

    /**
     * Get table display text
     */
    public function getTableDisplayAttribute(): string
    {
        if ($this->order_type === 'dine_in' && $this->table_number) {
            return __('app.restaurant.table') . ' ' . $this->table_number;
        }
        return $this->order_type_label;
    }

    /**
     * Scope for orders by table number
     */
    public function scopeByTable($query, $tableNumber)
    {
        return $query->where('table_number', $tableNumber);
    }

    /**
     * Scope for orders by client
     */
    public function scopeByClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    /**
     * Scope for dine-in orders
     */
    public function scopeDineIn($query)
    {
        return $query->where('order_type', 'dine_in');
    }

    /**
     * Scope for takeaway orders
     */
    public function scopeTakeaway($query)
    {
        return $query->where('order_type', 'takeaway');
    }

    /**
     * Scope for delivery orders
     */
    public function scopeDelivery($query)
    {
        return $query->where('order_type', 'delivery');
    }

    /**
     * Get orders for a specific table
     */
    public static function getTableOrders($tableNumber, $status = null)
    {
        $query = static::byTable($tableNumber)->with(['client', 'orderItems.meal']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get client order history
     */
    public static function getClientOrderHistory($clientId, $limit = 10)
    {
        return static::byClient($clientId)
                    ->with(['orderItems.meal'])
                    ->orderBy('created_at', 'desc')
                    ->limit($limit)
                    ->get();
    }
    /**
     * Get order statistics by date range
     */
    public static function sortByDate($date)
    {
        // Get all orders
        $all_results = static::all();

        // Get orders within the specified date range
        $target_results = static::where('created_at', '>=', now()->subDays($date))->get();

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

    /**
     * Get sum statistics by date range
     */
    public static function sumPrices($date)
    {
        // Get all orders
        $all_results = static::all();

        // Get orders within the specified date range
        $target_results = static::where('created_at', '>=', now()->subDays($date))->get();

        // Calculate percentage based on sum
        $per = $all_results->sum('total_amount') > 0 ? ($target_results->sum('total_amount') / $all_results->sum('total_amount')) * 100 : 0;

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
