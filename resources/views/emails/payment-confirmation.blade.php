<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #2d6a4f;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background: #f8f9fa;
            padding: 20px;
        }

        .booking-info {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .button {
            background: #2d6a4f;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            display: inline-block;
            margin: 20px 0;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pembayaran Berhasil!</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $booking->customer_name }}</strong>,</p>

            <p>Terima kasih! Pembayaran Anda telah kami terima. Berikut detail booking Anda:</p>

            <div class="booking-info">
                <table width="100%">
                    <tr>
                        <td><strong>Booking Code:</strong></td>
                        <td>{{ $booking->booking_token }}</td>
                    </tr>
                    <tr>
                        <td><strong>Invoice:</strong></td>
                        <td>{{ $invoice->getInvoiceNumber() }}</td>
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
                        <td><strong>Total Dibayar:</strong></td>
                        <td><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            <p><strong>Invoice terlampir dalam email ini (PDF)</strong></p>

            <p>Silakan simpan kode booking Anda untuk check-in.</p>

            <a href="{{ route('booking.finish', $booking->booking_token) }}" class="button">
                Lihat Detail Booking
            </a>

            <p>Jika ada pertanyaan, silakan hubungi kami via WhatsApp: <strong>+62 813-3737-1234</strong></p>
        </div>

        <div class="footer">
            <p>© 2025 Kampung Kopi Camp. All rights reserved.</p>
            <p>Pupuan, Tabanan, Bali</p>
        </div>
    </div>
</body>

</html>
