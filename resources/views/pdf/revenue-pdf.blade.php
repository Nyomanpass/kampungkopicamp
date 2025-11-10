{{-- filepath: resources/views/pdf/revenue-report.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* Same styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }



        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #2f2f2f;
            margin: 24px;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Period: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        <p>Generated: {{ $generatedAt }}</p>
    </div>

    {{-- Metrics --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">Total Revenue</div>
            <div class="metric-value">Rp {{ number_format($metrics['totalRevenue'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Total Transactions</div>
            <div class="metric-value">{{ number_format($metrics['totalTransactions']) }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Avg Transaction</div>
            <div class="metric-value">Rp {{ number_format($metrics['averageTransactionValue'], 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="metrics-grid" style="margin-top: 10px;">
        <div class="metric-card">
            <div class="metric-label">Total Refunded</div>
            <div class="metric-value">Rp {{ number_format($metrics['totalRefunded'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card" style="border-left: 3px solid #5b7042;">
            <div class="metric-label">Net Revenue</div>
            <div class="metric-value">Rp {{ number_format($metrics['netRevenue'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <!-- Empty card for spacing -->
        </div>
    </div>

    {{-- Top Products --}}
    <div class="section">
        <div class="section-title">Top Products by Revenue</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 35%">Product Name</th>
                    <th style="width: 15%">Type</th>
                    <th style="width: 15%" class="text-center">Bookings</th>
                    <th style="width: 10%" class="text-center">Qty</th>
                    <th style="width: 20%" class="text-right">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ ucfirst($product->type) }}</td>
                        <td class="text-center">{{ $product->bookings_count }}</td>
                        <td class="text-center">{{ $product->total_qty }}</td>
                        <td class="text-right"><strong>Rp
                                {{ number_format($product->total_revenue, 0, ',', '.') }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="color: #999;">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><strong>Kampung Kopi Camp</strong> | Revenue Report</p>
        <p>{{ now()->format('d M Y H:i:s') }} | Confidential Document</p>
    </div>
</body>

</html>
