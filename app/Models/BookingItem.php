<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $fillable = [
        'booking_id',
        'product_id',
        'addon_id',
        'item_type',
        'name_snapshot',
        'pricing_type_snapshot',
        'qty',
        'unit_price',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeProducts($query)
    {
        return $query->where('item_type', 'product');
    }

    public function scopeAddons($query)
    {
        return $query->where('item_type', 'addon');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Calculate subtotal based on qty and unit_price
     */
    public function calculateSubtotal()
    {
        $this->subtotal = $this->qty * $this->unit_price;
        $this->save();
        
        return $this->subtotal;
    }

    /**
     * Create item from Product
     */
    public static function createFromProduct(Booking $booking, Product $product, int $qty, ?string $notes = null)
    {
        return self::create([
            'booking_id' => $booking->id,
            'product_id' => $product->id,
            'item_type' => 'product',
            'name_snapshot' => $product->name,
            'pricing_type_snapshot' => $product->duration_type,
            'qty' => $qty,
            'unit_price' => $product->price,
            'subtotal' => $product->price * $qty,
            'notes' => $notes,
        ]);
    }

    /**
     * Create item from Addon
     */
    public static function createFromAddon(Booking $booking, Addon $addon, int $qty, ?string $notes = null)
    {
        return self::create([
            'booking_id' => $booking->id,
            'addon_id' => $addon->id,
            'item_type' => 'addon',
            'name_snapshot' => $addon->name,
            'pricing_type_snapshot' => $addon->pricing_type,
            'qty' => $qty,
            'unit_price' => $addon->price,
            'subtotal' => $addon->price * $qty,
            'notes' => $notes,
        ]);
    }

    /**
     * Get display name (from snapshot or relation)
     */
    public function getDisplayName()
    {
        if ($this->name_snapshot) {
            return $this->name_snapshot;
        }

        if ($this->item_type === 'product' && $this->product) {
            return $this->product->name;
        }

        if ($this->item_type === 'addon' && $this->addon) {
            return $this->addon->name;
        }

        return 'Unknown Item';
    }
}