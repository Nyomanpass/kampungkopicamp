<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Completed</title>
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
            background: linear-gradient(135deg, #5b7042 0%, #6d9e72 100%);
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

        .booking-details {
            background-color: #f9fafb;
            border-left: 4px solid #5b7042;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .booking-details h3 {
            color: #5b7042;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
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

        .review-section {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .review-section h3 {
            color: #92400e;
            font-size: 20px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .review-section p {
            color: #78350f;
            font-size: 15px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .review-button {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff !important;
            padding: 16px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
            transition: all 0.3s ease;
        }

        .review-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.5);
        }

        .stars {
            font-size: 24px;
            color: #f59e0b;
            margin-bottom: 15px;
        }

        .thank-you {
            background-color: #f0fdf4;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .thank-you p {
            color: #166534;
            font-size: 15px;
            line-height: 1.6;
        }

        .contact-info {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .contact-info h4 {
            color: #5b7042;
            font-size: 16px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .contact-info p {
            color: #555;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .contact-info a {
            color: #5b7042;
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

        .social-links {
            margin-top: 15px;
        }

        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 14px;
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

            .review-section {
                padding: 25px 15px;
            }

            .review-button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Booking Completed!</h1>
            <p>Terima kasih telah menginap bersama kami</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $booking->customer_name }}! 👋
            </div>

            <div class="message">
                Terima kasih telah memilih <strong>Kampung Kopi Camp</strong> sebagai destinasi liburan Anda! Kami
                sangat senang Anda telah menyelesaikan pengalaman menginap bersama kami.
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <h3>Detail Booking</h3>
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
                    <span class="detail-label">Jumlah Tamu:</span>
                    <span class="detail-value">{{ $booking->people_count }} orang</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Pembayaran:</span>
                    <span class="detail-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Thank You Message -->
            <div class="thank-you">
                <p>
                    Kami berharap Anda menikmati setiap momen di Kampung Kopi Camp. Pengalaman dan kepuasan Anda
                    adalah prioritas utama kami!
                </p>
            </div>

            <!-- Review Section -->
            <div class="review-section">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <h3>Bagaimana Pengalaman Anda?</h3>
                <p>
                    Kami sangat menghargai feedback Anda! Mohon luangkan waktu sebentar untuk berbagi pengalaman Anda
                    di Google Review. Ulasan Anda sangat membantu kami untuk terus meningkatkan layanan.
                </p>
                <a href="{{ $googleReviewUrl }}" class="review-button">
                    Tulis Review di Google
                </a>
            </div>

            <!-- Contact Info -->
            <div class="contact-info">
                <h4>Hubungi Kami</h4>
                <p>Jika Anda memiliki pertanyaan atau ingin melakukan booking lagi:</p>
                <p>📧 Email: <a href="mailto:kampungkopicamp@gmail.com">kampungkopicamp@gmail.com</a></p>
                <p>📱 WhatsApp: <a href="https://wa.me/62812340086554">+62 823-4008-6554</a></p>
                <p>🌐 Website: <a href="https://kampungkopicamp.com">kampungkopicamp.com</a></p>
            </div>

            <div class="message">
                Kami menantikan kedatangan Anda kembali di masa mendatang! 🏕️
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Kampung Kopi Camp</strong></p>
            <p>Pupuan, Bali, Indonesia</p>
            <p>© {{ date('Y') }} Kampung Kopi Camp. All rights reserved.</p>

            <div class="social-links">
                <a href="https://www.instagram.com/kampungkopi_camp">Instagram</a> |
                <a href="https://www.facebook.com/kampungkopicamp">Facebook</a> |
                <a href="https://www.tiktok.com/@kampungkopi_camp">TikTok</a>
            </div>
        </div>
    </div>
</body>

</html>
