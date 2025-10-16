<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'provider',
        'order_id',
        'payment_code_or_url',
        'amount',
        'status',
        'expired_at',
        'paid_at',
        'raw_payload',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
        'raw_payload' => 'array',
    ];

    // ===== relationships =======
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // ===== scope =======
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSettled($query)
    {
        return $query->where('status', 'settlement');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expire');
    }


    // ========== methods ==========
    public function isSuccess()
    {
        return $this->status === 'settlement';
    }

    public function isPending()
    {
        return in_array($this->status, ['initiated', 'pending']);
    }

    public function isExpired()
    {
        return $this->status === 'expire' ||
            ($this->expired_at && Carbon::now()->isAfter($this->expired_at));
    }

    public function markAsSettled()
    {
        $this->update([
            'status' => 'settlement',
            'paid_at' => now(),
        ]);

        // Update booking status
        $this->booking->update(['status' => 'paid']);
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expire']);

        // Update booking and release availability
        $this->booking->markAsExpired();
    }

    public function markAsCancelled()
    {
        $this->update(['status' => 'cancel']);

        // Update booking
        $this->booking->update(['status' => 'cancelled']);
        $this->booking->releaseAvailability();
    }

    public function markAsRefunded()
    {
        $this->update(['status' => 'refund']);

        // Update booking
        $this->booking->update(['status' => 'refunded']);
        $this->booking->releaseAvailability();
    }

    public function storeWebhookPayload(array $data)
    {
        $this->update([
            'raw_payload' => $data,
        ]);
    }


    public function getPaymentMethod()
    {
        if ($this->raw_payload && isset($this->raw_payload['payment_type'])) {
            return $this->raw_payload['payment_type'];
        }

        return 'Unknown';
    }
}
