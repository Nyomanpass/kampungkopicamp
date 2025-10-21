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
            background: #c2644f;
            /* danger color */
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

        .alert {
            background: #ffe5e0;
            border: 1px solid #c2644f;
            /* danger color */
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }

        .alert-icon {
            font-size: 48px;
            margin-bottom: 10px;
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

        .info-box {
            background: #eadfc8;
            /* secondary color */
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #c39b77;
            /* accent color */
            margin: 15px 0;
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

        .danger-text {
            color: #c2644f;
            /* danger color */
            font-weight: bold;
        }

        .success-text {
            color: #85b582;
            /* success color */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>⏰ Booking Expired</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $booking->customer_name }}</strong>,</p>

            <div class="alert">
                <div class="alert-icon">❌</div>
                <p style="margin: 0; font-size: 18px;" class="danger-text">Booking Anda Telah Dibatalkan</p>
                <p style="margin: 5px 0 0 0; font-size: 14px;">Waktu pembayaran telah habis</p>
            </div>

            <p>Mohon maaf, booking Anda dengan kode <strong class="highlight">{{ $booking->booking_token }}</strong>
                telah otomatis dibatalkan karena pembayaran
                tidak diterima dalam batas waktu yang ditentukan.</p>

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
                        <td><strong>Total:</strong></td>
                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Batas Pembayaran:</strong></td>
                        <td class="danger-text">{{ \Carbon\Carbon::parse($payment->expired_at)->format('d M Y H:i') }}
                            WITA</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td class="danger-text">EXPIRED</td>
                    </tr>
                </table>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #5b7042;">ℹ️ Informasi</h3>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Slot yang Anda pesan telah dikembalikan ke sistem</li>
                    <li>Tidak ada biaya yang akan dikenakan</li>
                    <li>Anda dapat melakukan booking baru kapan saja</li>
                </ul>
            </div>

            <p><strong class="success-text">Masih ingin berkunjung ke Kampung Kopi Camp?</strong></p>
            <p>Silakan lakukan booking baru dengan memilih tanggal yang sesuai. Kami tunggu kedatangan Anda!</p>

            <div style="text-align: center;">
                <a href="{{ route('home') }}" class="button">
                    Booking Sekarang
                </a>
            </div>

            <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e8e8e4;">
                Jika Anda mengalami kesulitan saat melakukan booking atau ada pertanyaan, jangan ragu untuk menghubungi
                kami via WhatsApp:
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
