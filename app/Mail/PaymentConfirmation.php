<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $invoice;

    public function __construct(Booking $booking, Invoice $invoice)
    {
        $this->booking = $booking;
        $this->invoice = $invoice;
    }

    public function build()
    {
        // Generate PDF invoice
        $pdf = Pdf::loadView('pdf.invoice', [
            'booking' => $this->booking,
            'invoice' => $this->invoice,
        ]);

        return $this->subject('Konfirmasi Pembayaran - Kampung Kopi Camp')
            ->view('emails.payment-confirmation')
            ->with([
                'booking' => $this->booking,
                'invoice' => $this->invoice,
            ])
            ->attachData($pdf->output(), 'invoice-' . $this->invoice->getInvoiceNumber() . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}