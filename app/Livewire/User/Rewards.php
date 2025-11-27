<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Voucher;
use Carbon\Carbon;

class Rewards extends Component
{
    public $dashboardVouchers = [];

    public function mount()
    {
        $this->loadVouchers();
    }

    public function loadVouchers()
    {
        $now = Carbon::now();

        // Get vouchers yang di-set untuk ditampilkan di dashboard
        $this->dashboardVouchers = Voucher::where('is_active', true)
            ->where('show_in_dashboard', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', $now);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function copyCode($code)
    {
        $this->dispatch('code-copied');
    }

    public function getRemainingUses($voucher)
    {
        if (is_null($voucher->usage_limit)) {
            return null; // Unlimited
        }

        $currentRedemptions = \App\Models\VoucherRedemption::where('voucher_id', $voucher->id)->count();
        return max(0, $voucher->usage_limit - $currentRedemptions);
    }

    public function getProgressPercentage($voucher)
    {
        if (is_null($voucher->usage_limit)) {
            return 0;
        }

        $currentRedemptions = \App\Models\VoucherRedemption::where('voucher_id', $voucher->id)->count();
        return min(100, ($currentRedemptions / $voucher->usage_limit) * 100);
    }

    public function hasUserRedeemed($voucher)
    {
        return \App\Models\VoucherRedemption::where('voucher_id', $voucher->id)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->exists();
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.rewards');
    }
}
