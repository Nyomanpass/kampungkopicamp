<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;
use App\Models\Invoice;

class BookingRefunded extends Mailable
{
      use Queueable, SerializesModels;

      public $booking;
      public $creditNote;
      public $refundType;
      public $refundAmount;
      public $refundReason;

      /**
       * Create a new message instance.
       */
      public function __construct(Booking $booking, Invoice $creditNote, string $refundType, float $refundAmount, string $refundReason)
      {
            $this->booking = $booking;
            $this->creditNote = $creditNote;
            $this->refundType = $refundType;
            $this->refundAmount = $refundAmount;
            $this->refundReason = $refundReason;
      }

      /**
       * Get the message envelope.
       */
      public function envelope(): Envelope
      {
            return new Envelope(
                  subject: 'Konfirmasi Refund Booking - ' . $this->booking->booking_token,
            );
      }

      /**
       * Get the message content definition.
       */
      public function content(): Content
      {
            return new Content(
                  view: 'emails.booking-refunded',
            );
      }

      /**
       * Get the attachments for the message.
       *
       * @return array<int, \Illuminate\Mail\Mailables\Attachment>
       */
      public function attachments(): array
      {
            return [];
      }
}
