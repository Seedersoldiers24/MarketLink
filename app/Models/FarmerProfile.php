<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'market_id',
        'stall_name',
        'stall_number',
        'contact_person',
        'contact_number',
        'address',
        'operating_days',
        'pickup_windows',
        'cutoff_hours_before',
        'latitude',
        'longitude',
        'bio',
        'avatar',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'cutoff_hours_before' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'farmer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'farmer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'farmer_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function averageRating(): float
    {
        return (float) round($this->reviews()->avg('rating') ?: 5.0, 1);
    }

    public function getPickupSlotsArrayAttribute(): array
    {
        if (empty($this->pickup_windows)) {
            return ['08:00 AM - 10:00 AM', '10:00 AM - 12:00 PM', '12:00 PM - 02:00 PM'];
        }
        return array_map('trim', explode(',', $this->pickup_windows));
    }
}
