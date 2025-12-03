<div class="space-y-6 p-6 bg-white rounded-lg shadow">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Keuangan</h1>
            <p class="text-sm text-gray-600 mt-1">Faktur, pembayaran, dan analisis keuangan</p>
        </div>

        <div class="flex items-center gap-3">
            {{-- Export Buttons --}}
            <button wire:click="exportExcel"
                class="px-4 py-2 bg-success hover:bg-success/80 text-white rounded-lg font-semibold transition-all text-sm flex items-center gap-2">
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Period Filter --}}
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
                    @for ($year = 2020; $year <= now()->year; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>

            {{-- Invoice Status Filter --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status Invoice</label>
                <select wire:model.live="invoiceStatus"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="paid">Dibayar</option>
                    <option value="cancelled">Dibatalkan</option>
                    <option value="refunded">Dikembalikan</option>
                </select>
            </div>
        </div>

        {{-- Date Range Display --}}
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                <i class="fas fa-calendar-alt mr-2"></i>
                Menampilkan data untuk
                @if ($selectedMonth == 0)
                    <strong>Keseluruhan</strong>
                @elseif($selectedMonth == 13)
                    <strong>Tahun Penuh {{ $selectedYear }}</strong>
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
        {{-- Total Invoices --}}
        <div class="bg-gradient-to-br from-info to-info/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-file-invoice text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Invoice</p>
            <p class="text-2xl font-bold">{{ number_format($totalInvoices) }}</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-gradient-to-br from-success to-success/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-dollar-sign text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Pendapatan</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue / 1000) }}K</p>
        </div>

        {{-- Total Paid --}}
        <div class="bg-gradient-to-br from-light-primary to-light-primary/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Terbayar</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalPaid / 1000) }}K</p>
        </div>

        {{-- Total Pending --}}
        <div class="bg-gradient-to-br from-status-expired to-status-expired/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Pending</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalPending / 1000) }}K</p>
        </div>

        {{-- Total Refunded --}}
        <div
            class="bg-gradient-to-br from-status-cancelled to-status-cancelled/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-undo text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Pengembalian</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRefunded / 1000) }}K</p>
        </div>

        {{-- Total Tax --}}
        {{-- <div class="bg-gradient-to-br from-info-2 to-info-2/80 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-receipt text-2xl"></i>
                </div>
            </div>
            <p class="text-sm opacity-90 mb-1">Total Tax</p>
            <p class="text-2xl font-bold">Rp {{ number_format($totalTax / 1000) }}K</p>
        </div> --}}
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-data="financialCharts()" x-init="init()"
        wire:key="financial-charts-{{ $selectedMonth }}-{{ $selectedYear }}">
        {{-- Revenue vs Refunds --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-area text-primary"></i>
                Pendapatan vs Refund
            </h3>
            <div id="revenueVsExpensesChart" x-ref="revenueVsExpensesChart"></div>
        </div>

        {{-- Invoice Status Distribution --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-primary"></i>
                Sebaran Status Invoice
            </h3>
            <div id="invoiceStatusChart" x-ref="invoiceStatusChart"></div>
        </div>

        {{-- Payment Methods --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-credit-card text-primary"></i>
                Pembayaran Metode
            </h3>
            <div id="paymentMethodsChart" x-ref="paymentMethodsChart"></div>
        </div>

        {{-- Monthly Revenue (if applicable) --}}
        {{-- <div class="bg-white rounded-lg shadow border border-gray-200 p-6 lg:col-span-2">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-primary"></i>
                Monthly Revenue Trend
            </h3>
            <div id="monthlyRevenueChart" x-ref="monthlyRevenueChart"></div>
        </div> --}}
    </div>

    {{-- Tables Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Invoices --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-file-invoice text-primary"></i>
                Invoice Terbaru
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Invoice #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentInvoices as $invoice)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $invoice->invoice_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $invoice->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-900">{{ $invoice->booking?->customer_name ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900 text-sm">Rp
                                        {{ number_format($invoice->amount) }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $invoice->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $invoice->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $invoice->status === 'refunded' ? 'bg-orange-100 text-orange-800' : '' }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p class="text-sm">Tidak ada invoice</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-money-bill-wave text-primary"></i>
                Pembayaran Terbaru
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ORDER ID
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Method</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentPayments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $payment->order_id }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ Carbon\Carbon::parse($payment->paid_at)->format('d M Y') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-900">{{ $payment->booking?->customer_name ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900 text-sm">Rp
                                        {{ number_format($payment->amount) }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($payment->provider) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p class="text-sm">Tidak ada pembayaran</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Refunded Invoices --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-undo text-red-500"></i>
                Invoice Refund (Credit Notes)
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Credit Note #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($refundedInvoices as $invoice)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $invoice->invoice_number }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-900">{{ $invoice->booking?->customer_name ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-danger text-sm">- Rp
                                        {{ number_format($invoice->amount) }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-500">{{ $invoice->created_at->format('d M Y') }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-2"></i>
                                    <p class="text-sm">Tidak ada refund</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Outstanding Invoices --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                Invoice Belum Dibayar
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Invoice #
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Due Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($outstandingInvoices as $invoice)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $invoice->invoice_number }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm text-gray-900">{{ $invoice->booking?->customer_name ?? 'N/A' }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-bold text-gray-900 text-sm">Rp
                                        {{ number_format($invoice->amount) }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p
                                        class="text-sm font-semibold
                                        {{ Carbon\Carbon::parse($invoice->due_date)->isPast() ? 'text-danger' : 'text-warning' }}">
                                        {{ Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ Carbon\Carbon::parse($invoice->due_date)->diffForHumans() }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    <i class="fas fa-check-circle text-3xl mb-2 text-green-400"></i>
                                    <p class="text-sm">Tidak ada invoice tertunda</p>
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
    function financialCharts() {
        return {
            charts: {
                revenueVsExpenses: null,
                invoiceStatus: null,
                paymentMethods: null,
                monthlyRevenue: null
            },

            init() {
                console.log('Alpine Financial Charts: Initializing...');
                this.renderCharts();

                // Listen to Livewire event
                this.$wire.on('chartDataUpdated', () => {
                    console.log('Alpine Financial: Chart data updated, re-rendering...');
                    this.renderCharts();
                });

                // Watch for filter changes
                this.$watch('$wire.selectedMonth', () => {
                    console.log('Alpine Financial: Month changed, re-rendering...');
                    setTimeout(() => this.renderCharts(), 100);
                });

                this.$watch('$wire.selectedYear', () => {
                    console.log('Alpine Financial: Year changed, re-rendering...');
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
                console.log('Alpine Financial: Rendering charts...');
                this.destroyCharts();

                // Get data from Livewire component using $wire
                const revenueVsExpensesData = this.$wire.revenueVsExpensesData;
                const invoiceStatusData = this.$wire.invoiceStatusData;
                const paymentMethodsData = this.$wire.paymentMethodsData;
                const monthlyRevenueData = this.$wire.monthlyRevenueData;

                console.log('Alpine Financial: Chart data:', {
                    revenue: revenueVsExpensesData,
                    invoice: invoiceStatusData,
                    payment: paymentMethodsData,
                    monthly: monthlyRevenueData
                });

                // Revenue vs Refunds Chart
                if (this.$refs.revenueVsExpensesChart && revenueVsExpensesData?.categories?.length > 0) {
                    this.charts.revenueVsExpenses = new ApexCharts(this.$refs.revenueVsExpensesChart, {
                        series: [{
                            name: 'Revenue',
                            data: revenueVsExpensesData.revenue || []
                        }, {
                            name: 'Refunds',
                            data: revenueVsExpensesData.refunds || []
                        }],
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: {
                                show: true
                            }
                        },
                        colors: ['#10b981', '#ef4444'],
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
                                opacityFrom: 0.5,
                                opacityTo: 0.1,
                            }
                        },
                        xaxis: {
                            categories: revenueVsExpensesData.categories || []
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
                    this.charts.revenueVsExpenses.render();
                } else if (this.$refs.revenueVsExpensesChart) {
                    this.$refs.revenueVsExpensesChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-area text-4xl mr-3"></i>' +
                        '<span>Tidak ada data pendapatan</span></div>';
                }

                // Invoice Status Chart
                if (this.$refs.invoiceStatusChart && invoiceStatusData?.labels?.length > 0) {
                    this.charts.invoiceStatus = new ApexCharts(this.$refs.invoiceStatusChart, {
                        series: invoiceStatusData.series || [],
                        chart: {
                            type: 'donut',
                            height: 350
                        },
                        labels: invoiceStatusData.labels || [],
                        colors: ['#85b582', '#10b981', '#ef4444', '#f97316'],
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
                                                const total = w.globals.seriesTotals.reduce((a, b) =>
                                                    a + b, 0);
                                                return 'Rp ' + (total / 1000).toFixed(0) + 'K';
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        }
                    });
                    this.charts.invoiceStatus.render();
                } else if (this.$refs.invoiceStatusChart) {
                    this.$refs.invoiceStatusChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-pie text-4xl mr-3"></i>' +
                        '<span>Tidak ada data invoice</span></div>';
                }

                // Payment Methods Chart
                if (this.$refs.paymentMethodsChart && paymentMethodsData?.labels?.length > 0) {
                    this.charts.paymentMethods = new ApexCharts(this.$refs.paymentMethodsChart, {
                        series: paymentMethodsData.series || [],
                        chart: {
                            type: 'pie',
                            height: 350
                        },
                        labels: paymentMethodsData.labels || [],
                        colors: ['#60b2a1', '#85b582', '#5f91a7', '#f59e0b', '#ef4444'],
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            y: {
                                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val, opts) {
                                return opts.w.config.labels[opts.seriesIndex];
                            }
                        }
                    });
                    this.charts.paymentMethods.render();
                } else if (this.$refs.paymentMethodsChart) {
                    this.$refs.paymentMethodsChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-credit-card text-4xl mr-3"></i>' +
                        '<span>Tidak ada data metode pembayaran</span></div>';
                }

                // Monthly Revenue Chart
                if (this.$refs.monthlyRevenueChart && monthlyRevenueData?.categories?.length > 0) {
                    this.charts.monthlyRevenue = new ApexCharts(this.$refs.monthlyRevenueChart, {
                        series: [{
                            name: 'Revenue',
                            data: monthlyRevenueData.data || []
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#3b82f6'],
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                dataLabels: {
                                    position: 'top'
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K',
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ['#304758']
                            }
                        },
                        xaxis: {
                            categories: monthlyRevenueData.categories || []
                        },
                        yaxis: {
                            labels: {
                                formatter: val => 'Rp ' + (val / 1000).toFixed(0) + 'K'
                            }
                        }
                    });
                    this.charts.monthlyRevenue.render();
                } else if (this.$refs.monthlyRevenueChart) {
                    this.$refs.monthlyRevenueChart.innerHTML =
                        '<div class="flex items-center justify-center h-[350px] text-gray-400">' +
                        '<i class="fas fa-chart-bar text-4xl mr-3"></i>' +
                        '<span>Tidak ada data pendapatan bulanan</span></div>';
                }
            }
        }
    }
</script>
