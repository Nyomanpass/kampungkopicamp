<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'booking_token',
        'user_id',
        'product_type',
        'start_date',
        'end_date',
        'people_count',
        'unit_count',
        'seat_count',
        'subtotal',
        'discount_total',
        'total_price',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'special_requests',
        'bonus_meta',
        'voucher_id',
        'discount_amount',
        'booking_source',
        'payment_method',
        'payment_notes',
        'status_note',
        'addon_history',
        'bonus_meta',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'total_price' => 'integer',
        'bonus_meta' => 'array',
    ];

    // ============================================
    // BOOT METHOD - Auto Generate Token
    // ============================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_token)) {
                $booking->booking_token = 'BKG-' . strtoupper(Str::random(10));
            }
        });
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingItems()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class);
    }

    public function productItems()
    {
        return $this->hasMany(BookingItem::class)->where('item_type', 'product');
    }

    public function addonItems()
    {
        return $this->hasMany(BookingItem::class)->where('item_type', 'addon');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function voucherRedemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending_payment');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['paid', 'confirmed', 'checked_in']);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate]);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Calculate total nights (for accommodation)
     */
    public function getTotalNights()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Check if booking is guest (no user_id)
     */
    public function isGuest()
    {
        return is_null($this->user_id);
    }

    /**
     * Mark booking as expired (dipanggil dari webhook Midtrans)
     */
    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);

        // Return availability (rollback stock)
        $this->releaseAvailability();
    }

    public function holdAvailability()
    {
        foreach ($this->bookingItems as $item) {
            if ($item->item_type === 'product' && $item->product_id) {
                $product = Product::find($item->product_id);

                if ($product) {
                    // Generate date range
                    $period = Carbon::parse($this->start_date)->daysUntil($this->end_date);

                    foreach ($period as $date) {
                        $availability = Availability::where('product_id', $product->id)
                            ->where('date', $date->format('Y-m-d'))
                            ->first();

                        if ($availability) {
                            if ($product->type === 'touring') {
                                $availability->decreaseSeats($this->seat_count ?? 0);
                            } else {
                                $availability->decreaseUnits($this->unit_count ?? 0);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Release availability (return stock when cancelled/expired)
     */
    public function releaseAvailability()
    {
        foreach ($this->bookingItems as $item) {
            if ($item->item_type === 'product' && $item->product_id) {
                $product = Product::find($item->product_id);

                if ($product) {
                    // Generate date range
                    $period = Carbon::parse($this->start_date)->daysUntil($this->end_date);

                    foreach ($period as $date) {
                        $availability = Availability::where('product_id', $product->id)
                            ->where('date', $date->format('Y-m-d'))
                            ->first();

                        if ($availability) {
                            if ($product->type === 'touring') {
                                $availability->increaseSeats($this->seat_count ?? 0);
                            } else {
                                $availability->increaseUnits($this->unit_count ?? 0);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Calculate final total after discount
     */
    public function calculateTotal()
    {
        $this->total_price = $this->subtotal - $this->discount_total;
        $this->save();
    }

    /**
     * Get payment status
     */
    public function getLatestPayment()
    {
        return $this->payments()->latest()->first();
    }

    /**
     * Check if payment is successful
     */
    public function isPaid()
    {
        return in_array($this->status, ['paid', 'confirmed', 'checked_in', 'completed']);
    }

    public function hasBonus()
    {
        return !empty($this->bonus_meta);
    }

    public function getBonusItems()
    {
        return $this->bonus_meta ?? [];
    }

    public function updateBonusRedemption($bonusIndex, $qtyRedeemed)
    {
        $bonusMeta = $this->bonus_meta;

        if (isset($bonusMeta[$bonusIndex])) {
            $bonusMeta[$bonusIndex]['qty_redeemed'] = min(
                $qtyRedeemed,
                $bonusMeta[$bonusIndex]['qty_total']
            );

            $this->update(['bonus_meta' => $bonusMeta]);
        }
    }

    public function isBonusFullyRedeemed()
    {
        if (!$this->hasBonus()) {
            return false;
        }

        foreach ($this->bonus_meta as $bonus) {
            if ($bonus['qty_redeemed'] < $bonus['qty_total']) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if booking is walk-in
     */
    public function isWalkIn()
    {
        return $this->booking_source === 'walk-in';
    }

    /**
     * Check if booking is online
     */
    public function isOnline()
    {
        return $this->booking_source === 'online';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'gray',
            'pending_payment' => 'yellow',
            'paid' => 'green',
            'checked_in' => 'blue',
            'completed' => 'purple',
            'cancelled' => 'red',
            'expired' => 'gray',
            'refunded' => 'orange',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
    }

    /**
     * Get duration in nights/days
     */
    public function getDurationAttribute()
    {
        $days = $this->start_date->diffInDays($this->end_date);
        return $days . ($this->product_type === 'touring' ? ' day(s)' : ' night(s)');
    }

    /**
     * Get total nights/days
     */
    public function getTotalNightsAttribute()
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    /**
     * Check if booking has bonus items
     */
    public function hasBonusItems()
    {
        return !empty($this->bonus_meta);
    }

    /**
     * Get bonus redemption progress
     */
    public function getBonusProgressAttribute()
    {
        if (!$this->bonus_meta) {
            return [];
        }

        return collect($this->bonus_meta)->map(function ($bonus) {
            $total = $bonus['qty_total'] ?? 0;
            $redeemed = $bonus['qty_redeemed'] ?? 0;
            $remaining = $total - $redeemed;
            $percentage = $total > 0 ? ($redeemed / $total) * 100 : 0;

            return [
                'name' => $bonus['name'],
                'total' => $total,
                'redeemed' => $redeemed,
                'remaining' => $remaining,
                'percentage' => round($percentage, 2),
                'source' => $bonus['source'] ?? null,
            ];
        });
    }
}
