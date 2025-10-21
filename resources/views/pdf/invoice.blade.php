<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->getInvoiceNumber() }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2d6a4f;
            color: white;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background: #f0f0f0;
        }

        .footer {
            margin-top: 50px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>KAMPUNG KOPI CAMP</h1>
        <p>Pupuan, Tabanan, Bali</p>
        <p>WhatsApp: +62 813-3737-1234 | Email: info@kampungkopi.camp</p>
    </div>

    <div class="invoice-info">
        <table style="border: none;">
            <tr>
                <td style="border: none;"><strong>INVOICE:</strong> {{ $invoice->getInvoiceNumber() }}</td>
                <td style="border: none;" class="text-right"><strong>Tanggal:</strong> {{ now()->format('d M Y') }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Kepada:</strong><br>
        {{ $booking->customer_name }}<br>
        {{ $booking->customer_email }}<br>
        {{ $booking->customer_phone }}
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Detail Booking:</strong><br>
        Booking Code: <strong>{{ $booking->booking_token }}</strong><br>
        Check-in: {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}<br>
        Check-out: {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}<br>
        Durasi: {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }} malam
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Status Pembayaran: LUNAS</strong></p>
        <p>Tanggal Pembayaran: {{ $booking->payments()->latest()->first()->paid_at->format('d M Y H:i') }}</p>
    </div>

    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda. Sampai jumpa di Kampung Kopi Camp!</p>
        <p>Simpan invoice ini sebagai bukti pembayaran yang sah.</p>
    </div>
</body>

</html>
