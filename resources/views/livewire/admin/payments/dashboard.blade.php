<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-credit-card text-primary text-lg md:text-xl"></i>
                Payment Management
            </h1>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Monitor transactions and revenue</p>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="switchToList"
                class="bg-primary hover:bg-light-primary text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
                <i class="fas fa-list"></i>
                <span>View All</span>
            </button>
            <button wire:click="refreshData"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 md:py-3 rounded-lg font-semibold transition-all text-sm md:text-base">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
</div>

{{-- Revenue Statistics --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
    {{-- Total Revenue --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white/20 px-2 py-1 rounded-full">All Time</span>
        </div>
        <p class="text-sm font-medium opacity-90 mb-1">Total Revenue</p>
        <p class="text-2xl md:text-3xl font-bold">Rp {{ number_format($stats['totalRevenue'] / 1000) }}K</p>
        <div class="mt-4 pt-4 border-t border-white/20">
            <div class="flex items-center justify-between text-xs">
                <span class="opacity-75">{{ $stats['totalTransactions'] }} transactions</span>
                <span class="font-semibold">{{ number_format($stats['successRate'], 1) }}% success</span>
            </div>
        </div>
    </div>

    {{-- Monthly Revenue --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-calendar-alt text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white/20 px-2 py-1 rounded-full">This Month</span>
        </div>
        <p class="text-sm font-medium opacity-90 mb-1">Monthly Revenue</p>
        <p class="text-2xl md:text-3xl font-bold">Rp {{ number_format($stats['monthRevenue'] / 1000) }}K</p>
        <div class="mt-4 pt-4 border-t border-white/20">
            <div class="flex items-center gap-2 text-xs">
                <i class="fas fa-chart-line"></i>
                <span class="opacity-75">{{ now()->format('F Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Today Revenue --}}
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white/20 px-2 py-1 rounded-full">Today</span>
        </div>
        <p class="text-sm font-medium opacity-90 mb-1">Today's Revenue</p>
        <p class="text-2xl md:text-3xl font-bold">Rp {{ number_format($stats['todayRevenue'] / 1000) }}K</p>
        <div class="mt-4 pt-4 border-t border-white/20">
            <div class="flex items-center gap-2 text-xs">
                <i class="fas fa-calendar-day"></i>
                <span class="opacity-75">{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Pending Payments --}}
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <i class="fas fa-hourglass-half text-2xl"></i>
            </div>
            <span class="text-xs font-semibold bg-white/20 px-2 py-1 rounded-full">Pending</span>
        </div>
        <p class="text-sm font-medium opacity-90 mb-1">Pending Amount</p>
        <p class="text-2xl md:text-3xl font-bold">Rp {{ number_format($stats['pendingAmount'] / 1000) }}K</p>
        <div class="mt-4 pt-4 border-t border-white/20">
            <div class="flex items-center gap-2 text-xs">
                <i class="fas fa-exclamation-circle"></i>
                <span class="opacity-75">Awaiting payment</span>
            </div>
        </div>
    </div>
</div>

{{-- Revenue Trend & Status Breakdown --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    {{-- Revenue Trend Chart --}}
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-line text-primary"></i>
            7-Day Revenue Trend
        </h3>

        <div class="space-y-3">
            @php
                $maxRevenue = collect($stats['revenueTrend'])->max('revenue') ?: 1;
            @endphp

            @foreach ($stats['revenueTrend'] as $day)
                <div>
                    <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                        <span class="font-semibold">{{ $day['date'] }}</span>
                        <span class="font-bold text-primary">Rp {{ number_format($day['revenue'] / 1000) }}K</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-gradient-to-r from-primary to-light-primary h-full rounded-full transition-all duration-500"
                            style="width: {{ $maxRevenue > 0 ? ($day['revenue'] / $maxRevenue) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Status Breakdown --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie text-primary"></i>
            Status Breakdown
        </h3>

        <div class="space-y-3">
            {{-- Settlement --}}
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Settlement</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $stats['statusBreakdown']->get('settlement')->count ?? 0 }}</p>
                    </div>
                </div>
                <p class="text-xs font-semibold text-green-600">
                    Rp {{ number_format(($stats['statusBreakdown']->get('settlement')->total ?? 0) / 1000) }}K
                </p>
            </div>

            {{-- Pending --}}
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Pending</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $stats['statusBreakdown']->get('pending')->count ?? 0 }}</p>
                    </div>
                </div>
                <p class="text-xs font-semibold text-yellow-600">
                    Rp {{ number_format(($stats['statusBreakdown']->get('pending')->total ?? 0) / 1000) }}K
                </p>
            </div>

            {{-- Expired --}}
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Expired</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $stats['statusBreakdown']->get('expire')->count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- Cancelled --}}
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-ban text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Cancelled</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $stats['statusBreakdown']->get('cancel')->count ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Payment Methods & Recent Transactions --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    {{-- Payment Methods --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-credit-card text-primary"></i>
            Payment Methods
        </h3>

        <div class="space-y-3">
            @forelse($stats['providerStats'] as $provider)
                <div
                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <i
                                class="fas fa-{{ $provider->provider === 'midtrans' ? 'mobile-alt' : 'money-bill-wave' }} text-primary"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 capitalize">{{ $provider->provider }}</p>
                            <p class="text-xs text-gray-500">{{ $provider->count }} transactions</p>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-gray-900">
                        Rp {{ number_format($provider->total / 1000) }}K
                    </p>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-inbox text-3xl mb-2"></i>
                    <p class="text-sm">No data yet</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-history text-primary"></i>
                Recent Transactions
            </h3>
            <button wire:click="switchToList" class="text-sm text-primary hover:text-light-primary font-semibold">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </div>

        <div class="space-y-2">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between p-3 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                    wire:click="switchToDetail({{ $payment->id }})">
                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div
                            class="w-10 h-10 rounded-lg bg-{{ $payment->status === 'settlement' ? 'green' : ($payment->status === 'pending' ? 'yellow' : 'gray') }}-100 flex items-center justify-center flex-shrink-0">
                            <i
                                class="fas fa-{{ $payment->status === 'settlement' ? 'check' : ($payment->status === 'pending' ? 'clock' : 'times') }} text-{{ $payment->status === 'settlement' ? 'green' : ($payment->status === 'pending' ? 'yellow' : 'gray') }}-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 text-sm truncate">{{ $payment->order_id }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->booking->user->name ?? 'Guest' }}</p>
                            <p class="text-xs text-gray-400">{{ $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($payment->amount) }}</p>
                        <span
                            class="px-2 py-0.5 text-xs font-semibold rounded-full
                            {{ $payment->status === 'settlement' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $payment->status === 'expire' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $payment->status === 'cancel' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p class="text-sm">No transactions yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
