<div class="space-y-6 p-6 bg-white rounedd-lg shadow">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">Selamat Datang Kembali! Ini Informasi Ringkas Hari ini.</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Date Range Filter --}}
            <select wire:model.live="dateRange"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>

            {{-- Refresh Button --}}
            <button wire:click="refreshData"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all text-sm flex items-center gap-2">
                <i class="fas fa-sync-alt"></i>
                <span class="hidden md:inline">Refresh</span>
            </button>
        </div>
    </div>


    {{-- Flash Messages (reuse toast component) --}}
    <div class="fixed top-4 right-4 z-50 w-96 max-w-[calc(100vw-2rem)] space-y-3">
        @if (session()->has('success'))
            <div wire:key="success-{{ md5(session('success') . microtime()) }}" x-data="{
                show: false,
                progress: 100,
                duration: 4000,
                init() {
                    this.$nextTick(() => { this.show = true; });
                    const step = 100 / (this.duration / 50);
                    const interval = setInterval(() => {
                        this.progress = Math.max(0, this.progress - step);
                        if (this.progress <= 0) {
                            clearInterval(interval);
                            this.close();
                        }
                    }, 50);
                },
                close() {
                    this.show = false;
                    setTimeout(() => this.$el.remove(), 300);
                }
            }" x-show="show"
                x-cloak x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="relative rounded-xl border border-green-200 bg-gradient-to-br from-green-50 to-white text-green-800 shadow-lg ring-1 ring-green-100">
                <div class="flex items-start gap-3 p-4">
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                    <div class="flex-1">
                        <p class="font-medium">Success</p>
                        <p class="text-sm opacity-90">{{ session('success') }}</p>
                    </div>
                    <button @click="close()" class="p-1.5 rounded-md text-green-700 hover:bg-green-100/60">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="absolute left-0 bottom-0 h-1 bg-green-200/60 w-full overflow-hidden rounded-b-xl">
                    <div class="h-full bg-green-500 transition-all ease-linear" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div wire:key="error-{{ md5(session('error') . microtime()) }}" x-data="{
                show: false,
                progress: 100,
                duration: 5000,
                init() {
                    this.$nextTick(() => { this.show = true; });
                    const step = 100 / (this.duration / 50);
                    const interval = setInterval(() => {
                        this.progress = Math.max(0, this.progress - step);
                        if (this.progress <= 0) {
                            clearInterval(interval);
                            this.close();
                        }
                    }, 50);
                },
                close() {
                    this.show = false;
                    setTimeout(() => this.$el.remove(), 300);
                }
            }" x-show="show"
                x-cloak x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="relative rounded-xl border border-red-200 bg-gradient-to-br from-red-50 to-white text-red-800 shadow-lg ring-1 ring-red-100">
                <div class="flex items-start gap-3 p-4">
                    <i class="fas fa-exclamation-circle text-2xl text-red-500"></i>
                    <div class="flex-1">
                        <p class="font-medium">Error</p>
                        <p class="text-sm opacity-90">{{ session('error') }}</p>
                    </div>
                    <button @click="close()" class="p-1.5 rounded-md text-red-700 hover:bg-red-100/60">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="absolute left-0 bottom-0 h-1 bg-red-200/60 w-full overflow-hidden rounded-b-xl">
                    <div class="h-full bg-red-500 transition-all ease-linear" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        @endif
    </div>

    {{-- Metrics Cards - Row 1: Financial --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Today's Revenue --}}
        <div class="bg-gradient-to-br from-success to-success/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full backdrop-blur-sm">Hari ini</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Pendapatan Harian</p>
            <p class="text-2xl font-bold">Rp {{ number_format($todayRevenue / 1000) }}K</p>
        </div>

        {{-- This Month Revenue --}}
        <div class="bg-gradient-to-br from-light-primary to-light-primary/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full backdrop-blur-sm">Bulan Ini</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Pendapatan Bulanan</p>
            <p class="text-2xl font-bold">Rp {{ number_format($monthRevenue / 1000) }}K</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-info to-info/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full backdrop-blur-sm">All Time</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue / 1000) }}K</p>
        </div>

        {{-- Pending Payments --}}
        <div class="bg-gradient-to-br from-warning to-warning/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <span class="text-xs bg-white/20 px-2 py-1 rounded-full backdrop-blur-sm">Pending</span>
            </div>
            <p class="text-sm opacity-90 mb-1">Pending Payments</p>
            <p class="text-2xl font-bold">Rp {{ number_format($pendingPayments / 1000) }}K</p>
        </div>
    </div>

    {{-- Metrics Cards - Row 2: Bookings --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Today's Bookings --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-light-primary/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-plus text-light-primary text-xl"></i>
                </div>
                <i class="fas fa-arrow-up text-light-primary text-sm"></i>
            </div>
            <p class="text-sm text-gray-600 mb-1">Booking Hari ini</p>
            <p class="text-3xl font-bold text-gray-900">{{ $todayBookings }}</p>
        </div>

        {{-- Active Bookings --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-light-primary/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-light-primary text-xl"></i>
                </div>
                <span
                    class="text-xs bg-light-primary/20 text-light-primary px-2 py-1 rounded-full font-semibold">Active</span>
            </div>
            <p class="text-sm  text-gray-600 mb-1">Booking Aktif</p>
            <p class="text-3xl font-bold text-gray-900">{{ $activeBookings }}</p>
        </div>

        {{-- Pending Bookings --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-light-primary/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-circle text-light-primary text-xl"></i>
                </div>
                <span
                    class="text-xs bg-light-primary/20 text-light-primary px-2 py-1 rounded-full font-semibold">Pending</span>
            </div>
            <p class="text-sm text-gray-600 mb-1">Pending Bookings</p>
            <p class="text-3xl font-bold text-gray-900">{{ $pendingBookings }}</p>
        </div>

        {{-- Total Bookings --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-light-primary/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-light-primary text-xl"></i>
                </div>
                <span class="text-xs bg-light-primary/20 text-light-primary px-2 py-1 rounded-full font-semibold">All
                    Time</span>
            </div>
            <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
        </div>
    </div>

    {{-- Metrics Cards - Row 3: Customers & Inventory --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Customers --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-info-2/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-info-2 text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-1">Total Customers</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalCustomers }}</p>
        </div>

        {{-- New Customers Today --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-info-2/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-plus text-info-2 text-xl"></i>
                </div>
                <span class="text-xs bg-info-2/20 text-info-2 px-2 py-1 rounded-full font-semibold">New</span>
            </div>
            <p class="text-sm text-gray-600 mb-1">Customer Hari ini</p>
            <p class="text-3xl font-bold text-gray-900">{{ $newCustomersToday }}</p>
        </div>

        {{-- Available Stock Today --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-accent/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-accent text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-1">Available Stock Today</p>
            <p class="text-3xl font-bold text-gray-900">{{ $availableStockToday }}</p>
        </div>

        {{-- Low Stock Alerts --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-danger/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-danger text-xl"></i>
                </div>
                @if ($lowStockAlerts > 0)
                    <span
                        class="text-xs bg-danger/20 text-danger px-2 py-1 rounded-full font-semibold animate-pulse">Alert</span>
                @endif
            </div>
            <p class="text-sm text-gray-600 mb-1">Low Stock Alerts</p>
            <p class="text-3xl font-bold text-gray-900">{{ $lowStockAlerts }}</p>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Revenue Trend Chart --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-primary"></i>
                Revenue Trend
            </h3>
            <div id="revenueTrendChart"></div>
        </div>



        {{-- Booking Status Chart --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-primary"></i>
                Booking Status Distribution
            </h3>
            <div id="bookingStatusChart"></div>
        </div>

        {{-- Revenue by Product Chart --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary"></i>
                Revenue by Product
            </h3>
            <div id="revenueByProductChart"></div>
        </div>

        {{-- Payment Methods Chart --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card text-primary"></i>
                Payment Methods
            </h3>
            <div id="paymentMethodsChart"></div>
        </div>
    </div>

    {{-- Lists Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Bookings --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-clock text-primary"></i>
                    Recent Bookings
                </h3>
                <a href="/admin/bookings" class="text-sm text-primary hover:text-light-primary font-semibold">View All
                    →</a>
            </div>

            @if ($recentBookings->count() > 0)
                <div class="space-y-3">
                    @foreach ($recentBookings as $booking)
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $booking->booking_token }}</p>
                                <p class="text-xs text-gray-600">{{ $booking->customer_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $booking->items->first()?->product?->name ?? 'N/A' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">Rp
                                    {{ number_format($booking->total_price / 1000) }}K</p>
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full mt-1
                                    {{ $booking->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $booking->status === 'pending_payment' ? 'bg-status-expired-bg text-status-expired' : '' }}
                                    {{ $booking->status === 'checked_in' ? 'bg-status-checkedin-bg text-status-checkedin' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p class="text-sm">No recent bookings</p>
                </div>
            @endif
        </div>

        {{-- Upcoming Check-ins --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-calendar-check text-primary"></i>
                    Upcoming Check-ins
                </h3>
                <span class="text-xs bg-info-light text-info px-2 py-1 rounded-full font-semibold">
                    {{ $upcomingCheckins->count() }} today/tomorrow
                </span>
            </div>

            @if ($upcomingCheckins->count() > 0)
                <div class="space-y-3">
                    @foreach ($upcomingCheckins->take(5) as $booking)
                        <div
                            class="flex items-center justify-between p-3 bg-info-light rounded-lg hover:bg-info/30 transition-colors">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $booking->customer_name }}</p>
                                <p class="text-xs text-gray-600">
                                    {{ $booking->items->first()?->product?->name ?? 'N/A' }}</p>
                                <p class="text-xs text-info-dark mt-1">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                </p>
                            </div>
                            <a href="/admin/bookings?view=detail&id={{ $booking->id }}"
                                class="px-3 py-1 bg-info hover:bg-info/80 text-white text-xs rounded-lg font-semibold transition-all">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-calendar-times text-4xl mb-2"></i>
                    <p class="text-sm">No upcoming check-ins</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Pending Payments & Low Stock --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pending Payments --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-warning"></i>
                    Pending Payments
                </h3>
                <a href="/admin/payments" class="text-sm text-primary hover:text-light-primary font-semibold">View All
                    →</a>
            </div>

            @if ($pendingPaymentsList->count() > 0)
                <div class="space-y-3">
                    @foreach ($pendingPaymentsList as $payment)
                        <div
                            class="flex items-center justify-between p-3 bg-warning/10 rounded-lg hover:bg-warning/30 transition-colors">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $payment->order_id }}</p>
                                <p class="text-xs text-gray-600">{{ $payment->booking->customer_name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $payment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 text-sm">Rp
                                    {{ number_format($payment->amount / 1000) }}K</p>
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-status-expired text-status-expired-bg mt-1">
                                    Pending
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-check-circle text-4xl mb-2"></i>
                    <p class="text-sm">All payments settled!</p>
                </div>
            @endif
        </div>

        {{-- Low Stock Alerts --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    Low Stock Alerts
                </h3>
                <a href="/admin/availability"
                    class="text-sm text-primary hover:text-light-primary font-semibold">Manage →</a>
            </div>

            @if ($lowStockItems->count() > 0)
                <div class="space-y-3">
                    @foreach ($lowStockItems as $item)
                        <div
                            class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-600">
                                    {{ Carbon\Carbon::parse($item->date)->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span
                                    class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-bold rounded-lg">
                                    @if ($item->product->type === 'touring')
                                        {{ $item->available_seat }} left
                                    @else
                                        {{ $item->available_unit }} left
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-box text-4xl mb-2"></i>
                    <p class="text-sm">All stock levels healthy!</p>
                </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:navigated', function() {
        initCharts();
    });

    function initCharts() {
        // Revenue Trend Chart
        const revenueTrendOptions = {
            series: [{
                name: 'Revenue',
                data: @js($revenueTrendData['data'])
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            colors: ['#10b981'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                }
            },
            xaxis: {
                categories: @js($revenueTrendData['categories'])
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                    }
                }
            }
        };
        const revenueTrendChart = new ApexCharts(document.querySelector("#revenueTrendChart"), revenueTrendOptions);
        revenueTrendChart.render();

        // Booking Status Chart
        const bookingStatusOptions = {
            series: @js($bookingStatusData['data']),
            chart: {
                type: 'donut',
                height: 300
            },
            labels: @js($bookingStatusData['labels']),
            colors: [
                '#c2644f', '#6d9e72', '#4b7d6e', '#b1b1a4', '#e0a15a', '#a06a44', '#6b7280'
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
        const bookingStatusChart = new ApexCharts(document.querySelector("#bookingStatusChart"), bookingStatusOptions);
        bookingStatusChart.render();

        // Revenue by Product Chart
        const revenueByProductOptions = {
            series: [{
                name: 'Revenue',
                data: @js($revenueByProductData['data'])
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            colors: ['#5f91a7'],
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
                categories: @js($revenueByProductData['categories']),
                labels: {
                    formatter: function(val) {
                        return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                    }
                }
            }

        };
        const revenueByProductChart = new ApexCharts(document.querySelector("#revenueByProductChart"),
            revenueByProductOptions);
        revenueByProductChart.render();

        // Payment Methods Chart
        const paymentMethodsOptions = {
            series: @js($paymentMethodsData['series']),
            chart: {
                type: 'donut',
                height: 300
            },
            labels: @js($paymentMethodsData['labels']),
            colors: ['#6d9e72', '#60b2a1', '#5f91a7'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: function(w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return 'Rp ' + (total / 1000).toFixed(0) + 'K';
                                }
                            }
                        }
                    }
                }
            }
        };
        const paymentMethodsChart = new ApexCharts(document.querySelector("#paymentMethodsChart"),
            paymentMethodsOptions);
        paymentMethodsChart.render();
    }
</script>
