<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentExpired;


class ExpireBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Bookings that have passed payment deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredBookings = Booking::whereIn('status', ['draft', 'pending_payment'])
            ->whereHas('payments', function ($query) {
                $query->where('expired_at', '<=', Carbon::now())
                    ->whereIn('status', ['initiated', 'pending']);
            })
            ->get();

        $bookingService = new BookingService();
        $count = 0;

        foreach ($expiredBookings as $booking) {
            try {
                $payment = $booking->payments()->latest()->first();
                $bookingService->updateBookingStatus($booking, 'expired');
                $count++;

                if ($payment) {
                    $payment->update(['status' => 'expire']);
                }

                try {
                    Mail::to($booking->customer_email)->send(new PaymentExpired($booking, $payment));
                    Log::info("Payment expired email sent", [
                        'booking_token' => $booking->booking_token,
                        'customer_email' => $booking->customer_email,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error sending payment expired email: ' . $e->getMessage());
                }

                $this->releaseAvailability($booking);

                \App\Services\NotificationService::bookingExpired($booking);

                $count++;

                Log::info("Booking expired", [
                    'booking_token' => $booking->booking_token,
                    'customer_email' => $booking->customer_email,
                ]);
                $this->info("Expired booking: {$booking->booking_token}");
            } catch (\Exception $e) {
                Log::error("Failed to expire booking: " . $e->getMessage(), [
                    'booking_id' => $booking->id,
                ]);

                $this->error("Failed to expire booking {$booking->id}: {$e->getMessage()}");
            }
        }

        $this->info("Total expired: {$count} bookings");

        return Command::SUCCESS;
    }
}
