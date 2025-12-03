{{-- filepath: resources/views/livewire/admin/reports/customers.blade.php --}}

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Customer Reports</h1>
            <p class="text-sm text-gray-600 mt-1">Customer insights and analytics</p>
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

    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Filter</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Month Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Periode</label>
                <select wire:model.live="selectedMonth"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    <option value="0">Keseluruhan</option>
                    <option value="13">1 Tahun Penuh</option>
                    <option disabled>──────────</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>

            {{-- Year Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                <select wire:model.live="selectedYear"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    @for ($year = now()->year; $year >= 2020; $year--)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>

        {{-- Date Range Display --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                <i class="fas fa-calendar-alt mr-2"></i>
                Menampilkan data <strong>{{ $monthName }}</strong> tahun <strong>{{ $selectedYear }}</strong>
                <span class="text-gray-400 mx-2">|</span>
                <span class="text-xs">
                    {{ Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                    {{ Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </span>
            </p>
        </div>
    </div>

    {{-- Metrics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        {{-- Total Customers --}}
        <div class="bg-gradient-to-br from-info to-info/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Customer</p>
            <p class="text-2xl font-bold">{{ number_format($totalCustomers) }}</p>
        </div>

        {{-- New Customers --}}
        <div class="bg-gradient-to-br from-success to-success/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Customer Baru</p>
            <p class="text-2xl font-bold">{{ number_format($newCustomers) }}</p>
        </div>

        {{-- Active Customers --}}
        <div class="bg-gradient-to-br from-info-2 to-info-2/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-user-check text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Customer Aktif</p>
            <p class="text-2xl font-bold">{{ number_format($activeCustomers) }}</p>
        </div>

        {{-- Returning Customers --}}
        <div class="bg-gradient-to-br from-accent to-accent/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-redo text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Returning</p>
            <p class="text-2xl font-bold">{{ number_format($returningCustomers) }}</p>
        </div>

        {{-- Retention Rate --}}
        <div class="bg-gradient-to-br from-status-expired to-status-expired/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-percentage text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Retention Rate</p>
            <p class="text-2xl font-bold">{{ number_format($customerRetentionRate, 1) }}%</p>
        </div>

        {{-- Avg Lifetime Value --}}
        <div class="bg-gradient-to-br from-light-primary to-light-primary/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Avg Lifetime Value</p>
            <p class="text-2xl font-bold">Rp {{ number_format($averageLifetimeValue / 1000) }}K</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="customerCharts()" x-init="init()"
        wire:key="customer-charts-{{ $selectedMonth }}-{{ $selectedYear }}">
        {{-- New Customers Trend --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-primary"></i>
                Trend Customer Baru
            </h3>
            <div id="newCustomersTrendChart" x-ref="trendChart"></div>
        </div>
    </div>

    {{-- Customer Segments --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($customerSegments as $segment)
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-{{ $segment['color'] }}/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-{{ $segment['color'] }} text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">{{ number_format($segment['count']) }}</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">{{ $segment['name'] }}</h4>
                <p class="text-xs text-gray-500">{{ $segment['description'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Tables Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Spenders --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-500"></i>
                Top 10 Spenders
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bookings</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total Spent
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($topSpenders as $index => $customer)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span
                                        class="w-8 h-8 rounded-full 
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $index === 1 ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $index === 2 ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $index > 2 ? 'bg-primary/10 text-primary' : '' }}
                                        font-bold inline-flex items-center justify-center text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                    {{ $customer->total_bookings }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900 text-sm">Rp
                                        {{ number_format($customer->total_spent ?? 0) }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p class="text-sm">No data available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Customers --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-user-plus text-primary"></i>
                Customer Terbaru
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Joined</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bookings</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Spent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentCustomers as $customer)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-900">{{ $customer->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $customer->total_bookings ?? 0 }}
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900 text-sm">Rp
                                        {{ number_format($customer->total_spent ?? 0) }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function customerCharts() {
        return {
            charts: {
                trend: null
            },

            init() {
                console.log('Alpine Customer Charts: Initializing...');
                this.renderCharts();

                // Listen to Livewire event
                this.$wire.on('chartDataUpdated', () => {
                    console.log('Alpine Customer: Chart data updated, re-rendering...');
                    this.renderCharts();
                });

                // Watch for filter changes
                this.$watch('$wire.selectedMonth', () => {
                    console.log('Alpine Customer: Month changed, re-rendering...');
                    setTimeout(() => this.renderCharts(), 100);
                });

                this.$watch('$wire.selectedYear', () => {
                    console.log('Alpine Customer: Year changed, re-rendering...');
                    setTimeout(() => this.renderCharts(), 100);
                });
            },

            destroyCharts() {
                Object.values(this.charts).forEach(chart => {
                    if (chart) {
                        try {
                            chart.destroy();
                        } catch (e) {
                            console.log('Error destroying chart:', e);
                        }
                    }
                });
            },

            async renderCharts() {
                console.log('Alpine Customer: Rendering charts...');
                this.destroyCharts();

                // Get data from Livewire component using $wire
                const newCustomersTrendData = this.$wire.newCustomersTrendData;

                console.log('Alpine Customer: Chart data:', {
                    trend: newCustomersTrendData
                });

                // New Customers Trend Chart
                if (this.$refs.trendChart && newCustomersTrendData?.categories?.length > 0) {
                    this.charts.trend = new ApexCharts(this.$refs.trendChart, {
                        series: [{
                            name: 'New Customers',
                            data: newCustomersTrendData.data || []
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: {
                                show: true
                            }
                        },
                        colors: ['#5b7042'],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
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
                            categories: newCustomersTrendData.categories || []
                        }
                    });
                    this.charts.trend.render();
                } else if (this.$refs.trendChart) {
                    this.$refs.trendChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-line text-4xl mr-3"></i>' +
                        '<span>Tidak ada data customer baru</span></div>';
                }
            }
        }
    }
</script>
