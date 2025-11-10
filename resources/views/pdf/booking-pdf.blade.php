<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* Same base styles as financial-report.blade.php */
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

        /* Copy all styles from financial-report.blade.php */
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
            <div class="metric-label">Total Bookings</div>
            <div class="metric-value">{{ number_format($metrics['totalBookings']) }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Completed</div>
            <div class="metric-value">{{ number_format($metrics['completedBookings']) }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Cancelled</div>
            <div class="metric-value">{{ number_format($metrics['cancelledBookings']) }}</div>
        </div>
    </div>

    <div class="metrics-grid" style="margin-top: 10px;">
        <div class="metric-card">
            <div class="metric-label">Conversion Rate</div>
            <div class="metric-value">{{ number_format($metrics['conversionRate'], 1) }}%</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">Avg Booking Value</div>
            <div class="metric-value">Rp {{ number_format($metrics['averageBookingValue'], 0, ',', '.') }}</div>
        </div>
        <div class="metric-card">
            <div class="metric-label">No-Show Rate</div>
            <div class="metric-value">{{ number_format($metrics['noShowRate'], 1) }}%</div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="section">
        <div class="section-title">Top Products by Bookings</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 40%">Product Name</th>
                    <th style="width: 20%">Type</th>
                    <th style="width: 15%" class="text-center">Bookings</th>
                    <th style="width: 20%" class="text-center">Qty Sold</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topProducts as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ ucfirst($product->type) }}</td>
                        <td class="text-center"><strong>{{ $product->bookings_count }}</strong></td>
                        <td class="text-center"><strong>{{ $product->total_qty }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color: #999;">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Status Breakdown --}}
    <div class="section">
        <div class="section-title">Booking Status Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 50%">Status</th>
                    <th style="width: 25%" class="text-center">Count</th>
                    <th style="width: 25%" class="text-right">Total Value</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($statusBreakdown as $status)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $status->status)) }}</td>
                        <td class="text-center"><strong>{{ $status->count }}</strong></td>
                        <td class="text-right"><strong>Rp
                                {{ number_format($status->total_value, 0, ',', '.') }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center" style="color: #999;">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><strong>Kampung Kopi Camp</strong> | Booking Report</p>
        <p>{{ now()->format('d M Y H:i:s') }} | Confidential Document</p>
    </div>
</body>

</html>
