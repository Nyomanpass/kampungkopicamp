<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #2f2f2f;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #e0a15a;
            /* warning color */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background: #f9f9f9;
            padding: 20px;
        }

        .booking-info {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #c39b77;
            /* accent color */
        }

        .payment-info {
            background: #eadfc8;
            /* secondary color */
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border: 2px solid #c39b77;
            /* accent color */
        }

        .va-number {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 2px;
            color: #5b7042;
            /* primary color */
            border: 2px dashed #5b7042;
        }

        .button {
            background: #5b7042;
            /* primary color */
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            display: inline-block;
            margin: 20px 0;
            border-radius: 5px;
        }

        .button:hover {
            background: #8ca67a;
            /* light-primary color */
        }

        .warning {
            background: #fff8e7;
            border: 1px solid #e0a15a;
            /* warning color */
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
        }

        .steps {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border: 1px solid #e8e8e4;
            /* neutral color */
        }

        .steps ol {
            padding-left: 20px;
        }

        .steps li {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }

        .highlight {
            color: #c39b77;
            /* accent color */
            font-weight: bold;
        }

        .success-text {
            color: #85b582;
            /* success color */
        }

        .danger-text {
            color: #c2644f;
            /* danger color */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Menunggu Pembayaran</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $booking->customer_name }}</strong>,</p>

            <p>Terima kasih telah melakukan booking di Kampung Kopi Camp! Booking Anda berhasil dibuat dan menunggu
                pembayaran.</p>

            <div class="booking-info">
                <table width="100%">
                    <tr>
                        <td><strong>Booking Code:</strong></td>
                        <td>{{ $booking->booking_token }}</td>
                    </tr>
                    <tr>
                        <td><strong>Check-in:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Check-out:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Pembayaran:</strong></td>
                        <td class="highlight">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div class="warning">
                <strong>Penting!</strong><br>
                Silakan selesaikan pembayaran sebelum
                <strong style="color: #c2644f;">{{ \Carbon\Carbon::parse($payment->expired_at)->format('d M Y H:i') }}
                    WITA</strong><br>
                <small>Booking akan otomatis dibatalkan jika pembayaran tidak diterima.</small>
            </div>

            <!-- Payment Method Details -->
            @if (!empty($paymentDetails))
                <div class="payment-info">
                    <h3 style="margin-top: 0; color: #5b7042;">💳 Detail Pembayaran</h3>

                    @if (isset($paymentDetails['payment_type']))
                        <p><strong>Metode Pembayaran:</strong> {{ $paymentDetails['payment_type_label'] }}</p>
                    @endif

                    <!-- Virtual Account -->
                    @if (isset($paymentDetails['va_numbers']) && count($paymentDetails['va_numbers']) > 0)
                        @foreach ($paymentDetails['va_numbers'] as $va)
                            <p><strong>Bank:</strong> {{ strtoupper($va['bank']) }}</p>
                            <p><strong>Nomor Virtual Account:</strong></p>
                            <div class="va-number">{{ $va['va_number'] }}</div>
                        @endforeach
                    @endif

                    <!-- E-Wallet (GoPay, QRIS, dll) -->
                    @if (isset($paymentDetails['actions']) && count($paymentDetails['actions']) > 0)
                        <p><strong>Cara Pembayaran:</strong></p>
                        @foreach ($paymentDetails['actions'] as $action)
                            @if ($action['name'] === 'generate-qr-code')
                                <p>Scan QR Code berikut untuk membayar:</p>
                                <img src="{{ $action['url'] }}" alt="QR Code"
                                    style="max-width: 250px; margin: 10px auto; display: block; border: 2px solid #e8e8e4; border-radius: 8px; padding: 10px;">
                            @elseif($action['name'] === 'deeplink-redirect')
                                <a href="{{ $action['url'] }}" class="button">Bayar via
                                    {{ ucfirst($paymentDetails['payment_type'] ?? 'E-Wallet') }}</a>
                            @endif
                        @endforeach
                    @endif

                    <!-- COD / Bank Transfer Manual -->
                    @if (isset($paymentDetails['bill_key']))
                        <p><strong>Kode Pembayaran:</strong></p>
                        <div class="va-number">{{ $paymentDetails['bill_key'] }}</div>
                        @if (isset($paymentDetails['biller_code']))
                            <p><strong>Biller Code:</strong> {{ $paymentDetails['biller_code'] }}</p>
                        @endif
                    @endif

                    <!-- Permata VA -->
                    @if (isset($paymentDetails['permata_va_number']))
                        <p><strong>Bank:</strong> Permata</p>
                        <p><strong>Nomor Virtual Account:</strong></p>
                        <div class="va-number">{{ $paymentDetails['permata_va_number'] }}</div>
                    @endif
                </div>

                <!-- Payment Instructions -->
                <div class="steps">
                    <h3 style="margin-top: 0; color: #5b7042;">📋 Cara Pembayaran</h3>
                    <ol>
                        @if (isset($paymentDetails['va_numbers']))
                            <li>Buka aplikasi mobile banking atau ATM</li>
                            <li>Pilih menu Transfer / Bayar</li>
                            <li>Pilih Virtual Account</li>
                            <li>Masukkan nomor VA: <strong
                                    style="color: #5b7042;">{{ $paymentDetails['va_numbers'][0]['va_number'] }}</strong>
                            </li>
                            <li>Masukkan nominal: <strong style="color: #5b7042;">Rp
                                    {{ number_format($booking->total_price, 0, ',', '.') }}</strong></li>
                            <li>Konfirmasi pembayaran</li>
                        @elseif(isset($paymentDetails['actions']))
                            <li>Klik tombol pembayaran di atas</li>
                            <li>Atau scan QR Code menggunakan aplikasi
                                {{ ucfirst($paymentDetails['payment_type'] ?? 'E-Wallet') }}
                            </li>
                            <li>Konfirmasi pembayaran di aplikasi</li>
                        @else
                            <li>Klik tombol "Bayar Sekarang" di bawah</li>
                            <li>Pilih metode pembayaran yang Anda inginkan</li>
                            <li>Ikuti instruksi pembayaran</li>
                        @endif
                        <li class="success-text">Setelah pembayaran berhasil, Anda akan menerima konfirmasi via email
                        </li>
                    </ol>
                </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ route('payment.show', ['token' => $booking->booking_token, 'snap_token' => $payment->payment_code_or_url]) }}"
                    class="button">
                    Bayar Sekarang
                </a>
            </div>

            <p style="margin-top: 20px;">Jika ada pertanyaan, silakan hubungi kami via WhatsApp:
                <strong style="color: #5b7042;">+62 813-3737-1234</strong>
            </p>
        </div>

        <div class="footer">
            <p>© 2025 Kampung Kopi Camp. All rights reserved.</p>
            <p>Pupuan, Tabanan, Bali</p>
        </div>
    </div>
</body>

</html>
