<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ========================================
// SCHEDULED TASKS
// ========================================
// All scheduled tasks are defined here for simplicity
// The actual logic is in respective Command classes

// 1. Expire bookings that haven't been paid (every 5 minutes)
Schedule::command('bookings:expire')
    ->everyFiveMinutes()
    ->withoutOverlapping();

// 2. Check for no-show bookings (daily at 12 PM)
Schedule::command('bookings:check-noshow')
    ->dailyAt('12:00')
    ->withoutOverlapping();

// 3. Send daily booking reminders (every 5 minutes)
Schedule::command('bookings:daily-reminders')
    ->everyFiveMinutes()
    ->withoutOverlapping();

// 4. Cleanup expired notifications (daily at midnight)
Schedule::call(function () {
    \App\Services\NotificationService::deleteExpired();
})->dailyAt('00:00');

// 5. Generate product availability for 1 month ahead (monthly on 1st)
// ⚠️ Uses default stock from products.default_units and products.default_seats
Schedule::command('availability:generate --months=1')
    ->monthlyOn(1, '00:00')
    ->withoutOverlapping()
    ->onSuccess(function () {
        Log::info("[Scheduler] Monthly availability generation completed successfully");
    })
    ->onFailure(function () {
        Log::error("[Scheduler] Monthly availability generation failed");
    });
