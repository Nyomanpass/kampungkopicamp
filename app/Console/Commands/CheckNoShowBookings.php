<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Availability;
use App\Models\Product;
use Illuminate\Support\Facades\Log;


class CheckNoShowBookings extends Command
{
    protected $signature = 'bookings:check-noshow';
    protected $description = 'Automatically mark paid bookings as no-show if customer did not check-in by checkout date';

    public function handle()
    {
        $yesterday = Carbon::yesterday()->endOfDay();

        $noShowBookings = Booking::where('status', 'paid')
            ->where('end_date', '<=', $yesterday)
            ->get();

        $count = 0;
        foreach ($noShowBookings as $booking) {
            $booking->update(['status' => 'no_show']);

            // Release availability
            $this->releaseAvailability($booking);

            \App\Services\NotificationService::noShowBooking($booking);

            Log::info('Auto-marked as no-show', [
                'booking_id' => $booking->id,
                'token' => $booking->booking_token,
                'checkout_date' => $booking->end_date,
            ]);

            $count++;
        }

        $this->info("Marked {$count} bookings as no-show.");

        return 0;
    }

    private function releaseAvailability($booking)
    {
        $start = Carbon::parse($booking->start_date);
        $end = Carbon::parse($booking->end_date);
        $current = $start->copy();

        $product = Product::find($booking->items->where('item_type', 'product')->first()?->product_id);

        if (!$product) return;

        if ($product->type === 'touring') {
            $this->incrementAvailability($booking, $start->format('Y-m-d'), $product);
        } else {
            while ($current->lt($end)) {
                $this->incrementAvailability($booking, $current->format('Y-m-d'), $product);
                $current->addDay();
            }
        }
    }

    private function incrementAvailability($booking, $date, $product)
    {
        $availability = Availability::where('product_id', $product->id)
            ->whereDate('date', $date)
            ->first();

        if ($availability) {
            if ($booking->product_type === 'touring') {
                $availability->increment('available_seat', $booking->seat_count);
            } else {
                $availability->increment('available_unit', $booking->unit_count);
            }
        }
    }
}
