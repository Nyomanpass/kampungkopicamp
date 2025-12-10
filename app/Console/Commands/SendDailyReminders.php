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

        $checkInCreated = 0;
        foreach ($checkInBookings as $booking) {
            $notification = NotificationService::checkInReminder($booking);
            if ($notification->wasRecentlyCreated) {
                $checkInCreated++;
            }
        }

        $this->info("Processed {$checkInBookings->count()} check-in bookings. Created {$checkInCreated} new notifications.");

        // ✅ Check-out reminders (bookings ending today)
        $checkOutBookings = Booking::where('status', 'checked_in')
            ->whereDate('end_date', $today)
            ->get();

        $checkOutCreated = 0;
        foreach ($checkOutBookings as $booking) {
            $notification = NotificationService::checkOutReminder($booking);
            if ($notification->wasRecentlyCreated) {
                $checkOutCreated++;
            }
        }

        $this->info("Processed {$checkOutBookings->count()} check-out bookings. Created {$checkOutCreated} new notifications.");

        return 0;
    }
}
