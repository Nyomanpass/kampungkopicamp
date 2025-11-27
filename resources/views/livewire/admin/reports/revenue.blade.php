<div class="space-y-6 p-6 rounded-lg shadow bg-white">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Pendapatan</h1>
            <p class="text-sm text-gray-600 mt-1">Detail analisa Pendapatan</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Export Buttons --}}
            <button wire:click="exportExcel"
                class="px-4 py-2 bg-primary hover:bg-primary/80 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2">
                <i class="fas fa-file-excel"></i>
                <span class="hidden md:inline">Excel</span>
            </button>
            <button wire:click="exportPDF"
                class="px-4 py-2 bg-danger hover:bg-danger/80 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2">
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

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

            {{-- Custom Start Date --}}
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-light-primary to-light-primary/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Revenue</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue / 1000) }}K</p>
        </div>

        {{-- Total Transactions --}}
        <div class="bg-gradient-to-br from-info to-info/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Transactions</p>
            <p class="text-2xl font-bold">{{ $totalTransactions }}</p>
        </div>

        {{-- Average Transaction Value --}}
        <div class="bg-gradient-to-br from-status-completed to-status-completed/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Avg Transaction</p>
            <p class="text-2xl font-bold">Rp {{ number_format($averageTransactionValue / 1000) }}K</p>
        </div>

        {{-- Total Refunded --}}
        <div class="bg-gradient-to-br from-status-expired to-status-expired/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-undo text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Refunded</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRefunded / 1000) }}K</p>
        </div>

        {{-- Net Revenue --}}
        <div class="bg-gradient-to-br from-info-2/70 to-info-2/70 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Net Revenue</p>
            <p class="text-2xl font-bold">Rp {{ number_format($netRevenue / 1000) }}K</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Daily Revenue Trend --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-area text-primary"></i>
                Tren Pendapatan Harian
            </h3>
            <div id="dailyRevenueChart"></div>
        </div>

        {{-- Revenue by Product --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary"></i>
                Top 10 Products by Revenue
            </h3>
            <div id="revenueByProductChart"></div>
        </div>

        {{-- Revenue by Product Type --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-primary"></i>
                Revenue by Product Type
            </h3>
            <div id="revenueByProductTypeChart"></div>
        </div>

        {{-- Payment Methods --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card text-primary"></i>
                Payment Methods Breakdown
            </h3>
            <div id="paymentMethodChart"></div>
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
    document.addEventListener('livewire:navigated', function() {
        initRevenueCharts();
    });

    Livewire.on('dataUpdated', () => {
        initRevenueCharts();
    });

    function initRevenueCharts() {
        // Daily Revenue Chart
        const dailyRevenueOptions = {
            series: [{
                name: 'Revenue',
                data: @js($dailyRevenueData['data'])
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
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
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                }
            },
            xaxis: {
                categories: @js($dailyRevenueData['categories'])
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
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#dailyRevenueChart"), dailyRevenueOptions).render();

        // Revenue by Product Chart
        const revenueByProductOptions = {
            series: [{
                name: 'Revenue',
                data: @js($revenueByProductData['data'])
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
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#revenueByProductChart"), revenueByProductOptions).render();

        // Revenue by Product Type Chart
        const revenueByTypeOptions = {
            series: @js($revenueByProductTypeData['series']),
            chart: {
                type: 'donut',
                height: 350
            },
            labels: @js($revenueByProductTypeData['labels']),
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
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#revenueByProductTypeChart"), revenueByTypeOptions).render();

        // Payment Methods Chart
        const paymentMethodOptions = {
            series: @js($paymentMethodData['series']),
            chart: {
                type: 'pie',
                height: 350
            },
            labels: @js($paymentMethodData['labels']),
            colors: ['#6d9e72', '#4b7d6e', '#5f91a7', '#f59e0b'],
            legend: {
                position: 'bottom'
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#paymentMethodChart"), paymentMethodOptions).render();
    }
</script>
