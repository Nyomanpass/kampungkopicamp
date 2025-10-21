<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentPending extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $payment;
    public $paymentDetails;

    public function __construct(Booking $booking, Payment $payment, array $paymentDetails = [])
    {
        $this->booking = $booking;
        $this->payment = $payment;
        $this->paymentDetails = $paymentDetails;
    }

    public function build()
    {
        $subject = 'Menunggu Pembayaran - Booking #' . $this->booking->booking_token;

        return $this->subject($subject)
            ->view('emails.payment-pending')
            ->with([
                'booking' => $this->booking,
                'payment' => $this->payment,
                'paymentDetails' => $this->paymentDetails,
            ]);
    }
}
