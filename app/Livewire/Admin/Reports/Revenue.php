<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\BookingItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RevenueReportExport;

class Revenue extends Component
{
    public $selectedMonth;
    public $selectedYear;
    public $startDate;
    public $endDate;
    public $productFilter = '';

    // Metrics
    public $totalRevenue = 0;
    public $totalTransactions = 0;
    public $averageTransactionValue = 0;
    public $totalRefunded = 0;
    public $netRevenue = 0;

    // Charts Data
    public $dailyRevenueData = [];
    public $revenueByProductData = [];
    public $revenueByProductTypeData = [];
    public $paymentMethodData = [];

    // Tables Data
    public $topProducts = [];
    public $revenueByMonth = [];

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

    public function updatedProductFilter()
    {
        $this->loadData();
    }

    private function setDateRange()
    {
        // Check for special values: 0 = All Time, 13 = Full Year
        if ($this->selectedMonth == 0) {
            // All Time - get earliest payment date
            $earliestPayment = Payment::where('status', 'settlement')
                ->orderBy('paid_at', 'asc')
                ->first();

            $this->startDate = $earliestPayment
                ? Carbon::parse($earliestPayment->paid_at)->startOfDay()->format('Y-m-d H:i:s')
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
            13 => 'Tahun Penuh'
        ];
        return $months[$this->selectedMonth] ?? '';
    }

    private function loadData()
    {
        $this->loadMetrics();
        $this->loadCharts();
        $this->loadTables();

        // Dispatch event to update charts
        $this->dispatch('chartDataUpdated');
    }

    private function loadMetrics()
    {
        // Total Revenue (settlement payments)
        $query = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$this->startDate, $this->endDate]);

        if ($this->productFilter) {
            $query->whereHas('booking.items', function ($q) {
                $q->where('product_id', $this->productFilter);
            });
        }

        $this->totalRevenue = $query->sum('amount');
        $this->totalTransactions = $query->count();

        // Average Transaction Value
        $this->averageTransactionValue = $this->totalTransactions > 0
            ? $this->totalRevenue / $this->totalTransactions
            : 0;

        // Total Refunded (credit notes)
        $this->totalRefunded = \App\Models\Invoice::where('type', 'credit_note')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('amount');

        // Net Revenue
        $this->netRevenue = $this->totalRevenue - $this->totalRefunded;
    }

    private function loadCharts()
    {
        // Daily Revenue Trend
        $dailyRevenue = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$this->startDate, $this->endDate])
            ->when($this->productFilter, function ($q) {
                $q->whereHas('booking.items', function ($subQ) {
                    $subQ->where('product_id', $this->productFilter);
                });
            })
            ->selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->dailyRevenueData = [
            'categories' => $dailyRevenue->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $dailyRevenue->pluck('total')->toArray(),
        ];

        // Revenue by Product (Top 10)
        $revenueByProduct = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->whereIn('bookings.status', ['paid', 'checked_in', 'completed'])
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$this->startDate, $this->endDate])
            ->when($this->productFilter, function ($q) {
                $q->where('products.id', $this->productFilter);
            })
            ->selectRaw('products.name, SUM(booking_items.subtotal) as total')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $this->revenueByProductData = [
            'categories' => $revenueByProduct->pluck('name')->toArray(),
            'data' => $revenueByProduct->pluck('total')->toArray(),
        ];

        // Revenue by Product Type (Bar Chart)
        $revenueByType = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->whereIn('bookings.status', ['paid', 'checked_in', 'completed'])
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$this->startDate, $this->endDate])
            ->when($this->productFilter, function ($q) {
                $q->where('products.id', $this->productFilter);
            })
            ->selectRaw('products.type, SUM(booking_items.subtotal) as total')
            ->groupBy('products.type')
            ->get();

        $this->revenueByProductTypeData = [
            'categories' => $revenueByType->pluck('type')->map(fn($t) => ucfirst(str_replace('_', ' ', $t)))->toArray(),
            'data' => $revenueByType->pluck('total')->toArray(),
        ];

        // Payment Method Breakdown (Bar Chart)
        $paymentMethods = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$this->startDate, $this->endDate])
            ->when($this->productFilter, function ($q) {
                $q->whereHas('booking.items', function ($subQ) {
                    $subQ->where('product_id', $this->productFilter);
                });
            })
            ->selectRaw('provider, SUM(amount) as total')
            ->groupBy('provider')
            ->get();

        $this->paymentMethodData = [
            'categories' => $paymentMethods->pluck('provider')->map(fn($p) => ucfirst($p))->toArray(),
            'data' => $paymentMethods->pluck('total')->toArray(),
        ];
    }

    private function loadTables()
    {
        // Top Products by Revenue
        $this->topProducts = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->whereIn('bookings.status', ['paid', 'checked_in', 'completed'])
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$this->startDate, $this->endDate])
            ->selectRaw('
                products.id,
                products.name,
                products.type,
                COUNT(DISTINCT bookings.id) as bookings_count,
                SUM(booking_items.qty) as total_qty,
                SUM(booking_items.subtotal) as total_revenue
            ')
            ->groupBy('products.id', 'products.name', 'products.type')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Revenue by Month (if range > 1 month)
        if (Carbon::parse($this->startDate)->diffInDays($this->endDate) > 31) {
            $this->revenueByMonth = Payment::where('status', 'settlement')
                ->whereBetween('paid_at', [$this->startDate, $this->endDate])
                ->selectRaw('
                    DATE_FORMAT(paid_at, "%Y-%m") as month,
                    COUNT(*) as transactions,
                    SUM(amount) as revenue
                ')
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $this->revenueByMonth = collect();
        }
    }

    public function exportPDF()
    {
        $this->loadTables();

        $data = [
            'title' => 'Laporan Pendapatan',
            'month' => $this->monthName,
            'year' => $this->selectedYear,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'metrics' => [
                'totalRevenue' => $this->totalRevenue,
                'totalTransactions' => $this->totalTransactions,
                'averageTransactionValue' => $this->averageTransactionValue,
                'totalRefunded' => $this->totalRefunded,
                'netRevenue' => $this->netRevenue,
            ],
            'topProducts' => $this->topProducts,
            'generatedAt' => now()->format('d M Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.revenue-pdf', $data)
            ->setPaper('a4', 'portrait');

        // Generate filename based on period type
        if ($this->selectedMonth == 0) {
            $fileName = 'laporan-pendapatan-keseluruhan.pdf';
        } elseif ($this->selectedMonth == 13) {
            $fileName = 'laporan-pendapatan-tahun-' . $this->selectedYear . '.pdf';
        } else {
            $fileName = 'laporan-pendapatan-' . strtolower($this->monthName) . '-' . $this->selectedYear . '.pdf';
        }

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName);
    }

    public function exportExcel()
    {
        $this->loadTables();
        $metrics = [
            'totalRevenue' => $this->totalRevenue,
            'totalTransactions' => $this->totalTransactions,
            'averageTransactionValue' => $this->averageTransactionValue,
            'totalRefunded' => $this->totalRefunded,
            'netRevenue' => $this->netRevenue,
        ];

        // Generate filename based on period type
        if ($this->selectedMonth == 0) {
            $fileName = 'laporan-pendapatan-keseluruhan.xlsx';
        } elseif ($this->selectedMonth == 13) {
            $fileName = 'laporan-pendapatan-tahun-' . $this->selectedYear . '.xlsx';
        } else {
            $fileName = 'laporan-pendapatan-' . strtolower($this->monthName) . '-' . $this->selectedYear . '.xlsx';
        }

        return Excel::download(
            new RevenueReportExport($this->topProducts, $metrics, $this->startDate, $this->endDate, $this->monthName, $this->selectedYear),
            $fileName
        );
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $products = Product::orderBy('name')->get();

        return view('livewire.admin.reports.revenue', [
            'products' => $products,
        ]);
    }
}
