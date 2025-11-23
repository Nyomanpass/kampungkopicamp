{{-- filepath: resources/views/pdf/invoice.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 24px;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 3px solid #5b7042;
            padding-bottom: 15px;
        }

        .company-info {
            float: left;
            width: 50%;
        }

        .company-info h1 {
            font-size: 20px;
            color: #5b7042;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .company-info p {
            font-size: 9px;
            color: #2f2f2f;
            line-height: 1.5;
        }

        .invoice-info {
            float: right;
            width: 45%;
            text-align: right;
        }

        .invoice-info h2 {
            font-size: 22px;
            color: #5b7042;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .invoice-info p {
            margin: 2px 0;
            font-size: 9px;
            color: #2f2f2f;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .customer-section {
            margin: 15px 0;
        }

        .customer-section h3 {
            font-size: 11px;
            margin-bottom: 8px;
            color: #5b7042;
            font-weight: bold;
        }

        .customer-details {
            background: #f1f1ee;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #8ca67a;
        }

        .customer-details p {
            margin: 3px 0;
            font-size: 9px;
        }

        .booking-details {
            margin: 15px 0;
            background: #eadfc8;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #c39b77;
        }

        .booking-details h4 {
            font-size: 11px;
            margin-bottom: 8px;
            color: #5b7042;
            font-weight: bold;
        }

        .booking-info-grid {
            display: table;
            width: 100%;
        }

        .booking-info-item {
            display: table-cell;
            width: 50%;
            padding: 3px 0;
            font-size: 9px;
        }

        .label {
            font-weight: bold;
            color: #2f2f2f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table thead {
            background: #5b7042;
            color: white;
        }

        table th {
            padding: 8px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }

        table tbody tr {
            border-bottom: 1px solid #e8e8e4;
        }

        table td {
            padding: 6px 8px;
            font-size: 9px;
        }

        table tbody tr:nth-child(even) {
            background: #f1f1ee;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 15px;
            float: right;
            width: 250px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #e8e8e4;
            font-size: 9px;
        }

        .totals-row.total {
            font-size: 13px;
            font-weight: bold;
            color: #5b7042;
            border-top: 2px solid #5b7042;
            border-bottom: 2px solid #5b7042;
            margin-top: 8px;
            padding: 10px 0;
        }

        .footer {
            position: absolute;
            bottom: 30px;
            left: 30px;
            right: 30px;
            padding-top: 15px;
            border-top: 2px solid #e8e8e4;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
        }

        .status-paid {
            background: #e5f3e5;
            color: #4b7d6e;
        }

        .status-pending {
            background: #fcf2e5;
            color: #a06a44;
        }

        .status-void {
            background: #f8e8e5;
            color: #c2644f;
        }

        .payment-info {
            margin: 15px 0;
            background: #e4f3f0;
            padding: 10px;
            border-left: 3px solid #60b2a1;
            border-radius: 4px;
        }

        .payment-info h4 {
            font-size: 11px;
            margin-bottom: 6px;
            color: #5b7042;
            font-weight: bold;
        }

        .payment-info p {
            margin: 2px 0;
            font-size: 9px;
        }

        .notes {
            margin-top: 15px;
            background: #fcf2e5;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #e0a15a;
        }

        .notes h4 {
            font-size: 11px;
            margin-bottom: 6px;
            color: #a06a44;
            font-weight: bold;
        }

        .notes p {
            font-size: 9px;
            color: #2f2f2f;
        }

        .content-wrapper {
            min-height: calc(297mm - 120px);
        }

        .payment-status-settlement {
            background: #e5f3e5;
            color: #4b7d6e;
        }

        .payment-status-pending {
            background: #fcf2e5;
            color: #a06a44;
        }

        .payment-status-cancel,
        .payment-status-expire {
            background: #f8e8e5;
            color: #c2644f;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        {{-- Header --}}
        <div class="header clearfix">
            <div class="company-info">
                <h1>Kampung Kopi Camp</h1>
                <p> Jl. Raya Pupuan, Batungsel, </p>
                <p>Pupuan, Tabanan, Bali 82163</p>
                <p>Phone: +62 812-3456-7890</p>
                <p>Email: info@kampungkopicamp.com</p>
                <p>Website: www.kampungkopicamp.com</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                <p><strong>Invoice Date:</strong> {{ $invoice->created_at->format('d M Y') }}</p>
                <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $invoice->type)) }}</p>
                <p style="margin-top: 5px;">
                    <span class="status-badge status-{{ $invoice->status }}">
                        {{ strtoupper($invoice->status) }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Customer Information --}}
        <div class="customer-section">
            <h3>BILL TO:</h3>
            <div class="customer-details">
                <p><strong>{{ $booking->customer_name ?? ($booking->user->name ?? 'Guest') }}</strong></p>
                @if ($booking->customer_email ?? ($booking->user->email ?? null))
                    <p>📧 {{ $booking->customer_email ?? $booking->user->email }}</p>
                @endif
                @if ($booking->customer_phone)
                    <p>📱 {{ $booking->customer_phone }}</p>
                @endif
            </div>
        </div>

        {{-- Booking Details --}}
        <div class="booking-details">
            <h4>BOOKING DETAILS</h4>
            <div class="booking-info-grid">
                <div class="booking-info-item">
                    <span class="label">Booking Token:</span> {{ $booking->booking_token }}
                </div>
                <div class="booking-info-item">
                    <span class="label">Product Type:</span> {{ ucfirst($booking->product_type) }}
                </div>
            </div>
            <div class="booking-info-grid">
                <div class="booking-info-item">
                    <span class="label">Check-in Date:</span> {{ $booking->start_date->format('d M Y') }}
                </div>
                <div class="booking-info-item">
                    <span class="label">Check-out Date:</span> {{ $booking->end_date->format('d M Y') }}
                </div>
            </div>
            <div class="booking-info-grid">
                <div class="booking-info-item">
                    <span class="label">Duration:</span> {{ $booking->start_date->diffInDays($booking->end_date) }}
                    night(s)
                </div>
                <div class="booking-info-item">
                    <span class="label">Number of Guests:</span> {{ $booking->people_count }} person(s)
                </div>
            </div>
        </div>

        {{-- Invoice Items --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 45%">Item Description</th>
                    <th style="width: 12%" class="text-right">Qty</th>
                    <th style="width: 18%" class="text-right">Unit Price</th>
                    <th style="width: 20%" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->name }}</strong>
                            @if ($item->meta && isset($item->meta['item_type']))
                                <br><small style="color: #666; font-size: 8px;">Type:
                                    {{ ucfirst($item->meta['item_type']) }}</small>
                            @endif
                        </td>
                        <td class="text-right">{{ $item->qty }}</td>
                        <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="clearfix">
            <div class="totals">
                <div class="totals-row">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                </div>
                @if ($booking->discount_total > 0)
                    <div class="totals-row">
                        <span>Discount:</span>
                        <span style="color: #c2644f;">- Rp
                            {{ number_format($booking->discount_total, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="totals-row total">
                    <span>TOTAL:</span>
                    <span>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Payment Information --}}
        @if ($payment)
            <div class="payment-info clearfix" style="margin-top: 50px;">
                <h4>PAYMENT INFORMATION</h4>
                <div class="booking-info-grid">
                    <div class="booking-info-item">
                        <span class="label">Payment Method:</span>
                        @php
                            // decode raw_payload safely
                            $raw_payload = $payment->raw_payload;
                            if (is_string($raw_payload)) {
                                $decoded_raw_payload = json_decode($raw_payload, true);
                            } elseif (is_object($raw_payload)) {
                                $decoded_raw_payload = json_decode(json_encode($raw_payload), true);
                            } else {
                                $decoded_raw_payload = $raw_payload ?? [];
                            }
                            $paymentType = $decoded_raw_payload['payment_type'] ?? ($payment->payment_type ?? 'N/A');
                            $paymentType = str_replace('_', ' ', $paymentType);
                        @endphp
                        {{ strtoupper($paymentType) }}
                    </div>
                    <div class="booking-info-item">
                        <span class="label">Payment Status:</span>
                        <span class="">
                            {{ strtoupper($payment->status) }}
                        </span>
                    </div>
                </div>
                <div class="booking-info-grid">
                    <div class="booking-info-item">
                        <span class="label">Order ID:</span> {{ $payment->order_id }}
                    </div>
                    <div class="booking-info-item">
                        <span class="label">Paid At:</span>
                        {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : 'Pending' }}
                    </div>
                </div>
            </div>
        @endif

        {{-- Special Requests / Notes --}}
        @if ($booking->special_requests)
            <div class="notes">
                <h4>SPECIAL REQUESTS</h4>
                <p>{{ $booking->special_requests }}</p>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p style="font-size: 9px; margin-bottom: 5px;"><strong>Thank you for choosing Kampung Kopi Camp!</strong></p>
        <p style="margin-bottom: 3px;">This is a computer-generated invoice and does not require a signature.</p>
        <p style="margin-bottom: 3px;">For inquiries, please contact us at info@kampungkopicamp.com or +62
            812-3456-7890</p>
        <p style="margin-top: 8px; font-size: 7px; color: #999;">Document generated on
            {{ now()->format('d M Y H:i:s') }} | {{ $invoice->invoice_number }}</p>
    </div>
</body>

</html>
