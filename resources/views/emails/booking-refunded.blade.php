<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Refunded</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            font-size: 15px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .refund-alert {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .refund-alert h3 {
            color: #92400e;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .refund-alert p {
            color: #78350f;
            font-size: 15px;
            line-height: 1.6;
        }

        .refund-details {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .refund-details h3 {
            color: #991b1b;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #fee2e2;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6b7280;
            font-weight: 500;
        }

        .detail-value {
            color: #111827;
            font-weight: 600;
            text-align: right;
        }

        .refund-amount-highlight {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .refund-amount-highlight h3 {
            color: #991b1b;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .refund-amount-highlight .amount {
            color: #dc2626;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .refund-amount-highlight .type {
            color: #7f1d1d;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .booking-details {
            background-color: #f9fafb;
            border-left: 4px solid #6b7280;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .booking-details h3 {
            color: #374151;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-box {
            background-color: #eff6ff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-box h4 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .info-box p {
            color: #1e3a8a;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .reason-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
        }

        .reason-box h4 {
            color: #374151;
            font-size: 15px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .reason-box p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            font-style: italic;
        }

        .contact-info {
            background-color: #f0fdf4;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .contact-info h4 {
            color: #166534;
            font-size: 16px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .contact-info p {
            color: #15803d;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .contact-info a {
            color: #166534;
            text-decoration: none;
            font-weight: 500;
        }

        .footer {
            background-color: #374151;
            color: #d1d5db;
            padding: 25px 30px;
            text-align: center;
            font-size: 13px;
        }

        .footer p {
            margin-bottom: 10px;
        }

        .footer a {
            color: #9ca3af;
            text-decoration: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-full {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-partial {
            background-color: #fef3c7;
            color: #92400e;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .refund-amount-highlight .amount {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>💳 Refund Diproses</h1>
            <p>Pengembalian dana untuk booking Anda</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $booking->customer_name }}! 👋
            </div>

            <div class="message">
                Kami telah memproses pengembalian dana untuk booking Anda di <strong>Kampung Kopi Camp</strong>.
                Berikut adalah detail lengkap mengenai refund yang telah diproses.
            </div>

            <!-- Refund Alert -->
            <div class="refund-alert">
                <h3>⚠️ Informasi Penting</h3>
                <p>
                    Refund telah diproses pada sistem kami. Dana akan dikembalikan ke rekening/metode pembayaran
                    Anda sesuai dengan kesepakatan pada pesan WhatsApp Admin.
                </p>
            </div>

            <!-- Refund Amount Highlight -->
            <div class="refund-amount-highlight">
                <h3>Jumlah Refund</h3>
                <div class="amount">Rp {{ number_format($refundAmount, 0, ',', '.') }}</div>
                <div class="type">
                    <span class="badge badge-{{ $refundType === 'full' ? 'full' : 'partial' }}">
                        {{ $refundType === 'full' ? 'FULL REFUND' : 'PARTIAL REFUND' }}
                    </span>
                </div>
            </div>

            <!-- Refund Details -->
            <div class="refund-details">
                <h3>📋 Detail Refund</h3>
                <div class="detail-row">
                    <span class="detail-label">Credit Note ID:</span>
                    <span class="detail-value">#{{ $creditNote->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tipe Refund:</span>
                    <span
                        class="detail-value">{{ $refundType === 'full' ? 'Pengembalian Penuh' : 'Pengembalian Sebagian' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Proses:</span>
                    <span
                        class="detail-value">{{ \Carbon\Carbon::parse($creditNote->created_at)->format('d M Y, H:i') }}
                        WIB</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">Diproses</span>
                </div>
            </div>

            <!-- Refund Reason -->
            @if ($refundReason)
                <div class="reason-box">
                    <h4>📝 Alasan Refund:</h4>
                    <p>"{{ $refundReason }}"</p>
                </div>
            @endif

            <!-- Booking Details -->
            <div class="booking-details">
                <h3>📋 Detail Booking</h3>
                <div class="detail-row">
                    <span class="detail-label">Booking Token:</span>
                    <span class="detail-value">{{ $booking->booking_token }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-in:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-out:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Booking:</span>
                    <span class="detail-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <h4>ℹInformasi Penting</h4>
                <p>• Dana akan dikembalikan ke rekening yang telah disepakati pada pesan WhatsApp Admin</p>
                <p>• Proses refund biasanya memakan waktu 1-2 hari kerja</p>
                <p>• Anda akan menerima notifikasi dari bank/payment provider saat dana masuk</p>
                <p>• Simpan email ini sebagai bukti refund</p>
            </div>

            <!-- Contact Info -->
            <div class="contact-info">
                <h4>Butuh Bantuan?</h4>
                <p>Jika Anda memiliki pertanyaan mengenai refund ini:</p>
                <p>📧 Email: <a href="mailto:kampungkopicamp@gmail.com">kampungkopicamp@gmail.com</a></p>
                <p>📱 WhatsApp: <a href="https://wa.me/6282340086554">+62 823-4008-6554</a></p>
                <p>🌐 Website: <a href="https://kampungkopicamp.com">kampungkopicamp.com</a></p>
            </div>

            <div class="message">
                Kami mohon maaf atas ketidaknyamanan ini. Kami berharap dapat melayani Anda lagi di masa mendatang! 🙏
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Kampung Kopi Camp</strong></p>
            <p>Pupuan, Bali, Indonesia</p>
            <p>© {{ date('Y') }} Kampung Kopi Camp. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
