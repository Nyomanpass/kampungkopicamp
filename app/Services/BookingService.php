<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use App\Models\Availability;
use App\Models\Addon;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookingService
{
      public function createBooking(array $data)
      {
            $bookingToken = 'BK-' . strtoupper(Str::random(10));

            $user = Auth::user() ?? null;

            // Create booking
            $booking = Booking::create([
                  'booking_token' => $bookingToken,
                  'user_id' => $user->id ?? null,
                  'product_type' => $data['product_type'],
                  'start_date' => $data['start_date'],
                  'end_date' => $data['end_date'],
                  'people_count' => $data['people_count'],
                  'unit_count' => $data['unit_count'] ?? null,
                  'seat_count' => $data['seat_count'] ?? null,
                  'subtotal' => $data['subtotal'],
                  'discount_total' => 0,
                  'total_price' => $data['total_price'],
                  'status' => 'draft',
                  'customer_name' => $data['customer_name'],
                  'customer_email' => $data['customer_email'],
                  'customer_phone' => $data['customer_phone'],
                  'special_requests' => $data['special_requests'] ?? null,
            ]);

            // Create booking items (product)
            BookingItem::create([
                  'booking_id' => $booking->id,
                  'product_id' => $data['product_id'],
                  'item_type' => 'product',
                  'name_snapshot' => $data['product_name'],
                  'pricing_type_snapshot' => $data['pricing_type'],
                  'qty' => $data['unit_count'] ?? 1,
                  'unit_price' => $data['product_unit_price'],
                  'subtotal' => $data['subtotal'],
            ]);

            // Create booking items (add-ons)
            if (!empty($data['addons'])) {
                  foreach ($data['addons'] as $addonData) {
                        BookingItem::create([
                              'booking_id' => $booking->id,
                              'product_id' => null,
                              'item_type' => 'addon',
                              'name_snapshot' => $addonData['name'],
                              'pricing_type_snapshot' => $addonData['pricing_type'],
                              'qty' => $addonData['qty'],
                              'unit_price' => $addonData['unit_price'],
                              'subtotal' => $addonData['subtotal'],
                              'notes' => $addonData['notes'] ?? null,
                        ]);
                  }
            }

            // ✅ Hold availability stock dengan validation
            try {
                  $this->holdAvailability(
                        $data['product_id'],
                        $data['start_date'],
                        $data['end_date'],
                        $data['unit_count'] ?? 0,
                        $data['seat_count'] ?? 0
                  );
            } catch (\Exception $e) {
                  Log::error('Failed to hold availability', [
                        'error' => $e->getMessage(),
                        'booking_token' => $bookingToken,
                  ]);

                  throw new \Exception('Availability tidak tersedia untuk tanggal yang dipilih');
            }

            return $booking;
      }

      private function holdAvailability($productId, $startDate, $endDate, $unitCount, $seatCount)
      {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $dateRange = CarbonPeriod::create($start, $end->copy()->subDay());

            $dates = collect($dateRange)->map(fn($d) => $d->format('Y-m-d'))->toArray();

            Log::info('Attempting to hold availability', [
                  'product_id' => $productId,
                  'dates' => $dates,
                  'unit_count' => $unitCount,
                  'seat_count' => $seatCount,
            ]);

            // ✅ Cek semua availability dulu sebelum hold
            $missingDates = [];
            foreach ($dateRange as $date) {
                  $dateStr = $date->format('Y-m-d');

                  // ✅ FIX: Query dengan whereDate untuk match date tanpa time
                  $availability = Availability::where('product_id', $productId)
                        ->whereDate('date', $dateStr)
                        ->first();

                  if (!$availability) {
                        $missingDates[] = $dateStr;
                  }
            }

            // ✅ Jika ada tanggal yang tidak tersedia, throw error
            if (!empty($missingDates)) {
                  Log::error('Availability missing for dates', [
                        'product_id' => $productId,
                        'missing_dates' => $missingDates,
                  ]);

                  throw new \Exception('Availability tidak ditemukan untuk tanggal: ' . implode(', ', $missingDates));
            }

            // ✅ Semua availability ada, sekarang hold stock
            foreach ($dateRange as $date) {
                  $dateStr = $date->format('Y-m-d');

                  // ✅ FIX: Query dengan whereDate
                  $availability = Availability::where('product_id', $productId)
                        ->whereDate('date', $dateStr)
                        ->first();

                  $before = [
                        'available_unit' => $availability->available_unit,
                        'available_seat' => $availability->available_seat,
                  ];

                  // ✅ Cek apakah stock cukup
                  if ($unitCount > 0 && $availability->available_unit < $unitCount) {
                        throw new \Exception("Stock unit tidak cukup untuk tanggal {$dateStr}. Tersedia: {$availability->available_unit}, Dibutuhkan: {$unitCount}");
                  }

                  if ($seatCount > 0 && $availability->available_seat < $seatCount) {
                        throw new \Exception("Stock seat tidak cukup untuk tanggal {$dateStr}. Tersedia: {$availability->available_seat}, Dibutuhkan: {$seatCount}");
                  }

                  // ✅ Hold stock
                  if ($unitCount > 0) {
                        $availability->decrement('available_unit', $unitCount);
                  }
                  if ($seatCount > 0) {
                        $availability->decrement('available_seat', $seatCount);
                  }

                  $availability->refresh();

                  Log::info("Stock held for date: {$dateStr}", [
                        'before' => $before,
                        'after' => [
                              'available_unit' => $availability->available_unit,
                              'available_seat' => $availability->available_seat,
                        ],
                        'decremented' => [
                              'unit' => $unitCount,
                              'seat' => $seatCount,
                        ]
                  ]);
            }

            Log::info('Successfully held availability for all dates');
      }

      public function releaseAvailability(Booking $booking)
      {
            $productItem = $booking->bookingItems()
                  ->where('item_type', 'product')
                  ->first();

            if (!$productItem || !$productItem->product_id) {
                  Log::warning('No product item found for booking', ['booking_id' => $booking->id]);
                  return;
            }

            $start = Carbon::parse($booking->start_date);
            $end = Carbon::parse($booking->end_date);
            $dateRange = CarbonPeriod::create($start, $end->copy()->subDay());

            Log::info('Releasing availability', [
                  'booking_id' => $booking->id,
                  'product_id' => $productItem->product_id,
                  'dates' => collect($dateRange)->map(fn($d) => $d->format('Y-m-d'))->toArray()
            ]);

            foreach ($dateRange as $date) {
                  $dateStr = $date->format('Y-m-d');

                  // ✅ FIX: Query dengan whereDate
                  $availability = Availability::where('product_id', $productItem->product_id)
                        ->whereDate('date', $dateStr)
                        ->first();

                  // ✅ Skip jika availability tidak ditemukan
                  if (!$availability) {
                        Log::warning("Availability not found for release on date: {$dateStr}");
                        continue;
                  }

                  $before = [
                        'available_unit' => $availability->available_unit,
                        'available_seat' => $availability->available_seat,
                  ];

                  if ($booking->unit_count > 0) {
                        $availability->increment('available_unit', $booking->unit_count);
                  }
                  if ($booking->seat_count > 0) {
                        $availability->increment('available_seat', $booking->seat_count);
                  }

                  $availability->refresh();

                  Log::info("Stock released for date: {$dateStr}", [
                        'before' => $before,
                        'after' => [
                              'available_unit' => $availability->available_unit,
                              'available_seat' => $availability->available_seat,
                        ],
                  ]);
            }
      }

      public function updateBookingStatus(Booking $booking, string $status)
      {
            Log::info('Updating booking status', [
                  'booking_id' => $booking->id,
                  'old_status' => $booking->status,
                  'new_status' => $status,
            ]);

            $booking->update(['status' => $status]);

            if (in_array($status, ['expired', 'cancelled'])) {
                  $this->releaseAvailability($booking);
            }

            return $booking;
      }
}
