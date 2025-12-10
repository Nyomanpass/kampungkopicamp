<?php
// filepath: app/Services/NotificationService.php

namespace App\Services;

use App\Models\Notification;
use App\Models\Booking;
use Carbon\Carbon;

class NotificationService
{
      /**
       * Create notification for new paid booking
       */
      public static function newPaidBooking(Booking $booking)
      {
            return Notification::create([
                  'type' => 'new_booking',
                  'title' => 'Booking Baru Terbayar!',
                  'message' => "Booking baru dari {$booking->customer_name} telah dibayar sebesar Rp " . number_format($booking->total_price, 0, ',', '.'),
                  'data' => [
                        'booking_id' => $booking->id,
                        'booking_token' => $booking->booking_token,
                        'customer_name' => $booking->customer_name,
                        'total_price' => $booking->total_price,
                  ],
                  'action_url' => route('admin.bookings') . '?view=detail&id=' . $booking->id,
                  'expires_at' => now()->addDays(7), // Auto-delete after 7 days
            ]);
      }

      /**
       * Create notification for check-in reminder (same day)
       */
      public static function checkInReminder(Booking $booking)
      {
            // Check if notification already exists for this booking today
            $existingNotification = Notification::where('type', 'check_in_reminder')
                  ->where('data->booking_id', $booking->id)
                  ->whereDate('created_at', today())
                  ->first();

            if ($existingNotification) {
                  return $existingNotification; // Already exists, don't create duplicate
            }

            return Notification::create([
                  'type' => 'check_in_reminder',
                  'title' => 'Reminder Check-In Hari Ini',
                  'message' => "Booking {$booking->booking_token} dari {$booking->customer_name} scheduled untuk check-in hari ini.",
                  'data' => [
                        'booking_id' => $booking->id,
                        'booking_token' => $booking->booking_token,
                        'customer_name' => $booking->customer_name,
                        'check_in_date' => $booking->start_date->format('d M Y'),
                  ],
                  'action_url' => route('admin.bookings') . '?view=detail&id=' . $booking->id,
                  'expires_at' => $booking->start_date->endOfDay(),
            ]);
      }


      public static function checkOutReminder(Booking $booking)
      {
            // Check if notification already exists for this booking today
            $existingNotification = Notification::where('type', 'check_out_reminder')
                  ->where('data->booking_id', $booking->id)
                  ->whereDate('created_at', today())
                  ->first();

            if ($existingNotification) {
                  return $existingNotification; // Already exists, don't create duplicate
            }

            return Notification::create([
                  'type' => 'check_out_reminder',
                  'title' => 'Reminder Check-Out Hari Ini',
                  'message' => "Booking {$booking->booking_token} dari {$booking->customer_name} scheduled untuk check-out hari ini.",
                  'data' => [
                        'booking_id' => $booking->id,
                        'booking_token' => $booking->booking_token,
                        'customer_name' => $booking->customer_name,
                        'check_out_date' => $booking->end_date->format('d M Y'),
                  ],
                  'action_url' => route('admin.bookings') . '?view=detail&id=' . $booking->id,
                  'expires_at' => $booking->end_date->endOfDay(),
            ]);
      }

      public static function noShowBooking(Booking $booking)
      {
            return Notification::create([
                  'type' => 'no_show',
                  'title' => 'Booking Ditandai No-Show',
                  'message' => "Booking {$booking->booking_token} dari {$booking->customer_name} otomatis ditandai sebagai no-show karena tidak check-in.",
                  'data' => [
                        'booking_id' => $booking->id,
                        'booking_token' => $booking->booking_token,
                        'customer_name' => $booking->customer_name,
                        'missed_date' => $booking->end_date->format('d M Y'),
                  ],
                  'action_url' => route('admin.bookings') . '?view=detail&id=' . $booking->id,
                  'expires_at' => now()->addDays(30), // Keep for 30 days
            ]);
      }

      public static function bookingExpired(Booking $booking)
      {
            return Notification::create([
                  'type' => 'expired',
                  'title' => 'Booking Kedaluwarsa',
                  'message' => "Booking {$booking->booking_token} dari {$booking->customer_name} telah kedaluwarsa karena belum dibayar.",
                  'data' => [
                        'booking_id' => $booking->id,
                        'booking_token' => $booking->booking_token,
                        'customer_name' => $booking->customer_name,
                  ],
                  'action_url' => route('admin.bookings') . '?view=detail&id=' . $booking->id,
                  'expires_at' => now()->addDays(3),
            ]);
      }

      public static function deleteExpired()
      {
            return Notification::where('expires_at', '<', now())->delete();
      }

      public static function markAllAsRead()
      {
            return Notification::unread()->update([
                  'is_read' => true,
                  'read_at' => now(),
            ]);
      }
}
