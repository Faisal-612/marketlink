<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'farmer_id',
        'total_amount',
        'pickup_date',
        'pickup_time_slot',
        'order_status',
        'payment_status',
        'customer_notes',
        'farmer_notes',
        'cancelled_reason',
    ];

    protected $casts = [
        'total_amount' => 'float',
        'pickup_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->order_status) {
            'placed' => 'bg-warning text-dark',
            'accepted' => 'bg-info text-dark',
            'ready_for_pickup' => 'bg-primary text-white',
            'completed' => 'bg-success text-white',
            'cancelled' => 'bg-danger text-white',
            default => 'bg-secondary text-white',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->order_status) {
            'placed' => 'Order Placed',
            'accepted' => 'Accepted by Farmer',
            'ready_for_pickup' => 'Ready for Pickup',
            'completed' => 'Completed / Picked Up',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->order_status),
        };
    }
}
