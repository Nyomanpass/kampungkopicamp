<div class="space-y-6 p-6 rounded-lg shadow bg-white">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Pendapatan</h1>
            <p class="text-sm text-gray-600 mt-1">Detail analisa Pendapatan</p>
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

            {{-- Product Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Produk</label>
                <select wire:model.live="productFilter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    <option value="">Semua Produk</option>
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
                Menampilkan data untuk
                @if ($selectedMonth == 0)
                    <strong>{{ $this->monthName }}</strong>
                @elseif($selectedMonth == 13)
                    <strong>{{ $this->monthName }} {{ $selectedYear }}</strong>
                @else
                    <strong>{{ $this->monthName }} {{ $selectedYear }}</strong>
                @endif
                ({{ Carbon\Carbon::parse($startDate)->format('d M Y') }} -
                {{ Carbon\Carbon::parse($endDate)->format('d M Y') }})
            </p>
        </div>
    </div>

    {{-- Metrics Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-light-primary to-light-primary/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue / 1000) }}K</p>
        </div>

        {{-- Total Transactions --}}
        <div class="bg-gradient-to-br from-info to-info/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Jumlah Transaksi</p>
            <p class="text-2xl font-bold">{{ $totalTransactions }}</p>
        </div>

        {{-- Average Transaction Value --}}
        <div
            class="bg-gradient-to-br from-status-completed to-status-completed/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Rata-rata Nilai Transaksi</p>
            <p class="text-2xl font-bold">Rp {{ number_format($averageTransactionValue / 1000) }}K</p>
        </div>

        {{-- Total Refunded --}}
        <div class="bg-gradient-to-br from-status-expired to-status-expired/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-undo text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Refund</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRefunded / 1000) }}K</p>
        </div>

        {{-- Net Revenue --}}
        <div class="bg-gradient-to-br from-info-2/70 to-info-2/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Pendapatan Bersih</p>
            <p class="text-2xl font-bold">Rp {{ number_format($netRevenue / 1000) }}K</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="revenueCharts()" x-init="init()"
        wire:key="revenue-charts-{{ $selectedMonth }}-{{ $selectedYear }}">
        {{-- Daily Revenue Trend --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-area text-primary"></i>
                Tren Pendapatan Harian
            </h3>
            <div id="dailyRevenueChart" x-ref="dailyChart"></div>
        </div>

        {{-- Revenue by Product Type --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-success"></i>
                Pendapatan Berdasarkan Tipe Produk
            </h3>
            <div id="revenueByProductTypeChart" x-ref="typeChart"></div>
        </div>

        {{-- Payment Methods --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card text-info"></i>
                Rincian Metode Pembayaran
            </h3>
            <div id="paymentMethodChart" x-ref="paymentChart"></div>
        </div>

        {{-- Revenue by Product --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary"></i>
                Top 10 Product berdasarkan Pendapatan
            </h3>
            <div id="revenueByProductChart" x-ref="productChart"></div>
        </div>
    </div>

    {{-- Top Products Table --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-trophy text-yellow-500"></i>
            Produk Teratas berdasarkan Pendapatan
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Product</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Bookings</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Qty Sold</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Revenue</th>
                    </tr>
                </thead>
                {{-- {{ dd($topProducts[0]) }} --}}
                <tbody class="divide-y divide-gray-200">
                    @forelse($topProducts as $index => $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="w-8 h-8 rounded-full bg-primary/10 text-primary font-bold inline-flex items-center justify-center text-sm">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $product->type === 'glamping' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($product->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->bookings_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->total_qty }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="font-bold text-gray-900">Rp {{ number_format($product->total_revenue) }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p class="text-sm">No revenue data available</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Revenue by Month (if applicable) --}}
    @if ($revenueByMonth->count() > 0)
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-primary"></i>
                Revenue by Month
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Month</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Transactions</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($revenueByMonth as $month)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-900">
                                        {{ Carbon\Carbon::parse($month->month . '-01')->format('F Y') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $month->transactions }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($month->revenue) }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function revenueCharts() {
        return {
            charts: {
                daily: null,
                product: null,
                type: null,
                payment: null
            },

            init() {
                console.log('Alpine Revenue Charts: Initializing...');
                this.renderCharts();

                // Listen to Livewire event
                this.$wire.on('chartDataUpdated', () => {
                    console.log('Alpine Revenue: Chart data updated, re-rendering...');
                    this.renderCharts();
                });

                // Watch for filter changes
                this.$watch('$wire.selectedMonth', () => {
                    console.log('Alpine Revenue: Month changed, re-rendering...');
                    setTimeout(() => this.renderCharts(), 100);
                });

                this.$watch('$wire.selectedYear', () => {
                    console.log('Alpine Revenue: Year changed, re-rendering...');
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
                console.log('Alpine Revenue: Rendering charts...');
                this.destroyCharts();

                // Get data from Livewire component using $wire
                const dailyRevenueData = this.$wire.dailyRevenueData;
                const revenueByProductData = this.$wire.revenueByProductData;
                const revenueByProductTypeData = this.$wire.revenueByProductTypeData;
                const paymentMethodData = this.$wire.paymentMethodData;

                console.log('Alpine Revenue: Chart data:', {
                    daily: dailyRevenueData,
                    product: revenueByProductData,
                    type: revenueByProductTypeData,
                    payment: paymentMethodData
                });

                // Daily Revenue Chart (Area)
                if (this.$refs.dailyChart && dailyRevenueData?.categories?.length > 0) {
                    this.charts.daily = new ApexCharts(this.$refs.dailyChart, {
                        series: [{
                            name: 'Revenue',
                            data: dailyRevenueData.data || []
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: {
                                show: true
                            }
                        },
                        colors: ['#10b981'],
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
                                opacityFrom: 0.6,
                                opacityTo: 0.1
                            }
                        },
                        xaxis: {
                            categories: dailyRevenueData.categories || []
                        },
                        yaxis: {
                            labels: {
                                formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        }
                    });
                    this.charts.daily.render();
                } else if (this.$refs.dailyChart) {
                    this.$refs.dailyChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-area text-4xl mr-3"></i>' +
                        '<span>Tidak ada data pendapatan</span></div>';
                }

                // Revenue by Product Chart (Horizontal Bar)
                if (this.$refs.productChart && revenueByProductData?.categories?.length > 0) {
                    this.charts.product = new ApexCharts(this.$refs.productChart, {
                        series: [{
                            name: 'Revenue',
                            data: revenueByProductData.data || []
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#5f91a7'],
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                borderRadius: 6
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: revenueByProductData.categories || [],
                            labels: {
                                formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        }
                    });
                    this.charts.product.render();
                } else if (this.$refs.productChart) {
                    this.$refs.productChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-bar text-4xl mr-3"></i>' +
                        '<span>Tidak ada data produk</span></div>';
                }

                // Revenue by Product Type Chart (Vertical Bar)
                if (this.$refs.typeChart && revenueByProductTypeData?.categories?.length > 0) {
                    this.charts.type = new ApexCharts(this.$refs.typeChart, {
                        series: [{
                            name: 'Revenue',
                            data: revenueByProductTypeData.data || []
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#6d9e72'],
                        plotOptions: {
                            bar: {
                                borderRadius: 8,
                                columnWidth: '50%'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: revenueByProductTypeData.categories || []
                        },
                        yaxis: {
                            labels: {
                                formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        }
                    });
                    this.charts.type.render();
                } else if (this.$refs.typeChart) {
                    this.$refs.typeChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-bar text-4xl mr-3"></i>' +
                        '<span>Tidak ada data tipe produk</span></div>';
                }

                // Payment Methods Chart (Vertical Bar)
                if (this.$refs.paymentChart && paymentMethodData?.categories?.length > 0) {
                    this.charts.payment = new ApexCharts(this.$refs.paymentChart, {
                        series: [{
                            name: 'Amount',
                            data: paymentMethodData.data || []
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
                                borderRadius: 8,
                                columnWidth: '50%'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        xaxis: {
                            categories: paymentMethodData.categories || []
                        },
                        yaxis: {
                            labels: {
                                formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        }
                    });
                    this.charts.payment.render();
                } else if (this.$refs.paymentChart) {
                    this.$refs.paymentChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-credit-card text-4xl mr-3"></i>' +
                        '<span>Tidak ada data metode pembayaran</span></div>';
                }
            }
        }
    }
</script>
