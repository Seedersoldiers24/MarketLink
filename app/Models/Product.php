<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'unit',
        'stock_quantity',
        'is_sold_out',
        'is_weekly_template',
        'harvest_date',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_sold_out' => 'boolean',
        'is_weekly_template' => 'boolean',
    ];

    public function farmer()
    {
        return $this->belongsTo(FarmerProfile::class, 'farmer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function getInStockAttribute(): bool
    {
        return !$this->is_sold_out && $this->stock_quantity > 0;
    }

    public function averageRating(): float
    {
        return (float) round($this->reviews()->avg('rating') ?: 5.0, 1);
    }
}
