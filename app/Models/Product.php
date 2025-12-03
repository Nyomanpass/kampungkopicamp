<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $casts = [

        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'images' => 'array',
        'facilities' => 'array',
    ];
    protected $table = 'products';



    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'price',
        'capacity_per_unit',
        'max_participant',
        'duration_type',
        'default_units',
        'default_seats',
        'images',
        'facilities',
        'is_active',
    ];




    // ===== BOOT - Auto Generate Slug =====
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) { // 👈 FIX: "slug" bukan "slud"
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ===== RELATIONSHIPS =====
    public function availability()
    {
        return $this->hasMany(Availability::class);
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    // ===== SCOPES =====
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ===== HELPER METHODS =====

    /**
     * Route model binding menggunakan slug
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get availability for specific date
     */
    public function getAvailabilityForDate($date)
    {
        return $this->availability()->onDate($date)->first();
    }

    /**
     * Check if product available for date range
     */
    public function isAvailableForDateRange($startDate, $endDate, $unitsNeeded = 1, $seatsNeeded = 1)
    {
        $dates = $this->availability()
            ->dateRange($startDate, $endDate)
            ->get();

        if ($dates->isEmpty()) {
            return false; // No availability data
        }

        foreach ($dates as $availability) {
            if ($this->type === 'touring') {
                if (!$availability->hasAvailableSeats($seatsNeeded)) {
                    return false;
                }
            } else { // accommodation or area_rental
                if (!$availability->hasAvailableUnits($unitsNeeded)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Calculate required units based on people count and capacity
     * For accommodation only
     */

    /**
     * Calculate total price for date range
     */
    public function calculatePrice($startDate, $endDate, $qty = 1)
    {
        if ($this->type === 'accommodation' || $this->type === 'area_rental') {
            $nights = \Carbon\Carbon::parse($startDate)->diffInDays($endDate);
            return $this->price * $nights * $qty;
        }

        // For touring (per seat/person)
        return $this->price * $qty;
    }

    public function getDefaultStockCapacity()
    {
        // Return default values based on product type
        return [
            'available_unit' => $this->type === 'touring' ? 0 : 10, // Default 10 units for accommodation
            'available_seat' => $this->type === 'touring' ? 20 : 0, // Default 20 seats for touring
        ];
    }

    public function calculateRequiredUnits($peopleCount)
    {
        if ($this->type === 'touring' || !$this->capacity_per_unit) {
            return 0; // Touring doesn't use units
        }

        return (int) ceil($peopleCount / $this->capacity_per_unit);
    }
}
