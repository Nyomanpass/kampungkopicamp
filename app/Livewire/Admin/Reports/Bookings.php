<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingReportExport;
use Barryvdh\DomPDF\Facade\Pdf;

class Bookings extends Component
{
    public $selectedMonth;
    public $selectedYear;
    public $startDate;
    public $endDate;
    public $statusFilter = '';
    public $productFilter = '';

    // Metrics
    public $totalBookings = 0;
    public $completedBookings = 0;
    public $cancelledBookings = 0;
    public $conversionRate = 0;
    public $averageBookingValue = 0;
    public $noShowRate = 0;

    // Charts Data
    public $dailyBookingsData = [];
    public $bookingStatusData = [];
    public $bookingsByProductData = [];
    public $occupancyRateData = [];

    // Tables Data
    public $topProducts = [];
    public $statusBreakdown = [];
    public $upcomingBookings = [];

    public function mount()
    {
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

    public function updatedStatusFilter()
    {
        $this->loadData();
    }

    public function updatedProductFilter()
    {
        $this->loadData();
    }

    private function setDateRange()
    {
        if ($this->selectedMonth == 0) {
            // All Time - from earliest booking to now
            $earliestBooking = Booking::orderBy('created_at', 'asc')->first();
            $this->startDate = $earliestBooking
                ? Carbon::parse($earliestBooking->created_at)->startOfDay()->format('Y-m-d H:i:s')
                : Carbon::now()->subYears(5)->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        } elseif ($this->selectedMonth == 13) {
            // Full Year - January 1 to December 31 of selected year
            $this->startDate = Carbon::create($this->selectedYear, 1, 1)->startOfDay()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::create($this->selectedYear, 12, 31)->endOfDay()->format('Y-m-d H:i:s');
        } else {
            // Regular monthly filter
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
            13 => 'Tahun Penuh'
        ];

        return $months[$this->selectedMonth] ?? 'Unknown';
    }

    private function loadData()
    {
        $this->loadMetrics();
        $this->loadCharts();
        $this->loadTables();

        // Dispatch event to update charts in JavaScript
        $this->dispatch('chartDataUpdated');
    }

    private function loadMetrics()
    {
        $query = Booking::whereBetween('created_at', [$this->startDate, $this->endDate]);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->productFilter) {
            $query->whereHas('items', function ($q) {
                $q->where('product_id', $this->productFilter);
            });
        }

        $this->totalBookings = $query->count();

        // Completed Bookings
        $this->completedBookings = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'completed')
            ->count();

        // Cancelled Bookings
        $this->cancelledBookings = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->whereIn('status', ['cancelled', 'refunded'])
            ->count();

        // Conversion Rate (paid bookings / total bookings)
        $paidBookings = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->whereIn('status', ['paid', 'checked_in', 'completed'])
            ->count();

        $this->conversionRate = $this->totalBookings > 0
            ? ($paidBookings / $this->totalBookings) * 100
            : 0;

        // Average Booking Value
        $totalValue = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->whereIn('status', ['paid', 'checked_in', 'completed'])
            ->sum('total_price');

        $this->averageBookingValue = $paidBookings > 0
            ? $totalValue / $paidBookings
            : 0;

        // No-Show Rate
        $noShowBookings = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('status', 'no_show')
            ->count();

        $this->noShowRate = $paidBookings > 0
            ? ($noShowBookings / $paidBookings) * 100
            : 0;
    }

    private function loadCharts()
    {
        // Daily Bookings Trend
        $dailyBookings = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->dailyBookingsData = [
            'categories' => $dailyBookings->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $dailyBookings->pluck('count')->toArray(),
        ];

        // Booking Status Distribution
        $statusCounts = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $this->bookingStatusData = [
            'labels' => $statusCounts->pluck('status')->map(fn($s) => ucfirst(str_replace('_', ' ', $s)))->toArray(),
            'data' => $statusCounts->pluck('count')->toArray(),
        ];

        // Bookings by Product
        $bookingsByProduct = DB::table('booking_items')
            ->join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$this->startDate, $this->endDate])
            ->selectRaw('products.name, COUNT(DISTINCT bookings.id) as count')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $this->bookingsByProductData = [
            'categories' => $bookingsByProduct->pluck('name')->toArray(),
            'data' => $bookingsByProduct->pluck('count')->toArray(),
        ];

        // Occupancy Rate (for date range)
        $occupancyData = $this->calculateOccupancyRate();
        $this->occupancyRateData = $occupancyData;
    }

    private function calculateOccupancyRate()
    {
        $products = Product::all();
        $data = [];

        $startDate = Carbon::parse($this->startDate)->startOfDay();
        $endDate = Carbon::parse($this->endDate)->endOfDay();
        $totalDaysInPeriod = $startDate->diffInDays($endDate);

        foreach ($products as $product) {
            // ✅ Method 1: Use product stock as capacity
            $dailyCapacity = $product->stock ?? 10; // Default 10 if not set
            $totalCapacity = $dailyCapacity * $totalDaysInPeriod;

            // ✅ Calculate booked nights
            $bookedNights = DB::table('booking_items')
                ->join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
                ->where('booking_items.product_id', $product->id)
                ->where('booking_items.item_type', 'product')
                ->whereIn('bookings.status', ['paid', 'checked_in', 'completed'])
                ->where(function ($q) use ($startDate, $endDate) {
                    $q->where(function ($q2) use ($startDate, $endDate) {
                        $q2->whereDate('bookings.start_date', '>=', $startDate->format('Y-m-d'))
                            ->whereDate('bookings.start_date', '<=', $endDate->format('Y-m-d'));
                    })->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->whereDate('bookings.end_date', '>=', $startDate->format('Y-m-d'))
                            ->whereDate('bookings.end_date', '<=', $endDate->format('Y-m-d'));
                    })->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->whereDate('bookings.start_date', '<=', $startDate->format('Y-m-d'))
                            ->whereDate('bookings.end_date', '>=', $endDate->format('Y-m-d'));
                    });
                })
                ->selectRaw('
                booking_items.qty,
                DATEDIFF(
                    LEAST(bookings.end_date, ?),
                    GREATEST(bookings.start_date, ?)
                ) as nights
            ', [$endDate->format('Y-m-d'), $startDate->format('Y-m-d')])
                ->get()
                ->sum(function ($item) {
                    return $item->qty * max(0, $item->nights);
                });

            $occupancyRate = $totalCapacity > 0
                ? ($bookedNights / $totalCapacity) * 100
                : 0;

            $data[] = [
                'name' => $product->name,
                'rate' => round($occupancyRate, 1),
            ];
        }

        return collect($data)->sortByDesc('rate')->take(10)->values()->toArray();
    }

    private function loadTables()
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        // Top Products by Bookings
        $this->topProducts = DB::table('booking_items')
            ->join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$start, $end])
            ->selectRaw('
                products.id,
                products.name,
                products.type,
                COUNT(DISTINCT bookings.id) as bookings_count,
                SUM(booking_items.qty) as total_qty
            ')
            ->groupBy('products.id', 'products.name', 'products.type')
            ->orderByDesc('bookings_count')
            ->limit(10)
            ->get();

        // Status Breakdown
        $this->statusBreakdown = Booking::whereBetween('created_at', [$start, $end])
            ->selectRaw('status, COUNT(*) as count, SUM(total_price) as total_value')
            ->groupBy('status')
            ->orderByDesc('count')
            ->get();

        // Upcoming Bookings (next 7 days)
        $this->upcomingBookings = Booking::where('status', 'paid')
            ->whereBetween('start_date', [now(), now()->addWeek()])
            ->with(['user', 'items.product'])
            ->orderBy('start_date')
            ->limit(10)
            ->get();
    }

    public function exportExcel()
    {
        $this->loadTables();
        $metrics = [
            'totalBookings' => $this->totalBookings,
            'completedBookings' => $this->completedBookings,
            'cancelledBookings' => $this->cancelledBookings,
            'conversionRate' => $this->conversionRate,
            'averageBookingValue' => $this->averageBookingValue,
            'noShowRate' => $this->noShowRate,
        ];

        // Generate filename based on period type
        if ($this->selectedMonth == 0) {
            $fileName = 'laporan-booking-keseluruhan.xlsx';
        } elseif ($this->selectedMonth == 13) {
            $fileName = 'laporan-booking-tahun-' . $this->selectedYear . '.xlsx';
        } else {
            $fileName = 'laporan-booking-' . strtolower($this->monthName) . '-' . $this->selectedYear . '.xlsx';
        }

        return Excel::download(
            new BookingReportExport($this->topProducts, $this->statusBreakdown, $metrics, $this->startDate, $this->endDate, $this->monthName, $this->selectedYear),
            $fileName
        );
    }

    public function exportPDF()
    {
        $this->loadTables();

        $data = [
            'title' => 'Laporan Booking',
            'month' => $this->monthName,
            'year' => $this->selectedYear,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'metrics' => [
                'totalBookings' => $this->totalBookings,
                'completedBookings' => $this->completedBookings,
                'cancelledBookings' => $this->cancelledBookings,
                'conversionRate' => $this->conversionRate,
                'averageBookingValue' => $this->averageBookingValue,
                'noShowRate' => $this->noShowRate,
            ],
            'topProducts' => $this->topProducts,
            'statusBreakdown' => $this->statusBreakdown,
            'generatedAt' => now()->format('d M Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.booking-pdf', $data)
            ->setPaper('a4', 'portrait');

        // Generate filename based on period type
        if ($this->selectedMonth == 0) {
            $fileName = 'laporan-booking-keseluruhan.pdf';
        } elseif ($this->selectedMonth == 13) {
            $fileName = 'laporan-booking-tahun-' . $this->selectedYear . '.pdf';
        } else {
            $fileName = 'laporan-booking-' . strtolower($this->monthName) . '-' . $this->selectedYear . '.pdf';
        }

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName);
    }



    #[Layout('layouts.admin')]
    public function render()
    {
        $products = Product::orderBy('name')->get();

        return view('livewire.admin.reports.bookings', [
            'products' => $products,
        ]);
    }
}
