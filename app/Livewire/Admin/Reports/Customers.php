<?php
// filepath: app/Livewire/Admin/Reports/Customers.php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerReportExport;
use Barryvdh\DomPDF\Facade\Pdf;

class Customers extends Component
{
    public $selectedMonth;
    public $monthName;
    public $selectedYear;
    public $startDate;
    public $endDate;

    // Metrics
    public $totalCustomers = 0;
    public $newCustomers = 0;
    public $returningCustomers = 0;
    public $activeCustomers = 0;
    public $customerRetentionRate = 0;
    public $averageLifetimeValue = 0;

    // Charts Data
    public $newCustomersTrendData = [];
    public $customersBySourceData = [];
    public $topCustomersData = [];
    public $customerActivityData = [];

    // Tables Data
    public $topSpenders = [];
    public $recentCustomers = [];
    public $customerSegments = [];

    public function mount()
    {
        // Set default to current month and year
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->setDateRange();
        $this->loadData();
    }

    public function updatedSelectedMonth()
    {
        $this->setDateRange();
        $this->loadData();
    }

    public function updatedSelectedYear()
    {
        $this->setDateRange();
        $this->loadData();
    }

    private function setDateRange()
    {
        // Check for special values: 0 = All Time, 13 = Full Year
        if ($this->selectedMonth == 0) {
            // All Time - get earliest user registration date
            $earliestUser = User::where('role', 'user')
                ->orderBy('created_at', 'asc')
                ->first();

            $this->startDate = $earliestUser
                ? Carbon::parse($earliestUser->created_at)->startOfDay()->format('Y-m-d H:i:s')
                : Carbon::now()->subYears(5)->startOfDay()->format('Y-m-d H:i:s');

            $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        } elseif ($this->selectedMonth == 13) {
            // Full Year - January to December of selected year
            $this->startDate = Carbon::create($this->selectedYear, 1, 1)->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::create($this->selectedYear, 12, 31)->endOfDay()->format('Y-m-d H:i:s');
        } else {
            // Specific month
            $this->startDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s');
        }
    }

    public function getMonthNameProperty()
    {
        $months = [
            0 => 'Keseluruhan',
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
            13 => '1 Tahun Penuh',
        ];

        return $months[$this->selectedMonth] ?? 'Unknown';
    }

    private function loadData()
    {
        $this->loadMetrics();
        $this->loadCharts();
        $this->loadTables();
    }

    private function loadMetrics()
    {
        // Total Customers (all time)
        $this->totalCustomers = User::where('role', 'user')->count();

        // New Customers (in date range)
        $this->newCustomers = User::where('role', 'user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->count();

        // Active Customers (made booking in date range)
        $this->activeCustomers = User::where('role', 'user')
            ->whereHas('bookings', function ($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->count();

        // Returning Customers (made more than 1 booking)
        $this->returningCustomers = User::where('role', 'user')
            ->whereHas('bookings', function ($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }, '>', 1)
            ->count();

        // Customer Retention Rate
        $this->customerRetentionRate = $this->activeCustomers > 0
            ? ($this->returningCustomers / $this->activeCustomers) * 100
            : 0;

        // Average Lifetime Value (total revenue / total customers with bookings)
        $totalRevenue = Payment::where('status', 'settlement')->sum('amount');
        $customersWithBookings = User::where('role', 'user')
            ->whereHas('bookings')
            ->count();

        $this->averageLifetimeValue = $customersWithBookings > 0
            ? $totalRevenue / $customersWithBookings
            : 0;
    }

    private function loadCharts()
    {
        // New Customers Trend
        $newCustomersTrend = User::where('role', 'user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->newCustomersTrendData = [
            'categories' => $newCustomersTrend->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $newCustomersTrend->pluck('count')->toArray(),
        ];

        // Customers by Registration Source (if you have source field)
        // For now, we'll create dummy data or use email domain
        $customersByDomain = User::where('role', 'user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get()
            ->groupBy(function ($user) {
                return explode('@', $user->email)[1] ?? 'Unknown';
            })
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(5);

        $this->customersBySourceData = [
            'labels' => $customersByDomain->keys()->toArray(),
            'series' => $customersByDomain->values()->toArray(),
        ];

        // Customer Activity (bookings per customer)
        $customerActivity = User::where('role', 'user')
            ->whereHas('bookings')
            ->withCount(['bookings' => function ($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }])
            ->get()
            ->groupBy(function ($user) {
                if ($user->bookings_count == 0) return '0 bookings';
                if ($user->bookings_count == 1) return '1 booking';
                if ($user->bookings_count <= 3) return '2-3 bookings';
                if ($user->bookings_count <= 5) return '4-5 bookings';
                return '6+ bookings';
            })
            ->map(fn($group) => $group->count());

        $this->customerActivityData = [
            'labels' => $customerActivity->keys()->toArray(),
            'series' => $customerActivity->values()->toArray(),
        ];
    }

    private function loadTables()
    {
        // Top Spenders (by total booking value)
        $this->topSpenders = User::where('role', 'user')
            ->whereHas('bookings')
            ->withSum(['bookings as total_spent' => function ($q) {
                $q->whereIn('status', ['paid', 'checked_in', 'completed']);
            }], 'total_price')
            ->withCount(['bookings as total_bookings' => function ($q) {
                $q->whereIn('status', ['paid', 'checked_in', 'completed']);
            }])
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // Recent Customers
        $this->recentCustomers = User::where('role', 'user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->withCount('bookings')
            ->withSum(['bookings as total_spent' => function ($q) {
                $q->whereIn('status', ['paid', 'checked_in', 'completed']);
            }], 'total_price')
            ->withCount(['bookings as total_bookings' => function ($q) {
                $q->whereIn('status', ['paid', 'checked_in', 'completed']);
            }])
            ->latest()
            ->limit(10)
            ->get();

        // Customer Segments
        $this->customerSegments = [
            [
                'name' => 'Customer Baru',
                'description' => '1st time booking',
                'count' => User::where('role', 'user')
                    ->whereHas('bookings', function ($q) {}, '=', 1)
                    ->count(),
                'color' => 'info',
            ],
            [
                'name' => 'Customer Regular',
                'description' => '2-5 bookings',
                'count' => User::where('role', 'user')
                    ->whereHas('bookings', function ($q) {}, '>=', 2)
                    ->whereHas('bookings', function ($q) {}, '<=', 5)
                    ->count(),
                'color' => 'light-primary',
            ],
            [
                'name' => 'Customer VIP',
                'description' => '6+ bookings',
                'count' => User::where('role', 'user')
                    ->whereHas('bookings', function ($q) {}, '>=', 6)
                    ->count(),
                'color' => 'status-expired',
            ],
            [
                'name' => 'Customer Tidak Aktif',
                'description' => 'No bookings in 90 days',
                'count' => User::where('role', 'user')
                    ->whereDoesntHave('bookings', function ($q) {
                        $q->where('created_at', '>=', now()->subDays(90));
                    })
                    ->count(),
                'color' => 'status-noshow',
            ],
        ];
    }

    public function exportPDF()
    {
        $this->loadTables();
        $data = [
            'title' => 'Customer Report',
            'monthName' => $this->monthName,
            'year' => $this->selectedYear,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'metrics' => [
                'totalCustomers' => $this->totalCustomers,
                'newCustomers' => $this->newCustomers,
                'activeCustomers' => $this->activeCustomers,
                'returningCustomers' => $this->returningCustomers,
                'customerRetentionRate' => $this->customerRetentionRate,
                'averageLifetimeValue' => $this->averageLifetimeValue,
            ],
            'topSpenders' => $this->topSpenders,
            'recentCustomers' => $this->recentCustomers,
            'generatedAt' => now()->format('d M Y H:i:s'),
        ];

        $pdf = Pdf::loadView('reports.customer-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'customer-report-' . date('Y-m-d-His') . '.pdf');
    }

    public function exportExcel()
    {
        $this->loadTables();

        $metrics = [
            'totalCustomers' => $this->totalCustomers,
            'newCustomers' => $this->newCustomers,
            'activeCustomers' => $this->activeCustomers,
            'returningCustomers' => $this->returningCustomers,
            'customerRetentionRate' => $this->customerRetentionRate,
            'averageLifetimeValue' => $this->averageLifetimeValue,
        ];

        $fileName = 'customer-report-' . $this->monthName . '-' . $this->selectedYear . '.xlsx';

        return Excel::download(
            new CustomerReportExport($this->topSpenders, $this->recentCustomers, $metrics, $this->startDate, $this->endDate),
            $fileName
        );
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.reports.customers');
    }
}
