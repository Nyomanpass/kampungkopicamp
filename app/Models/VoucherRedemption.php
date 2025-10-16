<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherRedemption extends Model
{
    protected $fillable = [
        'voucher_id',
        'user_id',
        'booking_id',
        'redeemed_at',
        'discount_value',
    ];

    protected $casts = [
        'redeemed_at' => 'datetime',
        'discount_value' => 'decimal:2',
    ];

    // ===== relationships =======
    public function voucher(){
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
