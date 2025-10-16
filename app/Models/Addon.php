<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = [
        'name',
        'pricing_type',
        'price',
        'has_inventory',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'has_inventory' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
