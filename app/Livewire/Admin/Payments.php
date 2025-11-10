<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class Payments extends Component
{
    use WithPagination;

    // View modes
    public $viewMode = 'list'; // dashboard, list, detail
    public $selectedPaymentId;

    // Filters
    public $search = '';
    public $statusFilter = '';
    public $providerFilter = '';
    public $dateFilter = 'all'; // all, today, week, month, custom
    public $dateFrom = '';
    public $dateTo = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'providerFilter' => ['except' => ''],
        'dateFilter' => ['except' => 'all'],
    ];

    public function mount()
    {
        // Set default date range for custom filter
        $this->dateFrom = now()->subDays(30)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingProviderFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    // View switching
    public function switchToDashboard()
    {
        $this->viewMode = 'dashboard';
    }

    public function switchToList()
    {
        $this->viewMode = 'list';
    }

    public function switchToDetail($paymentId)
    {
        $this->selectedPaymentId = $paymentId;
        $this->viewMode = 'detail';
    }

    // Actions
    public function markAsPaid($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        if ($payment->status !== 'pending') {
            session()->flash('error', 'Only pending payments can be marked as paid!');
            return;
        }

        $payment->update([
            'status' => 'settlement',
            'paid_at' => now(),
        ]);

        // Update booking status
        if ($payment->booking) {
            $payment->booking->update(['status' => 'confirmed']);
        }

        session()->flash('success', 'Payment marked as paid successfully!');
    }

    public function cancelPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        if (!in_array($payment->status, ['pending', 'initiated'])) {
            session()->flash('error', 'Cannot cancel this payment!');
            return;
        }

        $payment->update([
            'status' => 'cancel',
        ]);

        // Update booking status
        if ($payment->booking) {
            $payment->booking->update(['status' => 'cancelled']);
        }

        session()->flash('success', 'Payment cancelled successfully!');
    }

    public function refundPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        if ($payment->status !== 'settlement') {
            session()->flash('error', 'Only paid payments can be refunded!');
            return;
        }

        $payment->update([
            'status' => 'refund',
        ]);

        // Update booking status
        if ($payment->booking) {
            $payment->booking->update(['status' => 'cancelled']);
        }

        session()->flash('success', 'Payment refunded successfully!');
    }

    public function exportPayments()
    {
        // TODO: Implement Excel export
        session()->flash('success', 'Export feature coming soon!');
    }

    public function refreshData()
    {
        $this->reset(['search', 'statusFilter', 'providerFilter', 'dateFilter']);
        session()->flash('success', 'Data refreshed!');
    }

    public function downloadInvoice($paymentId)
    {
        try {
            $payment = Payment::with(['booking.user', 'booking.items'])->findOrFail($paymentId);

            // Get invoice for this payment
            $invoice = Invoice::where('booking_id', $payment->booking_id)
                ->with('items')
                ->first();

            if (!$invoice) {
                session()->flash('error', 'Invoice not found for this payment!');
                return;
            }

            $data = [
                'invoice' => $invoice,
                'payment' => $payment,
                'booking' => $payment->booking,
            ];

            $pdf = Pdf::loadView('pdf.invoice', $data);

            $fileName = 'Invoice-' . $invoice->invoice_number . '-' . date('Ymd') . '.pdf';

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $fileName);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate invoice: ' . $e->getMessage());
            return;
        }
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        // Build query with filters
        $paymentsQuery = Payment::query()
            ->with(['booking.user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('order_id', 'like', "%{$this->search}%")
                        ->orWhereHas('booking.user', function ($userQuery) {
                            $userQuery->where('name', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->providerFilter, fn($q) => $q->where('provider', $this->providerFilter))
            ->when($this->dateFilter === 'today', fn($q) => $q->whereDate('created_at', today()))
            ->when($this->dateFilter === 'week', fn($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($this->dateFilter === 'month', fn($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year))
            ->when($this->dateFilter === 'custom' && $this->dateFrom && $this->dateTo, function ($q) {
                $q->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
            });

        // Get payments for list view
        $payments = (clone $paymentsQuery)->latest()->paginate(20);

        // Statistics
        $stats = [
            'totalRevenue' => Payment::where('status', 'settlement')->sum('amount'),
            'monthRevenue' => Payment::where('status', 'settlement')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'todayRevenue' => Payment::where('status', 'settlement')
                ->whereDate('created_at', today())
                ->sum('amount'),
            'pendingAmount' => Payment::where('status', 'pending')->sum('amount'),
            'totalTransactions' => Payment::count(),
            'successfulTransactions' => Payment::where('status', 'settlement')->count(),
            'successRate' => Payment::count() > 0
                ? (Payment::where('status', 'settlement')->count() / Payment::count()) * 100
                : 0,
            'avgTransaction' => Payment::where('status', 'settlement')->avg('amount') ?? 0,
        ];

        // Status breakdown
        $statusBreakdown = Payment::selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $stats['statusBreakdown'] = $statusBreakdown;

        // Provider stats
        $stats['providerStats'] = Payment::where('status', 'settlement')
            ->selectRaw('provider, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('provider')
            ->orderByDesc('total')
            ->get();

        // Revenue trend (last 7 days)
        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Payment::where('status', 'settlement')
                ->whereDate('created_at', $date)
                ->sum('amount');

            $revenueTrend[] = [
                'date' => $date->format('D'),
                'full_date' => $date->format('Y-m-d'),
                'revenue' => $revenue,
            ];
        }
        $stats['revenueTrend'] = $revenueTrend;

        // Recent payments
        $recentPayments = Payment::with(['booking.user'])
            ->latest()
            ->limit(10)
            ->get();

        // Selected payment for detail view
        $selectedPayment = $this->selectedPaymentId
            ? Payment::with(['booking.user'])->find($this->selectedPaymentId)
            : null;

        return view('livewire.admin.payments', [
            'payments' => $payments,
            'stats' => $stats,
            'recentPayments' => $recentPayments,
            'selectedPayment' => $selectedPayment,
        ]);
    }
}
