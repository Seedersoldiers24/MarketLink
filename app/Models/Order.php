<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'farmer_id',
        'market_id',
        'total_amount',
        'pickup_date',
        'pickup_time_slot',
        'order_status',
        'payment_status',
        'customer_notes',
        'farmer_notes',
        'cutoff_time',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'pickup_date' => 'date',
        'cutoff_time' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function farmer()
    {
        return $this->belongsTo(FarmerProfile::class, 'farmer_id');
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function canBeCancelledOrModified(): bool
    {
        if (in_array($this->order_status, ['completed', 'cancelled'])) {
            return false;
        }

        if ($this->cutoff_time && Carbon::now()->isAfter($this->cutoff_time)) {
            return false;
        }

        // If cutoff_time not explicitly set, calculate based on pickup_date and farmer's cutoff_hours_before
        if ($this->pickup_date) {
            $hours = $this->farmer ? $this->farmer->cutoff_hours_before : 12;
            $cutoff = Carbon::parse($this->pickup_date)->startOfDay()->subHours($hours);
            return Carbon::now()->isBefore($cutoff);
        }

        return true;
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->order_status) {
            'placed' => ['bg' => 'bg-amber-100 text-amber-800 border-amber-300', 'label' => 'Order Placed', 'icon' => 'clock'],
            'accepted' => ['bg' => 'bg-blue-100 text-blue-800 border-blue-300', 'label' => 'Accepted by Farmer', 'icon' => 'check'],
            'ready_for_pickup' => ['bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300', 'label' => 'Ready for Pickup', 'icon' => 'shopping-bag'],
            'completed' => ['bg' => 'bg-green-100 text-green-800 border-green-300', 'label' => 'Completed', 'icon' => 'check-circle'],
            'cancelled' => ['bg' => 'bg-rose-100 text-rose-800 border-rose-300', 'label' => 'Cancelled', 'icon' => 'x-circle'],
            default => ['bg' => 'bg-gray-100 text-gray-800 border-gray-300', 'label' => ucfirst($this->order_status), 'icon' => 'info'],
        };
    }
}
