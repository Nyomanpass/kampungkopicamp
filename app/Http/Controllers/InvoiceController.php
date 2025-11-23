<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Invoice $invoice)
    {
        $booking = $invoice->booking;
        $payment = Payment::where('booking_id', $booking->id)->first();



        // continue to generate PDF
        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'booking' => $booking,
            'payment' => $payment,
        ]);

        return $pdf->download('invoice-' . $invoice->getInvoiceNumber() . '.pdf');
    }

    public function preview(Invoice $invoice)
    {
        $booking = $invoice->booking;
        $payment = Payment::where('booking_id', $booking->id)->first();
        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'booking' => $booking,
            'payment' => $payment,
        ]);

        return $pdf->stream();
    }
}
