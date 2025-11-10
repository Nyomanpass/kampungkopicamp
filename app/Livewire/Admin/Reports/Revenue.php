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
    public $dateRange = 'month';
    public $startDate;
    public $endDate;
    public $customStartDate;
    public $customEndDate;
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
        $this->setDateRange();
        $this->loadData();
    }

    public function updatedDateRange()
    {
        if ($this->dateRange !== 'custom') {
            $this->setDateRange();
            $this->loadData();
        }
    }

    public function applyCustomDateRange()
    {
        $this->validate([
            'customStartDate' => 'required|date',
            'customEndDate' => 'required|date|after_or_equal:customStartDate',
        ]);

        $this->startDate = $this->customStartDate;
        $this->endDate = $this->customEndDate;
        $this->loadData();
    }

    public function updatedProductFilter()
    {
        $this->loadData();
    }

    private function setDateRange()
    {
        $this->endDate = now()->format('Y-m-d');

        $this->startDate = match ($this->dateRange) {
            'today' => now()->format('Y-m-d'),
            'week' => now()->subWeek()->format('Y-m-d'),
            'month' => now()->subMonth()->format('Y-m-d'),
            'quarter' => now()->subMonths(3)->format('Y-m-d'),
            'year' => now()->subYear()->format('Y-m-d'),
            default => now()->subMonth()->format('Y-m-d'),
        };
    }

    private function loadData()
    {
        $this->loadMetrics();
        $this->loadCharts();
        $this->loadTables();
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
            ->selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $this->dailyRevenueData = [
            'categories' => $dailyRevenue->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray(),
            'data' => $dailyRevenue->pluck('total')->toArray(),
        ];

        // Revenue by Product
        $revenueByProduct = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->whereIn('bookings.status', ['paid', 'checked_in', 'completed'])
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$this->startDate, $this->endDate])
            ->selectRaw('products.name, SUM(booking_items.subtotal) as total')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $this->revenueByProductData = [
            'categories' => $revenueByProduct->pluck('name')->toArray(),
            'data' => $revenueByProduct->pluck('total')->toArray(),
        ];

        // Revenue by Product Type (Glamping vs Touring)
        $revenueByType = BookingItem::join('bookings', 'booking_items.booking_id', '=', 'bookings.id')
            ->join('products', 'booking_items.product_id', '=', 'products.id')
            ->whereIn('bookings.status', ['paid', 'checked_in', 'completed'])
            ->where('booking_items.item_type', 'product')
            ->whereBetween('bookings.created_at', [$this->startDate, $this->endDate])
            ->selectRaw('products.type, SUM(booking_items.subtotal) as total')
            ->groupBy('products.type')
            ->get();

        $this->revenueByProductTypeData = [
            'labels' => $revenueByType->pluck('type')->map(fn($t) => ucfirst($t))->toArray(),
            'series' => $revenueByType->pluck('total')->toArray(),
        ];

        // Payment Method Breakdown
        $paymentMethods = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$this->startDate, $this->endDate])
            ->selectRaw('provider, SUM(amount) as total')
            ->groupBy('provider')
            ->get();

        $this->paymentMethodData = [
            'labels' => $paymentMethods->pluck('provider')->map(fn($p) => ucfirst($p))->toArray(),
            'series' => $paymentMethods->pluck('total')->toArray(),
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
        $data = [
            'title' => 'Revenue Report',
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

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'revenue-report-' . date('Y-m-d-His') . '.pdf');
    }

    public function exportExcel()
    {
        $metrics = [
            'totalRevenue' => $this->totalRevenue,
            'totalTransactions' => $this->totalTransactions,
            'averageTransactionValue' => $this->averageTransactionValue,
            'totalRefunded' => $this->totalRefunded,
            'netRevenue' => $this->netRevenue,
        ];

        $fileName = 'revenue-report-' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new RevenueReportExport($this->topProducts, $metrics, $this->startDate, $this->endDate),
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
