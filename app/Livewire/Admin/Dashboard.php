<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use App\Models\Product;
use App\Models\BookingItem;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $dateRange = 'today';

    //metrics
    public $todayRevenue = 0;
    public $monthRevenue = 0;
    public $totalRevenue = 0;
    public $pendingPayments = 0;
    public $todayBookings = 0;
    public $activeBookings = 0;
    public $pendingBookings = 0;
    public $totalCustomers = 0;
    public $newCustomersToday = 0;
    public $availableStockToday = 0;
    public $lowStockAlerts = 0;
    public $totalBookings = 0;


    //charts data
    public $revenueTrendData = [];
    public $bookingStatusData = [];
    public $revenueByProductData = [];
    public $paymentMethodsData = [];

    //lists
    public $recentBookings = [];
    public $upcomingCheckins = [];
    public $pendingPaymentsList = [];
    public $lowStockItems = [];

    public function mount()
    {
        $this->loadMetrics();
        $this->loadChartsData();
        $this->loadLists();
    }

    public function updatedDateRange()
    {
        $this->loadChartsData();
    }

    public function loadMetrics()
    {
        $this->todayRevenue = Payment::where('status', 'settlement')
            ->whereDate('paid_at', today())
            ->sum('amount');

        $this->monthRevenue = Payment::where('status', 'settlement')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $this->totalRevenue = Payment::where('status', 'settlement')->sum('amount');

        $this->pendingPayments = Payment::whereIn('status', ['pending', 'initiated'])
            ->sum('amount');


        //bookings
        $this->todayBookings = Booking::whereDate('created_at', today())->count();

        $this->activeBookings = Booking::whereIn('status', ['paid', 'checked_in', 'completed'])->count();

        $this->pendingBookings = Booking::whereIn('status', ['draft', 'pending_payment'])->count();

        $this->totalBookings = Booking::count();


        //customers
        $this->totalCustomers = User::where('role', 'user')->count();

        $this->newCustomersToday = User::where('role', 'user')
            ->whereDate('created_at', today())
            ->count();

        //stock
        $this->availableStockToday = Availability::where('date', '=', today())
            ->sum('available_unit');

        // $this->lowStockAlerts = Availability::where('date', '>=', today())
        //     ->where('date', '<=', now()->addDays(7))
        //     ->where('available_unit', '<', 3)
        //     // ->where('available_seat', '>', 0)
        //     ->count();

        $query = Availability::where('date', '>=', today())
            ->where('date', '<=', now()->addDays(7));
        $availabilities = $query->with('product')->get();

        $this->lowStockAlerts = $availabilities->filter(fn($a) => $a->isLowStock())->count();
        // dd($this->lowStockAlerts);
    }

    private function loadChartsData()
    {
        $days = match ($this->dateRange) {
            'today' => 1,
            'week' => 7,
            'month' => 30,
            'year' => 365,
            default => 30,
        };



        $revenueTrend = Payment::where('status', 'settlement')
            ->where('paid_at', '>=', now()->subDays($days)->startOfDay())
            ->selectRaw('DATE(paid_at) as date, SUM(amount) as total') // ✅ Change 'amount' to 'total'
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->revenueTrendData = [
            'categories' => $revenueTrend->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $revenueTrend->pluck('total')->toArray(), // ✅ Already correct
        ];

        // dd($this->revenueTrendData);

        $statusCounts = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $this->bookingStatusData = [
            'labels' => $statusCounts->pluck('status')->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))->toArray(),
            'data' => $statusCounts->pluck('count')->toArray(),
        ];

        $revenueByProduct = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->whereIn('bookings.status', ['paid', 'checked_in', 'completed']) // ✅ Include more statuses
            ->where('booking_items.item_type', 'product') // ✅ Only products, not addons
            ->selectRaw('products.name, SUM(booking_items.subtotal) as total')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $this->revenueByProductData = [
            'categories' => $revenueByProduct->pluck('name')->toArray(),
            'data' => $revenueByProduct->pluck('total')->toArray(),
        ];

        $paymentMethods = Payment::where('status', 'settlement')
            ->selectRaw('provider, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('provider')
            ->get();

        $this->paymentMethodsData = [
            'labels' => $paymentMethods->pluck('provider')->map(fn($p) => ucfirst($p))->toArray(),
            'data' => $paymentMethods->pluck('total')->toArray(),
        ];

        // dd($this->paymentMethodsData, $this->bookingStatusData);
    }

    private function loadLists()
    {
        // Recent Bookings (5 latest)
        $this->recentBookings = Booking::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Upcoming Check-ins (Today & Tomorrow)
        $this->upcomingCheckins = Booking::where('status', 'paid')
            ->whereBetween('start_date', [today(), now()->addDay()])
            ->with(['user', 'items.product'])
            ->orderBy('start_date')
            ->limit(10)
            ->get();

        // Pending Payments (Requires Action)
        $this->pendingPaymentsList = Payment::whereIn('status', ['pending', 'initiated'])
            ->with(['booking.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Low Stock Alerts
        $this->lowStockItems = Availability::with('product')
            ->where('date', '>=', today())
            ->where('date', '<=', now()->addDays(7))
            ->get()
            ->filter(fn($a) => $a->isLowStock())
            ->take(5);
    }

    public function refreshData()
    {
        $this->loadMetrics();
        $this->loadChartsData();
        $this->loadLists();

        session()->flash('success', 'Dashboard refreshed!');
    }


    #[Layout('layouts.admin')]

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
