<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'farmer_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
        'farmer_reply',
        'farmer_replied_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'farmer_replied_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function farmer()
    {
        return $this->belongsTo(FarmerProfile::class, 'farmer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
