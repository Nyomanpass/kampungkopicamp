<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentExpired extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $payment;

    public function __construct(Booking $booking, Payment $payment)
    {
        $this->booking = $booking;
        $this->payment = $payment;
    }

    public function build()
    {
        $subject = 'Booking Expired - ' . $this->booking->booking_token;

        return $this->subject($subject)
            ->view('emails.payment-expired')
            ->with([
                'booking' => $this->booking,
                'payment' => $this->payment,
            ]);
    }
}
