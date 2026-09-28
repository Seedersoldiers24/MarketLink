<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'market_name',
        'slug',
        'address',
        'city',
        'operating_days',
        'timings',
        'latitude',
        'longitude',
        'map_provider',
        'description',
        'image',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    public function farmers()
    {
        return $this->hasMany(FarmerProfile::class, 'market_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'market_id');
    }
}
