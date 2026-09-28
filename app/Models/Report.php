<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'generated_by',
        'report_type',
        'title',
        'summary',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
