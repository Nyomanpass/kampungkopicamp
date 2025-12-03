<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Booking;
use App\Models\Payment;
use App\Mail\PaymentReminder;
use App\Mail\PaymentExpired;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ========================================
        // 1. EXPIRE BOOKINGS (Setiap Jam)
        // ========================================
        // Booking yang tidak dibayar dalam 24 jam akan otomatis expired
        $schedule->call(function () {
            $expiredBookings = Booking::where('status', 'pending')
                ->where('created_at', '<', now()->subHours(24))
                ->get();

            $count = 0;
            foreach ($expiredBookings as $booking) {
                $booking->update(['status' => 'expired']);
                //payment data
                $payment = Payment::where('booking_id', $booking->id)->first();

                // Release availability
                foreach ($booking->items as $item) {
                    DB::table('availabilities')
                        ->where('product_id', $item->product_id)
                        ->where('date', $item->date)
                        ->increment('available_quantity', $item->quantity);
                }


                // Kirim email notifikasi expired
                try {
                    Mail::to($booking->email)->send(new PaymentExpired($booking, $payment));
                } catch (\Exception $e) {
                    Log::error('Failed to send expired email for booking #' . $booking->id . ': ' . $e->getMessage());
                }

                $count++;
            }

            if ($count > 0) {
                Log::info("[Scheduler] Expired {$count} bookings");
            }
        })->hourly()->name('expire-bookings')->withoutOverlapping();

        // ========================================
        // 2. PAYMENT REMINDERS (Setiap Jam)
        // ========================================
        // Kirim reminder 4 jam sebelum booking expired (20 jam setelah booking dibuat)
        $schedule->call(function () {
            $reminderBookings = Booking::where('status', 'pending')
                ->whereBetween('created_at', [
                    now()->subHours(20)->subMinutes(30),
                    now()->subHours(20)->addMinutes(30)
                ])
                ->get();

            $count = 0;
            foreach ($reminderBookings as $booking) {
                try {
                    Mail::to($booking->email)->send(new PaymentReminder($booking));
                    $count++;
                } catch (\Exception $e) {
                    Log::error('Failed to send reminder for booking #' . $booking->id . ': ' . $e->getMessage());
                }
            }

            if ($count > 0) {
                Log::info("[Scheduler] Sent {$count} payment reminders");
            }
        })->hourly()->name('payment-reminders')->withoutOverlapping();

        // ========================================
        // 3. CLEANUP OLD NOTIFICATIONS (Harian)
        // ========================================
        // Hapus notifikasi yang sudah lebih dari 30 hari
        $schedule->call(function () {
            $deleted = DB::table('notifications')
                ->where('created_at', '<', now()->subDays(30))
                ->delete();

            if ($deleted > 0) {
                Log::info("[Scheduler] Cleaned up {$deleted} old notifications");
            }
        })->daily()->at('01:00')->name('cleanup-notifications');

        // ========================================
        // 4. DAILY REPORT (Setiap Pagi)
        // ========================================
        // Generate statistik harian untuk monitoring
        $schedule->call(function () {
            $yesterday = now()->subDay();

            $stats = [
                'date' => $yesterday->toDateString(),
                'total_bookings' => Booking::whereDate('created_at', $yesterday)->count(),
                'confirmed_bookings' => Booking::whereDate('created_at', $yesterday)
                    ->where('status', 'confirmed')
                    ->count(),
                'total_revenue' => DB::table('payments')
                    ->whereDate('created_at', $yesterday)
                    ->where('status', 'success')
                    ->sum('amount'),
                'new_customers' => DB::table('users')
                    ->whereDate('created_at', $yesterday)
                    ->where('role', 'customer')
                    ->count(),
            ];

            Log::info("[Scheduler] Daily Stats: " . json_encode($stats));

            // Uncomment jika ingin kirim email ke admin
            // Mail::to(config('mail.admin_email', 'admin@kampungkopicamp.com'))
            //     ->send(new DailyReport($stats));

        })->dailyAt('06:00')->name('daily-report');

        // ========================================
        // 5. DATABASE OPTIMIZATION (Mingguan)
        // ========================================
        // Optimize table untuk performance
        $schedule->call(function () {
            $tables = ['bookings', 'payments', 'booking_items', 'users', 'notifications'];

            foreach ($tables as $table) {
                try {
                    DB::statement("OPTIMIZE TABLE {$table}");
                } catch (\Exception $e) {
                    Log::error("[Scheduler] Failed to optimize table {$table}: " . $e->getMessage());
                }
            }

            Log::info("[Scheduler] Database tables optimized");
        })->weekly()->sundays()->at('03:00')->name('optimize-database');

        // ========================================
        // 6. CLEANUP OLD LOGS (Harian)
        // ========================================
        // Hapus log file yang lebih dari 14 hari
        $schedule->call(function () {
            $logPath = storage_path('logs');
            $files = glob($logPath . '/laravel-*.log');
            $deleted = 0;

            foreach ($files as $file) {
                if (filemtime($file) < now()->subDays(14)->timestamp) {
                    if (unlink($file)) {
                        $deleted++;
                    }
                }
            }

            if ($deleted > 0) {
                Log::info("[Scheduler] Cleaned up {$deleted} old log files");
            }
        })->daily()->at('04:00')->name('cleanup-logs');

        // ========================================
        // 7. CHECK AVAILABILITY (Harian)
        // ========================================
        // Update availability berdasarkan bookings
        $schedule->call(function () {
            // Update status availability untuk tanggal yang sudah lewat
            $updated = DB::table('availabilities')
                ->where('date', '<', now()->toDateString())
                ->where('status', '!=', 'booked')
                ->update(['status' => 'unavailable']);

            if ($updated > 0) {
                Log::info("[Scheduler] Updated {$updated} past availabilities");
            }
        })->daily()->at('00:30')->name('update-availability');

        // ========================================
        // 8. CACHE WARM-UP (Pagi & Sore)
        // ========================================
        // Pre-cache data yang sering diakses untuk performance
        $schedule->call(function () {
            try {
                // Cache paket wisata aktif
                $packages = DB::table('paket_wisatas')
                    ->where('status', 'active')
                    ->get();

                cache()->put('active_packages', $packages, now()->addHours(12));

                // Cache artikel blog terbaru
                $articles = DB::table('articles')
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();

                cache()->put('recent_articles', $articles, now()->addHours(12));

                Log::info("[Scheduler] Cache warmed up successfully");
            } catch (\Exception $e) {
                Log::error("[Scheduler] Cache warm-up failed: " . $e->getMessage());
            }
        })->twiceDaily(7, 16)->name('cache-warmup');

        // ========================================
        // NOTE: Command-based scheduled tasks (bookings:expire, bookings:check-noshow, etc)
        // are defined in routes/console.php for better organization
        // ========================================

        // ========================================
        // OPTIONAL: BACKUP DATABASE (Jika menggunakan spatie/laravel-backup)
        // ========================================
        // Uncomment jika sudah install package spatie/laravel-backup
        // $schedule->command('backup:clean')->daily()->at('01:00');
        // $schedule->command('backup:run')->daily()->at('02:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
