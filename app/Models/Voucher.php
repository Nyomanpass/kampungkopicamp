<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_night',
        'min_total',
        'start_date',
        'end_date',
        'usage_limit',
        'scope',
        'is_active',
    ];

    protected $cast =  [
        'value' => 'decimal:2',
        'min_total' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // ========== relationships ==========

    public function redemptions()
    {
        return $this->hasMany(VoucherRedemption::class);
    }

    // ========== scope ==========
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = now()->toDateString();
        return $query->active()
        ->where(function($q) use ($now) {
            $q->whereNull('start_at')
            ->orWhere('start_at', '<=', $now);
        })
        ->where(function($q) use ($now){
            $q->whereNull('end_at')
            ->orWhere('end_at', '>=', $now);
        });
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // ========== methods ==========
    public function isValidDate()
    {
        $now = Carbon::now()->toDateString();
        
        if($this->start_at && $now < $this->start_at->toDateString()){
            return false;
        }

        if($this->end_at && $now > $this->end_at->toDateString()){
            return false;
        }

        return true;
    }

    public function hasReachedLimit()
    {
        if($this->usage_limit == 0){
            return false;
        }

        return $this->redemptions()->count() >= $this->usage_limt;
    }

    public function canBeUsedBy($userId = null){
        if(!$this->is_active){
            return false;
        }

        if(!$this->isValidDate()){
            return false;
        }

        if($this->hasReachedLimit()){
            return false;
        }

        if($this->scope == 'registered_only' && !$userId){
            return false;
        }

        return true;
    }

    public function calculateDiscount(Booking $booking){
        if($booking->product_type === 'accomodation'){
            $nights = $booking->getTotalNights();
            if($nights < $this->min_night){
                return 0;
            }
        }

        if($booking->subtotal < $this->min_total){
            return 0;
        }

        switch($this->type){
            case 'percent':
                return $booking->subtotal * ($this->value / 100);
            case 'amount':
                return min($this->value, $booking->subtotal);
            case 'addon_bonus':
                // handled elsewhere
                return 0;
            default:
                return 0;
        }
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
