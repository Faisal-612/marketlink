<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FarmerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'market_id',
        'stall_name',
        'bio',
        'operating_days',
        'pickup_time_start',
        'pickup_time_end',
        'order_cutoff_hours',
        'stall_number',
        'latitude',
        'longitude',
        'status',
        'banner_image',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class, 'market_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'farmer_id', 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'farmer_id', 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'farmer_id', 'user_id');
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->where('status', 'published')->avg('rating') ?: 5.0, 1);
    }

    public function getBannerImageUrlAttribute(): string
    {
        if (empty($this->banner_image)) {
            return asset('images/site/banner_101.png');
        }
        if (str_starts_with($this->banner_image, 'http://') || str_starts_with($this->banner_image, 'https://')) {
            return $this->banner_image;
        }
        return asset($this->banner_image);
    }
}
