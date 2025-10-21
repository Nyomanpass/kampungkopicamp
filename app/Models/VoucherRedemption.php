<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRedemption extends Model
{
    protected $fillable = [
        'voucher_id',
        'user_id',
        'booking_id',
        'discount_amount',
        'bonus_details',
        'redeemed_at',
    ];

    protected $casts = [
        'bonus_details' => 'array',
        'redeemed_at' => 'datetime',
    ];

    // ===== relationships =======
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
