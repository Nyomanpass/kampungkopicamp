<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherRedemption;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoucherService
{
    public function validateVoucher($code, $userId, $subtotal)
    {
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return [
                'valid' => false,
                'message' => 'Kode voucher tidak ditemukan.',
            ];
        }

        // Check if voucher is active
        if (!$voucher->is_active) {
            return [
                'valid' => false,
                'message' => 'Voucher ini tidak aktif atau sudah tidak berlaku.',
            ];
        }

        if (!$voucher->isValid()) {
            return [
                'valid' => false,
                'message' => 'Voucher sudah tidak berlaku atau telah mencapai batas penggunaan.',
            ];
        }

        if (!$voucher->canBeUsedBy($userId)) {
            return [
                'valid' => false,
                'message' => 'Anda sudah pernah menggunakan voucher ini.',
            ];
        }

        if ($subtotal < $voucher->min_order) {
            return [
                'valid' => false,
                'message' => 'Minimum pembelian Rp ' . number_format($voucher->min_order, 0, ',', '.') . ' untuk menggunakan voucher ini.',
            ];
        }

        $discount = $voucher->calculateDiscount($subtotal);
        $bonusMeta = $voucher->type === 'bonus' ? $voucher->getBonusMeta() : null;

        return [
            'valid' => true,
            'voucher' => $voucher,
            'discount' => $discount,
            'bonus_meta' => $bonusMeta,
            'message' => $this->getSuccessMessage($voucher, $discount),
        ];
    }

    public function applyVoucher(Booking $booking, Voucher $voucher, $userId)
    {
        try {
            DB::beginTransaction();

            $discount = $voucher->calculateDiscount($booking->subtotal);
            $bonusMeta = $voucher->type === 'bonus' ? $voucher->getBonusMeta() : null;

            // Update booking
            $booking->update([
                'voucher_id' => $voucher->id,
                'discount_amount' => $discount,
                'bonus_meta' => $bonusMeta,
                'total_price' => $booking->subtotal - $discount,
            ]);

            // Create redemption record
            VoucherRedemption::create([
                'voucher_id' => $voucher->id,
                'user_id' => $userId,
                'booking_id' => $booking->id,
                'discount_amount' => $discount,
                'bonus_details' => $bonusMeta,
                'redeemed_at' => now(),
            ]);

            // Increment voucher usage
            $voucher->incrementUsage();

            DB::commit();

            Log::info('Voucher applied successfully', [
                'booking_id' => $booking->id,
                'voucher_code' => $voucher->code,
                'discount' => $discount,
                'has_bonus' => !empty($bonusMeta),
            ]);

            return [
                'success' => true,
                'message' => 'Voucher berhasil diterapkan!',
                'discount' => $discount,
                'bonus_meta' => $bonusMeta,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to apply voucher: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Gagal menerapkan voucher.',
            ];
        }
    }

    public function removeVoucher(Booking $booking)
    {
        try {
            DB::beginTransaction();

            if ($booking->voucher_id) {
                // Decrement voucher usage
                $voucher = Voucher::find($booking->voucher_id);
                if ($voucher) {
                    $voucher->decrement('used_count');
                }

                // Delete redemption record
                VoucherRedemption::where('booking_id', $booking->id)->delete();
            }

            // Reset booking voucher data
            $booking->update([
                'voucher_id' => null,
                'discount_amount' => 0,
                'bonus_meta' => null,
                'total_price' => $booking->subtotal,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Voucher berhasil dihapus.',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to remove voucher: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Gagal menghapus voucher.',
            ];
        }
    }

    private function getSuccessMessage($voucher, $discount)
    {
        if ($voucher->type === 'bonus') {
            return 'Voucher berhasil! Anda mendapatkan bonus: ' . $voucher->name;
        }

        return 'Voucher berhasil! Diskon Rp ' . number_format($discount, 0, ',', '.');
    }
}
