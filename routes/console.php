<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('bookings:expire')
    ->everyFiveMinutes()
    ->withoutOverlapping();

Schedule::command('bookings:check-noshow')
    ->dailyAt('12:00') // Run daily at 12 PM
    ->withoutOverlapping();

Schedule::command('bookings:daily-reminders')
    ->everyFiveMinutes()
    ->withoutOverlapping();

Schedule::call(function () {
    \App\Services\NotificationService::deleteExpired();
})->dailyAt('00:00');

Schedule::command('availability:generate --months=2')
    ->monthlyOn(1, '00:00') // Run on 1st day of every month at midnight
    ->when(function () {
        // Only run on odd months (Jan, Mar, May, Jul, Sep, Nov)
        return now()->month % 2 !== 0;
    })
    ->withoutOverlapping();
