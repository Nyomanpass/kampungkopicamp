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

    // ======== method ==========
    public function calculatePrice($qty, $nights = 0, $peopleCount = 0, $hours = 0, $slotCount  = 0)
    {
        switch ($this->pricing_type) {
            case 'per_booking':
                return $this->price * $qty;

            case 'per_unit_per_night':
                return $this->price * $qty * $nights;

            case 'per_person':
                return $this->price * $peopleCount;

            case 'per_hour':
                return $this->price * $hours;

            case 'per_slot':
                return $this->price * $slotCount;

            default:
                return 0;
        }
    }

    public function getPricingLabel()
    {
        return match ($this->pricing_type){
            'per_booking' => 'Per Booking',
            'per_unit_per_night' => 'Per Unit Per Night',
            'per_person' => 'Per Person',
            'per_hour' => 'Per Hour',
            'per_slot' => 'Per Slot',
            default => '',
        };
    }
}
