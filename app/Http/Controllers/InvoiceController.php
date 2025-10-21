<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Invoice $invoice)
    {
        $booking = $invoice->booking;

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'booking' => $booking,
        ]);

        return $pdf->download('invoice-' . $invoice->getInvoiceNumber() . '.pdf');
    }

    public function preview(Invoice $invoice)
    {
        $booking = $invoice->booking;

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'booking' => $booking,
        ]);

        return $pdf->stream();
    }
}
