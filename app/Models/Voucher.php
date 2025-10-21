<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
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
        'description',
    ];

    protected $cast =  [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
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
                $q->whereNull('start_at')
                    ->orWhere('start_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('end_at')
                    ->orWhere('end_at', '>=', $now);
            });
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

        return !VoucherRedemption::where('voucher_id' . $this->id)
            ->where('user_id', $userId)
            ->exists();
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

        return $this->redemptions()->count() >= $this->usage_limt;
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
}
