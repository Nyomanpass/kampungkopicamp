<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class MyBooking extends Component
{
    public $statusFilter = '';
    public $typeFilter = '';
    public $bookings = [];

    // Status options for filter
    public $statusOptions = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'checked_in' => 'Checked In',
        'checked_out' => 'Checked Out',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'no_show' => 'No Show',
        'expired' => 'Expired',
        'refunded' => 'Refunded'
    ];

    // Type options for filter
    public $typeOptions = [
        'accommodation' => 'Accommodation',
        'touring' => 'Touring',
        'area_rental' => 'Area Rental'
    ];

    public function mount()
    {
        $this->loadBookings();
    }

    public function loadBookings()
    {
        $query = Booking::where('user_id', Auth::id())
            ->with([
                'items' => function ($query) {
                    $query->with(['product', 'addon']); // Load both relations
                },
                'payments',
                'items.product',
                'voucher'
            ])
            ->orderBy('created_at', 'desc');

        // Apply status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Apply type filter (based on product type)
        if ($this->typeFilter) {
            $query->whereHas('items.product', function ($q) {
                $q->where('type', $this->typeFilter);
            });
        }

        $this->bookings = $query->get();
    }

    public function updatedStatusFilter()
    {
        $this->loadBookings();
    }

    public function updatedTypeFilter()
    {
        $this->loadBookings();
    }

    public function resetFilters()
    {
        $this->statusFilter = '';
        $this->typeFilter = '';
        $this->loadBookings();
    }

    public function getProductIcon($type)
    {
        return match ($type) {
            'accommodation' => 'fa-campground',
            'touring' => 'fa-person-hiking',
            'area_rental' => 'fa-tree',
            default => 'fa-box'
        };
    }

    public function getStatusColor($status)
    {
        return match ($status) {
            'completed' => 'bg-status-completed-bg text-status-completed',
            'paid' => 'bg-success/20 text-success',
            'checked_in' => 'bg-status-checkedin-bg text-status-checkedin',
            'pending_payment' => 'bg-warning/20 text-warning',
            'cancelled', => 'bg-status-cancelled-bg text-status-cancelled',
            'no_show' => 'bg-status-noshow-bg text-status-noshow',
            'expired' => 'bg-status-expired-bg text-status-expired',
            'refunded' => 'bg-status-refunded-bg text-status-refunded',
            default => 'bg-status-draft-bg text-status-draft',
        };
    }

    public function downloadInvoice($bookingId)
    {
        $payment = Payment::where('booking_id', $bookingId)->first();
        $invoice = Invoice::where('booking_id', $payment->booking_id)
            ->with('items')
            ->first();
        $booking = Booking::with('invoices')->findOrFail($bookingId);

        if (!$invoice) {
            session()->flash('error', 'Invoice not found for this booking!');
            return;
        }

        $data = [
            'invoice' => $invoice,
            'payment' => $payment,
            'booking' => $booking,
        ];


        if ($invoice) {
            return response()->streamDownload(function () use ($invoice, $data) {
                echo  $pdf = Pdf::loadView('pdf.invoice', $data)
                    ->output();
            }, 'invoice-' . $invoice->invoice_number . '.pdf');
        }

        session()->flash('error', 'Invoice tidak ditemukan');
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.my-booking');
    }
}
