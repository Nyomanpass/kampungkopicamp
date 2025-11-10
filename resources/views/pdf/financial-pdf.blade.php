{{-- filepath: resources/views/pdf/financial-report.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 20px;
            size: A4 portrait;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #2f2f2f;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #5b7042;
        }

        .header h1 {
            font-size: 20px;
            color: #5b7042;
            margin-bottom: 8px;
        }

        .header p {
            font-size: 9px;
            color: #666;
        }

        .metrics-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .metric-card {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            background: #f1f1ee;
            border-left: 3px solid #8ca67a;
            margin-right: 10px;
        }

        .metric-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
        }

        .metric-value {
            font-size: 14px;
            font-weight: bold;
            color: #5b7042;
            margin-top: 5px;
        }

        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #5b7042;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #e8e8e4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        table td {
            padding: 6px 8px;
            font-size: 9px;
            border-bottom: 1px solid #e8e8e4;
        }

        table tbody tr:nth-child(even) {
            background: #f1f1ee;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #e8e8e4;
            padding-top: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-paid {
            background: #e5f3e5;
            color: #4b7d6e;
        }

        .badge-pending {
            background: #fcf2e5;
            color: #a06a44;
        }

        .badge-void {
            background: #f8e8e5;
            color: #c2644f;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Period: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        <p>Generated: {{ $generatedAt }}</p>
    </div>

    {{-- Metrics Grid --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">Total Invoices</div>
            <div class="metric-value">{{ number_format($metrics['totalInvoices']) }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Revenue</div>
            <div class="metric-value">Rp {{ number_format($metrics['totalRevenue'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Paid</div>
            <div class="metric-value">Rp {{ number_format($metrics['totalPaid'], 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="metrics-grid" style="margin-top: 10px;">
        <div class="metric-card">
            <div class="metric-label">Total Pending</div>
            <div class="metric-value">Rp {{ number_format($metrics['totalPending'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Refunded</div>
            <div class="metric-value">Rp {{ number_format($metrics['totalRefunded'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Net Revenue</div>
            <div class="metric-value">Rp
                {{ number_format($metrics['totalRevenue'] - $metrics['totalRefunded'], 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Recent Invoices --}}
    <div class="section">
        <div class="section-title">Recent Invoices</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%">Invoice #</th>
                    <th style="width: 25%">Customer</th>
                    <th style="width: 20%" class="text-right">Amount</th>
                    <th style="width: 15%" class="text-center">Status</th>
                    <th style="width: 25%">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentInvoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->booking?->customer_name ?? 'N/A' }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
                        </td>
                        <td>{{ $invoice->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color: #999;">No invoices available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent Payments --}}
    <div class="section">
        <div class="section-title">Recent Payments</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%">Order ID</th>
                    <th style="width: 25%">Customer</th>
                    <th style="width: 18%" class="text-right">Amount</th>
                    <th style="width: 12%" class="text-center">Provider</th>
                    <th style="width: 15%" class="text-center">Status</th>
                    <th style="width: 15%">Paid At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentPayments as $payment)
                    <tr>
                        <td>{{ $payment->order_id }}</td>
                        <td>{{ $payment->booking?->customer_name ?? 'N/A' }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                        </td>
                        <td class="text-center">{{ strtoupper($payment->provider) }}</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $payment->status === 'settlement' ? 'paid' : 'pending' }}">
                                {{ strtoupper($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color: #999;">No payments available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p><strong>Kampung Kopi Camp</strong> | Financial Report</p>
        <p>{{ now()->format('d M Y H:i:s') }} | Confidential Document</p>
    </div>
</body>

</html>
