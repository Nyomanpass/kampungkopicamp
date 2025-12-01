<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Booking</h1>
            <p class="text-sm text-gray-600 mt-1">Detail Analisa booking</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Export Buttons --}}
            <button wire:click="exportExcel" wire:loading.attr="disabled"
                class="px-4 py-2 bg-success hover:bg-success/80 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-file-excel"></i>
                <span class="hidden md:inline">Excel</span>
            </button>
            <button wire:click="exportPDF" wire:loading.attr="disabled"
                class="px-4 py-2 bg-danger hover:bg-danger/80 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fas fa-file-pdf"></i>
                <span class="hidden md:inline">PDF</span>
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Filter</h3>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Date Range --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Rentang Tanggal</label>
                <select wire:model.live="dateRange"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    <option value="today">Today</option>
                    <option value="week">Last 7 Days</option>
                    <option value="month">Last 30 Days</option>
                    <option value="quarter">Last 3 Months</option>
                    <option value="year">Last Year</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>

            {{-- Custom Dates --}}
            @if ($dateRange === 'custom')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
                    <input type="date" wire:model="customStartDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
                    <input type="date" wire:model="customEndDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                </div>

                <div class="flex items-end">
                    <button wire:click="applyCustomDateRange"
                        class="w-full px-4 py-2 bg-primary hover:bg-light-primary text-white rounded-lg font-semibold transition-all text-sm">
                        Apply
                    </button>
                </div>
            @endif

            {{-- Status Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select wire:model.live="statusFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="">Semua Status</option>
                    <option value="draft">Draft</option>
                    <option value="pending_payment">Menunggu Pembayaran</option>
                    <option value="paid">Dibayar</option>
                    <option value="checked_in">Check In</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                    <option value="refunded">Dikembalikan</option>
                    <option value="no_show">Tidak Hadir</option>
                    <option value="expired">Kedaluwarsa</option>
                </select>
            </div>

            {{-- Product Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Product</label>
                <select wire:model.live="productFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    <option value="">All Products</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Date Range Display --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                <i class="fas fa-calendar-alt mr-2"></i>
                Menampilkan data dari
                <strong>{{ Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong>
                hingga
                <strong>{{ Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>
            </p>
        </div>
    </div>

    {{-- Metrics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        {{-- Total Bookings --}}
        <div class="bg-gradient-to-br from-info to-info/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-calendar-check text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Booking</p>
            <p class="text-2xl font-bold">{{ $totalBookings }}</p>
        </div>

        {{-- Completed Bookings --}}
        <div class="bg-gradient-to-br from-success to-success/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Completed (Check Out)</p>
            <p class="text-2xl font-bold">{{ $completedBookings }}</p>
        </div>

        {{-- Cancelled Bookings --}}
        <div class="bg-gradient-to-br from-danger to-danger/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Cancelled</p>
            <p class="text-2xl font-bold">{{ $cancelledBookings }}</p>
        </div>

        {{-- Conversion Rate --}}
        <div class="bg-gradient-to-br from-status-refunded to-status-refunded/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-percentage text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Tingkat Konversi</p>
            <p class="text-2xl font-bold">{{ number_format($conversionRate, 1) }}%</p>
        </div>

        {{-- Average Booking Value --}}
        <div class="bg-gradient-to-br from-accent to-accent/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Nilai Rata-Rata Booking</p>
            <p class="text-2xl font-bold">Rp {{ number_format($averageBookingValue / 1000) }}K</p>
        </div>

        {{-- No-Show Rate --}}
        <div class="bg-gradient-to-br from-status-draft to-status-draft/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-user-slash text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">No-Show Rate</p>
            <p class="text-2xl font-bold">{{ number_format($noShowRate, 1) }}%</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Daily Bookings Trend --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-primary"></i>
                Tren Booking Harian
            </h3>
            <div id="dailyBookingsChart"></div>
        </div>

        {{-- Booking Status Distribution --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-primary"></i>
                Distribusi Status Booking
            </h3>
            <div id="bookingStatusChart"></div>
        </div>

        {{-- Bookings by Product --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary"></i>
                10 Produk Teratas berdasarkan Booking
            </h3>
            <div id="bookingsByProductChart"></div>
        </div>

        {{-- Occupancy Rate --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-area text-primary"></i>
                Tingkat Hunian berdasarkan Produk
            </h3>
            <div id="occupancyRateChart"></div>
        </div>
    </div>

    {{-- Tables Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Products Table --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-500"></i>
                Produk Teratas berdasarkan Booking
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produk
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tipe</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Booking
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($topProducts as $index => $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span
                                        class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold inline-flex items-center justify-center text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $product->name }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $product->type === 'glamping' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($product->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    {{ $product->bookings_count }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $product->total_qty }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p class="text-sm">Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Status Breakdown Table --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-list-alt text-primary"></i>
                Rincian Status
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Count
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total
                                Value
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($statusBreakdown as $status)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $status->status === 'paid' ? 'bg-success/10 text-success' : '' }}
                                        {{ $status->status === 'pending_payment' ? 'bg-warning/10 text-warning' : '' }}
                                        {{ $status->status === 'checked_in' ? 'bg-status-checkedin-bg text-status-checkedbg-status-checkedin' : '' }}
                                        {{ $status->status === 'completed' ? 'bg-status-completed-bg text-status-ombg-status-completed' : '' }}
                                        {{ $status->status === 'cancelled' ? 'bg-status-cancelled-bg text-status-cancelled' : '' }}
                                        {{ $status->status === 'refunded' ? 'bg-status-refunded-bg text-status-refubg-status-refunded' : '' }}
                                        {{ $status->status === 'no_show' ? 'bg-status-noshow-bg text-status-noshow' : '' }}
                                        {{ $status->status === 'draft' ? 'bg-status-draft-bg text-status-draft' : '' }}
                                        {{ $status->status === 'expired' ? 'bg-status-expired-bg text-status-ebg-status-expired' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $status->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    {{ $status->count }}
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                    Rp {{ number_format($status->total_value) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p class="text-sm">No data available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Upcoming Bookings --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-calendar-check text-primary"></i>
                Booking Mendatang (7 Hari Ke Depan)
            </h3>
            <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                {{ $upcomingBookings->count() }} booking
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Booking Token
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Check-in Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($upcomingBookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900 text-sm">{{ $booking->booking_token }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">{{ $booking->customer_name }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->customer_phone }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">
                                    {{ $booking->items->first()?->product?->name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-blue-600">
                                    {{ Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ Carbon\Carbon::parse($booking->start_date)->diffForHumans() }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900">Rp {{ number_format($booking->total_price) }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <a href="/admin/bookings?view=detail&id={{ $booking->id }}"
                                    class="px-3 py-1 bg-primary hover:bg-light-primary text-white text-xs rounded-lg font-semibold transition-all inline-flex items-center gap-1">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-calendar-times text-4xl mb-2"></i>
                                <p class="text-sm">No upcoming bookings</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:navigated', function() {
        initBookingCharts();
    });

    Livewire.on('dataUpdated', () => {
        initBookingCharts();
    });

    function initBookingCharts() {
        // Daily Bookings Chart
        const dailyBookingsOptions = {
            series: [{
                name: 'Bookings',
                data: @js($dailyBookingsData['data'])
            }],
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            colors: ['#5f91a7'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 5,
                hover: {
                    size: 7
                }
            },
            xaxis: {
                categories: @js($dailyBookingsData['categories'])
            },
            yaxis: {
                title: {
                    text: 'Number of Bookings'
                }
            }
        };
        new ApexCharts(document.querySelector("#dailyBookingsChart"), dailyBookingsOptions).render();

        // Booking Status Chart
        const statusOptions = {
            series: @js($bookingStatusData['data']),
            chart: {
                type: 'donut',
                height: 350
            },
            labels: @js($bookingStatusData['labels']),
            colors: ['#c2644f', '#6d9e72', '#4b7d6e', '#b1b1a4', '#e0a15a', '#a06a44', '#85b582', '#e0a15a',
                '#5da6a4'
            ],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#bookingStatusChart"), statusOptions).render();

        // Bookings by Product Chart
        const productOptions = {
            series: [{
                name: 'Bookings',
                data: @js($bookingsByProductData['data'])
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ['#60b2a1'],
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @js($bookingsByProductData['categories'])
            }
        };
        new ApexCharts(document.querySelector("#bookingsByProductChart"), productOptions).render();

        // Occupancy Rate Chart
        const occupancyOptions = {
            series: [{
                name: 'Occupancy Rate',
                data: @js(array_column($occupancyRateData, 'rate'))
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ['#10b981'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 4,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val.toFixed(1) + '%';
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ['#304758']
                }
            },
            xaxis: {
                categories: @js(array_column($occupancyRateData, 'name'))
            },
            yaxis: {
                title: {
                    text: 'Occupancy Rate (%)'
                },
                max: 100
            }
        };
        new ApexCharts(document.querySelector("#occupancyRateChart"), occupancyOptions).render();
    }
</script>
