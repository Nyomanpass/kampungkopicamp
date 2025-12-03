<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Invoice;
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;
use App\Mail\PaymentPending;
use App\Mail\PaymentExpired;

class PaymentService
{

      public function __construct()
      {
            // Set konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');
      }

      // ========= create payment & snap token ===========
      public function createPayment(Booking $booking)
      {
            try {
                  $orderId = 'ORDER-' . $booking->booking_token . '-' . time();
                  $expiredAt = Carbon::now()->addHours(2);

                  $booking->load('bookingItems');

                  $items = [];

                  if ($booking->bookingItems && $booking->bookingItems->count() > 0) {
                        foreach ($booking->bookingItems as $item) {
                              $items[] = [
                                    'id' => $item->id,
                                    'price' => (int) $item->unit_price,
                                    'quantity' => (int) $item->qty,
                                    'name' => $item->name_snapshot,
                              ];
                        }
                  } else {
                        throw new \Exception('Booking items not found');
                  }

                  $params = [
                        'transaction_details' => [
                              'order_id' => $orderId,
                              'gross_amount' => (int) $booking->total_price,
                        ],
                        'item_details' => $items,
                        'customer_details' => [
                              'first_name' => $booking->customer_name,
                              'email' => $booking->customer_email,
                              'phone' => $booking->customer_phone,
                        ],
                        'expiry' => [
                              'start_time' => Carbon::now()->format('Y-m-d H:i:s O'),
                              'unit' => 'minutes',
                              'duration' => 120,
                        ],
                        'callbacks' => [
                              'finish' => route('booking.finish', $booking->booking_token),
                        ],
                        'enabled_payments' => [
                              'credit_card',
                              'bca_va',
                              'bni_va',
                              'bri_va',
                              'permata_va',
                              'other_va',
                              'gopay',
                              'shopeepay',
                              'qris',
                              'cstore'
                        ]
                  ];

                  $snapToken = Snap::getSnapToken($params);

                  $payment = Payment::create([
                        'booking_id' => $booking->id,
                        'provider' => 'midtrans',
                        'order_id' => $orderId,
                        'payment_code_or_url' => $snapToken, // Store snap token for reuse
                        'amount' => $booking->total_price,
                        'status' => 'initiated',
                        'expired_at' => $expiredAt,
                  ]);

                  $booking->update(['status' => 'pending_payment']);

                  Log::info("Payment created, waiting for user to select payment method", [
                        'booking_token' => $booking->booking_token,
                        'order_id' => $orderId,
                  ]);

                  return [
                        'success' => true,
                        'snap_token' => $snapToken,
                        'payment' => $payment,
                  ];
            } catch (\Exception $e) {
                  Log::error('Error creating payment: ' . $e->getMessage());

                  return [
                        'success' => false,
                        'message' => 'Gagal memuat pembayaran : ' . $e->getMessage(),
                  ];
            }
      }


      // ========= handle midtrans notification (webhook) ===========

      public function handleNotification(array $notification)
      {
            try {
                  $orderId = $notification['order_id'];
                  $transactionStatus = $notification['transaction_status'];
                  $fraudStatus = $notification['fraud_status'] ?? null;

                  $payment = Payment::where('order_id', $orderId)->first();

                  if (!$payment) {
                        preg_match('/ORDER-(BK-[A-Z0-9]+)-/', $orderId, $matches);

                        if (isset($matches[1])) {
                              $bookingToken = $matches[1];
                              $booking = Booking::where('booking_token', $bookingToken)->first();

                              if ($booking) {
                                    $payment = $booking->payments()->latest()->first();
                              }
                        }
                  }

                  if (!$payment) {
                        Log::warning("Payment not found for order_id: {$orderId}");

                        return [
                              'success' => false,
                              'message' => "Payment not found for order_id: {$orderId}",
                        ];
                  }
                  $booking = $payment->booking;

                  $paymentStatus = $this->mapTransactionStatus($transactionStatus, $fraudStatus);
                  $payment->update([
                        'status' => $paymentStatus,
                        'raw_payload' => json_encode($notification),
                  ]);

                  if ($paymentStatus === 'settlement') {
                        $payment->update(['paid_at' => now()]);
                        $booking->update(['status' => 'paid']);

                        $invoice = Invoice::create([
                              'booking_id' => $booking->id,
                              'type' => 'primary',
                              'amount' => $booking->total_price,
                              'status' => 'paid',
                              // invoice_number auto-generated by boot method
                        ]);

                        // Create invoice items
                        foreach ($booking->items as $bookingItem) {
                              \App\Models\InvoiceItem::create([
                                    'invoice_id' => $invoice->id,
                                    'booking_item_id' => $bookingItem->id,
                                    'name' => $bookingItem->name_snapshot,
                                    'qty' => $bookingItem->qty,
                                    'unit_price' => $bookingItem->unit_price,
                                    'subtotal' => $bookingItem->subtotal,
                                    'meta' => [
                                          'item_type' => $bookingItem->item_type,
                                          'product_id' => $bookingItem->product_id,
                                          'addon_id' => $bookingItem->addon_id,
                                          'pricing_type' => $bookingItem->pricing_type_snapshot,
                                    ],
                              ]);
                        }

                        // Kirim email konfirmasi pembayaran ke pelanggan
                        try {
                              Mail::to($booking->customer_email)->send(new PaymentConfirmation($booking, $invoice, $payment));
                              Log::info("Payment confirmation email sent to: {$booking->customer_email}");
                        } catch (\Exception $e) {
                              Log::error('Error sending payment confirmation email: ' . $e->getMessage());
                        }
                  } elseif ($paymentStatus === 'pending') {
                        try {
                              $paymentDetails = $this->extractPaymentDetails($notification);
                              Mail::to($booking->customer_email)->send(new PaymentPending($booking, $payment, $paymentDetails));
                              Log::info("Payment pending notification sent to: {$booking->customer_email}");
                        } catch (\Exception $e) {
                              Log::error('Error sending payment pending notification: ' . $e->getMessage());
                        }
                  } elseif (in_array($paymentStatus, ['expire', 'cancel'])) {
                        $booking->update(['status' => 'expired']);
                        app(BookingService::class)->releaseAvailability($booking);

                        try {
                              Mail::to($booking->customer_email)->send(new PaymentExpired($booking, $payment));
                              Log::info("Payment expired notification sent to: {$booking->customer_email}");
                        } catch (\Exception $e) {
                              Log::error('Error sending payment expired notification: ' . $e->getMessage());
                        }
                  }

                  return
                        [
                              'success' => true,
                              'message' => 'Payment notification handled successfully.',
                        ];
            } catch (\Exception $e) {
                  Log::error('Error handling payment notification: ' . $e->getMessage());

                  return [
                        'success' => false,
                        'message' => 'Failed to handle payment notification: ' . $e->getMessage(),
                  ];
            }
      }

      private function extractPaymentDetails(array $notification)
      {
            $details = [];

            //payment type
            if (isset($notification['payment_type'])) {
                  $details['payment_type'] = $notification['payment_type'];
                  $details['payment_type_label'] = $this->getPaymentTypeLabel($notification['payment_type']);
            }

            //virtual account numbers
            if (isset($notification['va_numbers'])) {
                  $details['va_numbers'] = $notification['va_numbers'];
            }

            //permata VA
            if (isset($notification['permata_va_number'])) {
                  $details['permata_va_number'] = $notification['permata_va_number'];
            }


            // Bill key (Mandiri Bill Payment)
            if (isset($notification['bill_key'])) {
                  $details['bill_key'] = $notification['bill_key'];
                  $details['biller_code'] = $notification['biller_code'] ?? null;
            }

            // QR Code / Deeplink (GoPay, QRIS, dll)
            if (isset($notification['actions'])) {
                  $details['actions'] = $notification['actions'];
            }

            return $details;
      }

      private function getPaymentTypeLabel($paymentType)
      {
            $labels = [
                  'bank_transfer' => 'Transfer Bank',
                  'echannel' => 'Mandiri Bill Payment',
                  'bca_va' => 'BCA Virtual Account',
                  'bni_va' => 'BNI Virtual Account',
                  'bri_va' => 'BRI Virtual Account',
                  'permata_va' => 'Permata Virtual Account',
                  'gopay' => 'GoPay',
                  'qris' => 'QRIS',
                  'shopeepay' => 'ShopeePay',
                  'cstore' => 'Indomaret/Alfamart',
            ];

            return $labels[$paymentType] ?? ucfirst(str_replace('_', ' ', $paymentType));
      }


      private function mapTransactionStatus($transactionStatus, $fraudStatus)
      {
            if ($transactionStatus === 'capture') {
                  return $fraudStatus == 'accept' ? 'settlement' : 'pending';
            } elseif ($transactionStatus === 'settlement') {
                  return 'settlement';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                  return $transactionStatus;
            } elseif ($transactionStatus === 'pending') {
                  return 'pending';
            } elseif ($transactionStatus === 'refund') {
                  return 'refund';
            }

            return 'pending';
      }
}
