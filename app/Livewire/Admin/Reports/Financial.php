<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FinancialReportExport;

class Financial extends Component
{
    public $dateRange = 'month';
    public $startDate;
    public $endDate;
    public $customStartDate;
    public $customEndDate;
    public $invoiceStatus = '';

    // Metrics
    public $totalInvoices = 0;
    public $totalRevenue = 0;
    public $totalPaid = 0;
    public $totalPending = 0;
    public $totalRefunded = 0;
    public $totalTax = 0;

    // Charts Data
    public $revenueVsExpensesData = [];
    public $invoiceStatusData = [];
    public $paymentMethodsData = [];
    public $monthlyRevenueData = [];

    // Tables Data
    public $recentInvoices = [];
    public $recentPayments = [];
    public $refundedInvoices = [];
    public $outstandingInvoices = [];

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

        $this->startDate = Carbon::parse($this->customStartDate)->startOfDay();
        $this->endDate = Carbon::parse($this->customEndDate)->endOfDay();

        $this->loadData();
    }

    public function updatedInvoiceStatus()
    {
        $this->loadData();
    }

    private function setDateRange()
    {
        $this->endDate = now()->endOfDay();

        $this->startDate = match ($this->dateRange) {
            'today' => now()->startOfDay(),
            'week' => now()->subWeek()->startOfDay(),
            'month' => now()->subMonth()->startOfDay(),
            'quarter' => now()->subMonths(3)->startOfDay(),
            'year' => now()->subYear()->startOfDay(),
            default => now()->subMonth()->startOfDay(),
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
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $query = Invoice::whereBetween('created_at', [$start, $end]);

        if ($this->invoiceStatus) {
            $query->where('status', $this->invoiceStatus);
        }

        // Total Invoices
        $this->totalInvoices = $query->count();

        // Total Revenue (sum of all invoices except credit notes)
        $this->totalRevenue = Invoice::where('type', '!=', 'credit_note')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        // Total Paid (settlement payments)
        $this->totalPaid = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$start, $end])
            ->sum('amount');

        // Total Pending (pending invoices)
        $this->totalPending = Invoice::where('type', '!=', 'credit_note')
            ->where('status', 'pending')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        // Total Refunded (credit notes)
        $this->totalRefunded = Invoice::where('type', 'credit_note')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');
    }

    private function loadCharts()
    {

        // Revenue vs Expenses (Revenue and Refunds comparison)
        $dailyRevenue = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyRefunds = Invoice::where('type', 'credit_note')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Merge dates
        $allDates = $dailyRevenue->pluck('date')
            ->merge($dailyRefunds->pluck('date'))
            ->unique()
            ->sort()
            ->values();

        $revenueData = [];
        $refundData = [];

        foreach ($allDates as $date) {
            $revenueData[] = $dailyRevenue->where('date', $date)->first()->total ?? 0;
            $refundData[] = $dailyRefunds->where('date', $date)->first()->total ?? 0;
        }

        $this->revenueVsExpensesData = [
            'categories' => $allDates->map(fn($d) => Carbon::parse($d)->format('d M'))->toArray(),
            'revenue' => $revenueData,
            'refunds' => $refundData,
        ];


        // Invoice Status Distribution
        $statusCounts = Invoice::where('type', 'primary')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('status')
            ->get();

        $this->invoiceStatusData = [
            'labels' => $statusCounts->pluck('status')->map(fn($s) => ucfirst($s))->toArray(),
            'series' => $statusCounts->pluck('total')->map(fn($v) => (float)$v)->values()->toArray(), // ✅ Convert to float and reindex
        ];

        // dd($this->invoiceStatusData);

        // Payment Methods Breakdown
        $paymentMethods = Payment::where('status', 'settlement')
            ->whereBetween('paid_at', [$this->startDate, $this->endDate])
            ->selectRaw('provider, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('provider')
            ->get();

        $this->paymentMethodsData = [
            'labels' => $paymentMethods->pluck('provider')->map(fn($p) => ucfirst($p))->toArray(),
            'series' => $paymentMethods->pluck('total')->map(fn($v) => (float)$v)->values()->toArray(), // ✅ Convert to float and reindex
        ];


        // dd($this->paymentMethodsData);

        // Monthly Revenue (if range > 1 month)
        if (Carbon::parse($this->startDate)->diffInDays($this->endDate) > 31) {
            // use driver-specific date formatting: strftime for sqlite, DATE_FORMAT for mysql
            $driver = DB::connection()->getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);
            $monthSelect = $driver === 'sqlite'
                ? "strftime('%Y-%m', paid_at) as month"
                : "DATE_FORMAT(paid_at, '%Y-%m') as month";

            $monthlyRevenue = Payment::where('status', 'settlement')
                ->whereBetween('paid_at', [$this->startDate, $this->endDate])
                ->selectRaw($monthSelect . ', SUM(amount) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $this->monthlyRevenueData = [
                'categories' => $monthlyRevenue->pluck('month')->map(fn($m) => Carbon::parse($m . '-01')->format('M Y'))->toArray(),
                'data' => $monthlyRevenue->pluck('total')->toArray(),
            ];
        } else {
            $this->monthlyRevenueData = ['categories' => [], 'data' => []];
        }
    }

    private function loadTables()
    {
        // Recent Invoices
        $this->recentInvoices = Invoice::with(['booking.user'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->limit(10)
            ->get();

        // Recent Payments
        $this->recentPayments = Payment::with(['booking.user'])
            ->where('status', 'settlement')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest('created_at')
            ->limit(10)
            ->get();

        // dd($this->recentPayments);
        // Refunded Invoices (Credit Notes)
        $this->refundedInvoices = Invoice::with(['booking.user'])
            ->where('type', 'credit_note')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->limit(10)
            ->get();

        // Outstanding Invoices (Pending payment)
        $this->outstandingInvoices = Invoice::with(['booking.user'])
            ->where('type', ['primary', 'addon_onsite'])
            ->where('status', 'pending')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->latest()
            ->limit(10)
            ->get();
    }

    public function exportPDF()
    {
        $data = [
            'title' => 'Financial Report',
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'metrics' => [
                'totalInvoices' => $this->totalInvoices,
                'totalRevenue' => $this->totalRevenue,
                'totalPaid' => $this->totalPaid,
                'totalPending' => $this->totalPending,
                'totalRefunded' => $this->totalRefunded,
                'totalTax' => $this->totalTax,
            ],
            'recentInvoices' => $this->recentInvoices,
            'recentPayments' => $this->recentPayments,
            'generatedAt' => now()->format('d M Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.financial-pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'financial-report-' . date('Y-m-d-His') . '.pdf');
    }

    public function exportExcel()
    {
        $metrics = [
            'totalInvoices' => $this->totalInvoices,
            'totalRevenue' => $this->totalRevenue,
            'totalPaid' => $this->totalPaid,
            'totalPending' => $this->totalPending,
            'totalRefunded' => $this->totalRefunded,
            'totalTax' => $this->totalTax,
        ];

        $fileName = 'financial-report-' . date('Y-m-d-His') . '.xlsx';

        return Excel::download(
            new FinancialReportExport($this->recentInvoices, $this->recentPayments, $metrics, $this->startDate, $this->endDate),
            $fileName
        );
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.reports.financial');
    }
}
