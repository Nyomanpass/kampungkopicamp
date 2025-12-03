<div class="bg-white space-y-6 p-6 shadow rounded-lg">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3">

            <div>
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">All Payments</h2>
                <p class="text-xs md:text-sm text-gray-600 mt-1">View and manage all transactions</p>
            </div>
        </div>
        <div class="flex items-center gap-2">

            <button wire:click="refreshData"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold transition-all text-sm">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>


    {{-- Filters --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            {{-- Search --}}
            <div class="lg:col-span-2">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Search order ID, customer name...">
                </div>
            </div>

            {{-- Status Filter --}}
            <div>
                <select wire:model.live="statusFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="settlement">Settlement</option>
                    <option value="pending">Pending</option>
                    <option value="expire">Expired</option>
                    <option value="cancel">Cancelled</option>
                    <option value="refund">Refunded</option>
                </select>
            </div>

            {{-- Provider Filter --}}
            <div>
                <select wire:model.live="providerFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Providers</option>
                    <option value="midtrans">Midtrans</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>

            {{-- Date Filter --}}
            <div>
                <select wire:model.live="dateFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
        </div>

        {{-- Custom Date Range --}}
        @if ($dateFilter === 'custom')
            <div class="grid grid-cols-2 gap-3 mt-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">From</label>
                    <input type="date" wire:model.live="dateFrom"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">To</label>
                    <input type="date" wire:model.live="dateTo"
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
            </div>
        @endif
    </div>

    {{-- Payments List --}}
    <div class="space-y-3 md:space-y-0">
        @forelse ($payments as $payment)
            {{-- Desktop Table Row --}}

            @if ($loop->first)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Order ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Provider</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
            @endif

            <tr class="hover:bg-gray-50 transition-colors">
                {{-- Order ID --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg 
                            {{ $payment->status === 'settlement' ? 'bg-success/15' : '' }}
                            {{ $payment->status === 'pending' ? 'bg-warning/15' : '' }}
                            {{ $payment->status === 'expire' ? 'bg-status-draft/15' : '' }}
                            {{ $payment->status === 'cancel' ? 'bg-danger/15' : '' }}
                            {{ $payment->status === 'refund' ? 'bg-info-2/15' : '' }}
                            flex items-center justify-center flex-shrink-0">
                            <i
                                class="fas 
                                {{ $payment->status === 'settlement' ? 'fa-check text-success ' : '' }}
                                {{ $payment->status === 'pending' ? 'fa-clock text-warning' : '' }}
                                {{ $payment->status === 'expire' ? 'fa-times text-status-draft' : '' }}
                                {{ $payment->status === 'cancel' ? 'fa-ban text-danger' : '' }}
                                 {{ $payment->status === 'refund' ? 'fa-rotate-right text-info-2' : '' }}">
                            </i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900 text-sm">{{ $payment->order_id }}</p>
                            <p class="text-xs text-gray-500">ID: {{ $payment->id }}</p>
                        </div>
                    </div>
                </td>

                {{-- Customer --}}
                <td class="px-4 py-3">
                    <div class="text-xs">
                        <p class="text-gray-900 font-medium">
                            {{ $payment->booking->user->name ?? ($payment->booking->customer_name ?? 'Guest') }}</p>
                        <p class="text-gray-500">
                            {{ $payment->booking->user->email ?? ($payment->booking->customer_email ?? '-') }}</p>
                    </div>
                </td>

                {{-- Amount --}}
                <td class="px-4 py-3">
                    <p class="text-sm font-bold text-gray-900">Rp {{ number_format($payment->amount) }}</p>
                </td>

                {{-- Provider --}}
                <td class="px-4 py-3">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-info-light text-info capitalize">
                        {{ $payment->provider }}
                    </span>
                </td>

                {{-- Date --}}
                <td class="px-4 py-3">
                    <p class="text-xs text-gray-900 font-medium">{{ $payment->created_at->format('d M Y') }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->created_at->format('H:i') }}</p>
                </td>

                {{-- Status --}}
                <td class="px-4 py-3">
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $payment->status === 'settlement' ? 'bg-success/15 text-success' : '' }}
                        {{ $payment->status === 'pending' ? 'bg-warning/15 text-warning' : '' }}
                        {{ $payment->status === 'expire' ? 'bg-status-draft/15 text-status-draft' : '' }}
                        {{ $payment->status === 'cancel' ? 'bg-danger/15 text-danger' : '' }}
                        {{ $payment->status === 'refund' ? 'bg-info-2/15 text-info-2' : '' }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">


                        <button wire:click="downloadInvoice({{ $payment->id }})"
                            @if ($payment->status !== 'settlement' || !$payment->booking) disabled @endif
                            class="w-8 h-8 flex items-center justify-center text-light-primary hover:bg-light-primary/10 rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            title="Download Invoice">
                            <i class="fas fa-file-download text-sm"></i>
                        </button>

                        <button wire:click="switchToDetail({{ $payment->id }})"
                            class="w-8 h-8 flex items-center justify-center text-info hover:bg-blue-50 rounded-lg transition-all"
                            title="View Details">
                            <i class="fas fa-eye text-sm"></i>
                        </button>


                        {{-- @if ($payment->status === 'pending')
                            <button wire:click="markAsPaid({{ $payment->id }})"
                                onclick="return confirm('Mark as paid?')"
                                class="w-8 h-8 flex items-center justify-center text-green-600 hover:bg-green-50 rounded-lg transition-all"
                                title="Mark as Paid">
                                <i class="fas fa-check text-sm"></i>
                            </button>
                        @endif

                        @if (in_array($payment->status, ['pending', 'initiated']))
                            <button wire:click="cancelPayment({{ $payment->id }})"
                                onclick="return confirm('Cancel payment?')"
                                class="w-8 h-8 flex items-center justify-center text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                title="Cancel">
                                <i class="fas fa-ban text-sm"></i>
                            </button>
                        @endif

                        @if ($payment->status === 'settlement')
                            <button wire:click="refundPayment({{ $payment->id }})"
                                onclick="return confirm('Refund payment?')"
                                class="w-8 h-8 flex items-center justify-center text-purple-600 hover:bg-purple-50 rounded-lg transition-all"
                                title="Refund">
                                <i class="fas fa-undo text-sm"></i>
                            </button>
                        @endif --}}
                    </div>
                </td>
            </tr>

            @if ($loop->last)
                </tbody>
                </table>
            @endif
    </div>
@empty
    {{-- Empty State --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 md:p-12 text-center">
        <div class="flex flex-col items-center justify-center text-gray-400">
            <i class="fas fa-receipt text-5xl md:text-6xl mb-4"></i>
            <p class="text-base md:text-lg font-semibold text-gray-600">No payments found</p>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Try adjusting your filters</p>
        </div>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if ($payments->hasPages())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        {{ $payments->links() }}
    </div>
@endif

</div>
