<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Bill extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'order_id',
        'bill_number',
        'bill_data',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
