<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\Booking;
use App\Models\VoucherRedemption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $openDisplayProducts = false;
    public $activeTab = 'accommodation';

    // Dashboard data properties
    public $welcomeVoucher = null;
    public $showWelcomeSection = false;
    public $popularProducts = [];
    public $accommodationProducts = [];
    public $touringProducts = [];
    public $areaProducts = [];
    public $latestBookings = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Check if user should see welcome voucher section
        $this->checkWelcomeSection();

        // Load popular products (for mobile display)
        $this->popularProducts = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Load products by type (for desktop display)
        $this->accommodationProducts = Product::where('is_active', true)
            ->where('type', 'accommodation')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $this->touringProducts = Product::where('is_active', true)
            ->where('type', 'touring')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $this->areaProducts = Product::where('is_active', true)
            ->where('type', 'area_rental')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Load latest 3 completed bookings
        $this->latestBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();
    }

    public function checkWelcomeSection()
    {
        $user = Auth::user();
        $twoDaysAgo = Carbon::now()->subDays(2);

        // Check if user registered within last 2 days
        if ($user->created_at >= $twoDaysAgo) {
            // Check for WELCOME10 voucher
            $welcomeVoucher = Voucher::where('code', 'WELCOME10')
                ->where('is_active', true)
                ->first();

            if ($welcomeVoucher) {
                // Check if user has already claimed it
                $alreadyClaimed = VoucherRedemption::where('voucher_id', $welcomeVoucher->id)
                    ->where('user_id', $user->id)
                    ->exists();

                if (!$alreadyClaimed) {
                    $this->showWelcomeSection = true;
                    $this->welcomeVoucher = $welcomeVoucher;
                }
            }
        }
    }

    public function claimVoucher()
    {
        if (!$this->welcomeVoucher) {
            session()->flash('error', 'Voucher tidak tersedia');
            return;
        }

        // Check if voucher still has remaining uses
        $currentRedemptions = VoucherRedemption::where('voucher_id', $this->welcomeVoucher->id)->count();

        if ($currentRedemptions >= $this->welcomeVoucher->usage_limit) {
            session()->flash('error', 'Voucher sudah habis digunakan');
            $this->showWelcomeSection = false;
            return;
        }

        // Create redemption record
        VoucherRedemption::create([
            'voucher_id' => $this->welcomeVoucher->id,
            'user_id' => Auth::id(),
            'redeemed_at' => now(),
        ]);

        session()->flash('success', 'Voucher berhasil diklaim! Gunakan kode: ' . $this->welcomeVoucher->code);
        $this->showWelcomeSection = false;
        $this->welcomeVoucher = null;
    }

    public function toggleDisplayProducts($tab = 'accommodation')
    {
        $this->openDisplayProducts = !$this->openDisplayProducts;
        $this->activeTab = $tab;
    }

    public function openProducts($tab)
    {
        $this->openDisplayProducts = true;
        $this->activeTab = $tab;
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.dashboard');
    }
}
