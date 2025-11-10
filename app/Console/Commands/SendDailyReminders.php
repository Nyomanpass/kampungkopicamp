<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Services\NotificationService;
use Carbon\Carbon;

class SendDailyReminders extends Command
{
    protected $signature = 'bookings:daily-reminders';
    protected $description = 'Send daily reminders for check-in and check-out';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // ✅ Check-in reminders (bookings starting today)
        $checkInBookings = Booking::where('status', 'paid')
            ->whereDate('start_date', $today)
            ->get();

        foreach ($checkInBookings as $booking) {
            NotificationService::checkInReminder($booking);
        }

        $this->info("Sent {$checkInBookings->count()} check-in reminders.");

        // ✅ Check-out reminders (bookings ending today)
        $checkOutBookings = Booking::where('status', 'checked_in')
            ->whereDate('end_date', $today)
            ->get();

        foreach ($checkOutBookings as $booking) {
            NotificationService::checkOutReminder($booking);
        }

        $this->info("Sent {$checkOutBookings->count()} check-out reminders.");

        return 0;
    }
}
