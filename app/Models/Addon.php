<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Addon extends Model
{


    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'pricing_type',
        'price',
        'description',
        'image',
        'has_inventory',
        'stock_quantity',
        'low_stock_threshold',
        'min_quantity',
        'max_quantity',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'has_inventory' => 'boolean',
        'is_active' => 'boolean',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'min_quantity' => 'integer',
        'max_quantity' => 'integer',
    ];

    // ===== BOOT METHOD =====
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($addon) {
            if (empty($addon->slug)) {
                $addon->slug = Str::slug($addon->name);
            }
        });

        static::updating(function ($addon) {
            if ($addon->isDirty('name')) {
                $addon->slug = Str::slug($addon->name);
            }
        });
    }

    // ===== RELATIONSHIPS =====

    // public function bookingAddons()
    // {
    //     return $this->hasMany(BookingAddon::class);
    // }

    // ===== HELPER METHODS =====

    /**
     * Check if addon is out of stock
     */
    public function isOutOfStock(): bool
    {
        if (!$this->has_inventory) {
            return false;
        }

        return $this->stock_quantity <= 0;
    }

    /**
     * Check if addon has low stock
     */
    public function isLowStock(): bool
    {
        if (!$this->has_inventory) {
            return false;
        }

        return $this->stock_quantity > 0 && $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * Get stock status badge color
     */
    public function getStockStatusColor(): string
    {
        if (!$this->has_inventory) {
            return 'gray';
        }

        if ($this->isOutOfStock()) {
            return 'red';
        }

        if ($this->isLowStock()) {
            return 'yellow';
        }

        return 'green';
    }

    /**
     * Get stock status label
     */
    public function getStockStatusLabel(): string
    {
        if (!$this->has_inventory) {
            return 'No Inventory';
        }

        if ($this->isOutOfStock()) {
            return 'Out of Stock';
        }

        if ($this->isLowStock()) {
            return 'Low Stock';
        }

        return 'In Stock';
    }

    /**
     * Get available stock (accounting for reserved)
     */
    public function getAvailableStock(): int
    {
        if (!$this->has_inventory) {
            return 999999; // Unlimited
        }

        $reserved = 0; // Will implement later with booking integration

        return max(0, $this->stock_quantity - $reserved);
    }

    /**
     * Decrease stock
     */
    public function decreaseStock(int $quantity): bool
    {
        if (!$this->has_inventory) {
            return true;
        }

        if ($this->stock_quantity < $quantity) {
            return false;
        }

        $this->stock_quantity -= $quantity;
        $this->save();

        return true;
    }

    /**
     * Increase stock
     */
    public function increaseStock(int $quantity): bool
    {
        if (!$this->has_inventory) {
            return true;
        }

        $this->stock_quantity += $quantity;
        $this->save();

        return true;
    }

    /**
     * Get pricing type label
     */
    public function getPricingTypeLabel(): string
    {
        return match ($this->pricing_type) {
            'per_booking' => 'Per Booking',
            'per_unit_per_night' => 'Per Unit/Night',
            'per_person' => 'Per Person',
            'per_hour' => 'Per Hour',
            'per_slot' => 'Per Slot',
            default => ucfirst(str_replace('_', ' ', $this->pricing_type)),
        };
    }

    /**
     * Get pricing icon
     */
    public function getPricingIcon(): string
    {
        return match ($this->pricing_type) {
            'per_booking' => 'fa-shopping-cart',
            'per_unit_per_night' => 'fa-calendar-alt',
            'per_person' => 'fa-user',
            'per_hour' => 'fa-clock',
            'per_slot' => 'fa-th-large',
            default => 'fa-tag',
        };
    }

    /**
     * Format price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get pricing example
     */
    public function getPricingExample(): string
    {
        return match ($this->pricing_type) {
            'per_booking' => "Fixed {$this->formatted_price} per booking",
            'per_unit_per_night' => "{$this->formatted_price} × units × nights",
            'per_person' => "{$this->formatted_price} × number of people",
            'per_hour' => "{$this->formatted_price} × duration hours",
            'per_slot' => "Fixed {$this->formatted_price} per slot",
            default => $this->formatted_price,
        };
    }

    // ===== SCOPES =====

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('has_inventory', false)
                ->orWhere('stock_quantity', '>', 0);
        });
    }

    public function scopeLowStock($query)
    {
        return $query->where('has_inventory', true)
            ->whereRaw('stock_quantity <= low_stock_threshold')
            ->where('stock_quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('has_inventory', true)
            ->where('stock_quantity', '<=', 0);
    }


    /**
     * Calculate addon price based on pricing type
     * 
     * @param int $quantity Base quantity
     * @param int $nights Number of nights (for per_unit_per_night)
     * @param int $people Number of people (for per_person)
     * @return float
     */
    public function calculatePrice(int $quantity, int $nights = 1, int $people = 1): float
    {
        $basePrice = $this->price;

        switch ($this->pricing_type) {
            case 'per_booking':
                // Fixed price per booking, quantity is multiplier
                return $basePrice * $quantity;

            case 'per_unit_per_night':
                // Price × quantity × nights
                return $basePrice * $quantity * $nights;

            case 'per_person':
                // Price × people × quantity
                return $basePrice * $people * $quantity;

            case 'per_hour':
                // Price × hours (quantity = hours)
                return $basePrice * $quantity;

            case 'per_slot':
                // Fixed price per slot × quantity (slots)
                return $basePrice * $quantity;

            default:
                return $basePrice * $quantity;
        }
    }

    /**
     * Get quantity label based on pricing type
     */
    public function getQuantityLabel(): string
    {
        return match ($this->pricing_type) {
            'per_booking' => 'Quantity',
            'per_unit_per_night' => 'Units',
            'per_person' => 'Quantity',
            'per_hour' => 'Hours',
            'per_slot' => 'Slots',
            default => 'Quantity',
        };
    }

    /**
     * Check if addon has available stock
     */
    public function hasAvailableStock(int $requestedQty): bool
    {
        if (!$this->has_inventory) {
            return true; // Unlimited
        }

        return $this->getAvailableStock() >= $requestedQty;
    }
}
