<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }} - {{ $startDate }} to {{ $endDate }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #6d9e72 0%, #5b7042 100%);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .header .subtitle {
            font-size: 12px;
            opacity: 0.9;
        }

        .header .date-range {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 11px;
        }

        .metrics-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .metrics-row {
            display: table-row;
        }

        .metric-card {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            vertical-align: top;
        }

        .metric-card:not(:last-child) {
            border-right: none;
        }

        .metric-card .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .metric-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #6d9e72;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #6d9e72;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }

        table thead {
            background: #6d9e72;
            color: white;
        }

        table thead th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
        }

        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-gold {
            background: #ffd700;
            color: #333;
        }

        .badge-silver {
            background: #c0c0c0;
            color: #333;
        }

        .badge-bronze {
            background: #cd7f32;
            color: white;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 9px;
        }

        .page-break {
            page-break-after: always;
        }

        .highlight-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 15px 0;
            border-radius: 4px;
        }

        .highlight-box .title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 5px;
        }

        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .stats-col {
            display: table-cell;
            width: 50%;
            padding: 8px;
        }

        .stats-col:first-child {
            border-right: 1px solid #e0e0e0;
        }

        .stats-label {
            font-size: 9px;
            color: #666;
            margin-bottom: 3px;
        }

        .stats-value {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="subtitle">Laporan Analisa Customer dan Segmentasi</div>
        <div class="date-range">
            <strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
        </div>
    </div>

    {{-- Metrics Cards --}}
    <div class="metrics-grid">
        <div class="metrics-row">
            <div class="metric-card">
                <div class="label">Total Customers</div>
                <div class="value">{{ number_format($metrics['totalCustomers']) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">New Customers</div>
                <div class="value">{{ number_format($metrics['newCustomers']) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Active Customers</div>
                <div class="value">{{ number_format($metrics['activeCustomers']) }}</div>
            </div>
        </div>
    </div>

    <div class="metrics-grid" style="margin-top: 10px;">
        <div class="metrics-row">
            <div class="metric-card">
                <div class="label">Returning Customers</div>
                <div class="value">{{ number_format($metrics['returningCustomers']) }}</div>
            </div>
            <div class="metric-card">
                <div class="label">Retention Rate</div>
                <div class="value">{{ number_format($metrics['customerRetentionRate'], 1) }}%</div>
            </div>
            <div class="metric-card">
                <div class="label">Avg Lifetime Value</div>
                <div class="value">Rp {{ number_format($metrics['averageLifetimeValue'] / 1000) }}K</div>
            </div>
        </div>
    </div>

    {{-- Highlight Box --}}
    <div class="highlight-box">
        <div class="title">Key Insights</div>
        <div style="font-size: 10px; color: #856404;">
            • Customer retention rate:
            <strong>{{ number_format($metrics['customerRetentionRate'], 1) }}%</strong><br>
            • Average lifetime value per customer:
            <strong>Rp {{ number_format($metrics['averageLifetimeValue']) }}</strong><br>
            • New customers in this period: <strong>{{ number_format($metrics['newCustomers']) }}</strong> from
            {{ number_format($metrics['totalCustomers']) }} total
        </div>
    </div>

    {{-- Top Spenders --}}
    <div class="section-title">🏆 Top 10 Spenders</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Customer Name</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;" class="text-center">Total Bookings</th>
                <th style="width: 25%;" class="text-right">Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topSpenders as $index => $customer)
                <tr>
                    <td class="text-center">
                        @if ($index < 3)
                            <span
                                class="badge {{ $index == 0 ? 'badge-gold' : ($index == 1 ? 'badge-silver' : 'badge-bronze') }}">
                                {{ $index + 1 }}
                            </span>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </td>
                    <td class="font-bold">{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td class="text-center">{{ number_format($customer->total_bookings ?? 0) }}</td>
                    <td class="text-right font-bold">Rp {{ number_format($customer->total_spent ?? 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #999;">
                        No customer data available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Page Break --}}
    <div class="page-break"></div>

    {{-- Recent Customers --}}
    <div class="section-title">👥 Recent Customers (Last {{ $metrics['newCustomers'] }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Customer Name</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 15%;">Joined Date</th>
                <th style="width: 10%;" class="text-center">Bookings</th>
                <th style="width: 20%;" class="text-right">Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentCustomers as $index => $customer)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                    <td class="text-center">{{ number_format($customer->total_bookings ?? 0) }}</td>
                    <td class="text-right">Rp {{ number_format($customer->total_spent ?? 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #999;">
                        No recent customers
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Customer Statistics Summary --}}
    <div class="section-title">📊 Customer Statistics</div>
    <div class="stats-row">
        <div class="stats-col">
            <div class="stats-label">Total Revenue from All Customers</div>
            <div class="stats-value">Rp
                {{ number_format($metrics['averageLifetimeValue'] * ($topSpenders->count() > 0 ? $topSpenders->count() : 1)) }}
            </div>
        </div>
        <div class="stats-col">
            <div class="stats-label">Average Revenue per Customer</div>
            <div class="stats-value">Rp {{ number_format($metrics['averageLifetimeValue']) }}</div>
        </div>
    </div>

    <div class="stats-row">
        <div class="stats-col">
            <div class="stats-label">Customer Growth Rate</div>
            <div class="stats-value">
                @php
                    $growthRate =
                        $metrics['totalCustomers'] > 0
                            ? ($metrics['newCustomers'] / $metrics['totalCustomers']) * 100
                            : 0;
                @endphp
                {{ number_format($growthRate, 2) }}%
            </div>
        </div>
        <div class="stats-col">
            <div class="stats-label">Active Customer Rate</div>
            <div class="stats-value">
                @php
                    $activeRate =
                        $metrics['totalCustomers'] > 0
                            ? ($metrics['activeCustomers'] / $metrics['totalCustomers']) * 100
                            : 0;
                @endphp
                {{ number_format($activeRate, 2) }}%
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <div>Generated on: {{ $generatedAt }}</div>
        <div style="margin-top: 5px;">© {{ date('Y') }} Kampung Kopi Camp - Customer Report</div>
    </div>
</body>

</html>
