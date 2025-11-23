<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Voucher extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_order',
        'max_discount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'show_in_dashboard',
        'description',
    ];

    protected $casts =  [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'show_in_dashboard' => 'boolean',
    ];

    // ========== relationships ==========

    public function redemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ========== scope ==========
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhere('used_count < usage_limit');
            });
    }

    public function scopeValid($query)
    {
        $now = now()->toDateString();
        return $query->active()
            ->where(function ($q) use ($now) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            });
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('end_date')
            ->where('end_date', '<', now());
    }

    public function scopeScheduled($query)
    {
        return $query->whereNotNull('start_date')
            ->where('start_date', '>', now());
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // ========== methods ==========
    public function isValid()
    {
        return $this->is_active
            && $this->start_date <= now()
            && $this->end_date >= now()
            && ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function canBeUsedBy($userId)
    {
        if (!$this->isValid()) {
            return false;
        }

        if (is_null($this->user_usage_limit)) {
            return true; // No per-user limit
        }

        $userUsageCount = $this->redemptions()
            ->where('user_id', $userId)
            ->count();

        return $userUsageCount < $this->user_usage_limit;
    }

    public function calculateDiscount($subtotal)
    {
        if ($this->type === 'bonus') {
            return 0; // Bonus tidak ada discount
        }

        if ($subtotal < $this->min_order) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($subtotal * $this->value) / 100;

            if ($this->max_discount && $discount > $this->max_discount) {
                return $this->max_discount;
            }

            return (int) $discount;
        }

        // Fixed discount
        return min($this->value, $subtotal);
    }

    public function getBonusMeta()
    {
        if ($this->type !== 'bonus') {
            return null;
        }

        return [
            [
                'name' => $this->name,
                'qty_total' => $this->value, // value = jumlah bonus
                'qty_redeemed' => 0,
                'source' => 'voucher:' . $this->code,
            ]
        ];
    }


    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    public function isValidDate()
    {
        $now = Carbon::now()->toDateString();

        if ($this->start_at && $now < $this->start_at->toDateString()) {
            return false;
        }

        if ($this->end_at && $now > $this->end_at->toDateString()) {
            return false;
        }

        return true;
    }

    public function hasReachedLimit()
    {
        if ($this->usage_limit == 0) {
            return false;
        }
        return $this->redemptions()->count() >= $this->usage_limit;
    }



    public function applyToBooking(Booking $booking, $userId = null)
    {
        if (!$this->canBeUsedBy($userId)) {
            throw new \Exception('Voucher tidak dapat digunakan.');
        }

        $discount = $this->calculateDiscount($booking);

        if ($discount <= 0 && $this->type !== 'addon_bonus') {
            throw new \Exception('Booking tidak memenuhi syarat minimum voucher.');
        }

        // Update booking
        $booking->discount_total = $discount;
        $booking->calculateTotal();

        // Create redemption record
        VoucherRedemption::create([
            'voucher_id' => $this->id,
            'user_id' => $userId ?? $booking->user_id,
            'booking_id' => $booking->id,
            'discount_value' => $discount,
        ]);

        return $discount;
    }

    public function getRemainingUsage()
    {
        if ($this->usage_limit == 0) {
            return 'Unlimited';
        }

        $used = $this->redemptions()->count();
        return max(0, $this->usage_limit - $used);
    }


    /**
     * Get formatted discount value
     */
    public function getFormattedValueAttribute(): string
    {
        return match ($this->type) {
            'percentage' => $this->value . '%',
            'fixed' => 'Rp ' . number_format($this->value, 0, ',', '.'),
            'bonus' => $this->value . ' item(s)',
            default => $this->value,
        };
    }

    /**
     * Get type label
     */
    public function getTypeLabel(): string
    {
        return match ($this->type) {
            'percentage' => 'Percentage Discount',
            'fixed' => 'Fixed Amount',
            'bonus' => 'Bonus Item',
            default => ucfirst($this->type),
        };
    }

    /**
     * Get type icon
     */
    public function getTypeIcon(): string
    {
        return match ($this->type) {
            'percentage' => 'fa-percent',
            'fixed' => 'fa-dollar-sign',
            'bonus' => 'fa-gift',
            default => 'fa-tag',
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColor(): string
    {
        if (!$this->is_active) {
            return 'gray'; // Inactive
        }

        $now = now();

        // Scheduled (not started yet)
        if ($this->start_date && $now->lt($this->start_date)) {
            return 'yellow';
        }

        // Expired
        if ($this->end_date && $now->gt($this->end_date)) {
            return 'red';
        }

        // Usage limit reached
        if ($this->hasReachedLimit()) {
            return 'orange';
        }

        // Active
        return 'green';
    }

    /**
     * Get status label
     */
    public function getStatusLabel(): string
    {
        if (!$this->is_active) {
            return 'Inactive';
        }

        $now = now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return 'Scheduled';
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return 'Expired';
        }

        if ($this->hasReachedLimit()) {
            return 'Full';
        }

        return 'Active';
    }

    /**
     * Get remaining uses
     */
    public function getRemainingUses(): ?int
    {
        if (is_null($this->usage_limit)) {
            return null; // Unlimited
        }

        $used = $this->redemptions()->count();
        return max(0, $this->usage_limit - $used);
    }

    /**
     * Get usage percentage
     */
    public function getUsagePercentage(): float
    {
        if (is_null($this->usage_limit)) {
            return 0;
        }

        $used = $this->redemptions()->count();
        return ($used / $this->usage_limit) * 100;
    }

    /**
     * Check if voucher is expired
     */
    public function isExpired(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return now()->gt($this->end_date);
    }

    /**
     * Check if voucher is scheduled (not started yet)
     */
    public function isScheduled(): bool
    {
        if (!$this->start_date) {
            return false;
        }

        return now()->lt($this->start_date);
    }

    /**
     * Get days until expiration
     */
    public function getDaysUntilExpiration(): ?int
    {
        if (!$this->end_date) {
            return null;
        }

        $now = now();

        if ($now->gt($this->end_date)) {
            return 0;
        }

        return $now->diffInDays($this->end_date);
    }

    /**
     * Redeem voucher for user
     */
    public function redeem($userId, $bookingId, float $discountAmount): bool
    {
        if (!$this->canBeUsedBy($userId)) {
            return false;
        }

        VoucherRedemption::create([
            'voucher_id' => $this->id,
            'user_id' => $userId,
            'booking_id' => $bookingId,
            'discount_amount' => $discountAmount,
            'redeemed_at' => now(),
        ]);

        return true;
    }
}
