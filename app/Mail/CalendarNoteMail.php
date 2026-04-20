<?php

namespace App\Mail;

use App\Models\Availability;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CalendarNoteMail extends Mailable
{
      use Queueable, SerializesModels;

      public $availability;
      public $date;
      public $productName;
      public $notes;
      public $userName;

      /**
       * Create a new message instance.
       */
      public function __construct(Availability $availability, string $userName)
      {
            $this->availability = $availability;
            $this->date = Carbon::parse($availability->date)->format('d M Y');
            $this->productName = $availability->product->name;
            $this->notes = $availability->notes;
            $this->userName = $userName;
      }

      /**
       * Get the message envelope.
       */
      public function envelope(): Envelope
      {
            return new Envelope(
                  subject: "Catatan Baru pada Kalender Ketersediaan - {$this->productName} ({$this->date})",
            );
      }

      /**
       * Get the message content definition.
       */
      public function content(): Content
      {
            return new Content(
                  markdown: 'emails.admin.calendar-note',
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
