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
        <h3 class="text-lg font-bold text-gray-900 mb-4">Filters</h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Date Range --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date Range</label>
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
        </div>

        {{-- Date Range Display --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                <i class="fas fa-calendar-alt mr-2"></i>
                Showing data from
                <strong>{{ Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong>
                to
                <strong>{{ Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- New Customers Trend --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-primary"></i>
                Trend Customer Baru
            </h3>
            <div id="newCustomersTrendChart"></div>
        </div>

        {{-- Customers by Source --}}
        {{-- <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-primary"></i>
                Customers by Email Domain
            </h3>
            <div id="customersBySourceChart"></div>
        </div> --}}

        {{-- Customer Activity --}}
        {{-- <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-donut text-primary"></i>
                Customer Activity Segments
            </h3>
            <div id="customerActivityChart"></div>
        </div> --}}
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
    document.addEventListener('livewire:navigated', function() {
        initCustomerCharts();
    });

    function initCustomerCharts() {
        // New Customers Trend
        const newCustomersTrendOptions = {
            series: [{
                name: 'New Customers',
                data: @js($newCustomersTrendData['data'])
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
                categories: @js($newCustomersTrendData['categories'])
            }
        };
        new ApexCharts(document.querySelector("#newCustomersTrendChart"), newCustomersTrendOptions).render();

        // Customers by Source
        const customersBySourceOptions = {
            series: @js($customersBySourceData['series']),
            chart: {
                type: 'pie',
                height: 350
            },
            labels: @js($customersBySourceData['labels']),
            colors: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444'],
            legend: {
                position: 'bottom'
            }
        };
        new ApexCharts(document.querySelector("#customersBySourceChart"), customersBySourceOptions).render();

        // Customer Activity
        const customerActivityOptions = {
            series: @js($customerActivityData['series']),
            chart: {
                type: 'donut',
                height: 350
            },
            labels: @js($customerActivityData['labels']),
            colors: ['#6b7280', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
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
        new ApexCharts(document.querySelector("#customerActivityChart"), customerActivityOptions).render();
    }
</script>
