{{-- Statistics Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Paid</p>
                <p class="text-2xl font-bold text-light-primary">{{ $stats['paid'] }}</p>
            </div>
            <div class="bg-light-primary/20 p-3 rounded-lg">
                <i class="fas fa-check-circle text-light-primary text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Check-in Today</p>
                <p class="text-2xl font-bold text-light-primary">{{ $stats['checkin_today'] }}</p>
            </div>
            <div class="bg-light-primary/20 p-3 rounded-lg">
                <i class="fas fa-sign-in-alt text-light-primary text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Complete Today</p>
                <p class="text-2xl font-bold text-light-primary">{{ $stats['completed_today'] }}</p>
            </div>
            <div class="bg-light-primary/20 p-3 rounded-lg">
                <i class="fas fa-right-from-bracket text-light-primary text-xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="bg-white rounded-lg shadow mb-6 p-6 border border-gray-200">
    <div class="flex flex-col md:flex-row justify-center md:items-end gap-4">
        {{-- Search --}}
        <div class="w-full md:w-[90%]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Token, nama, email, atau phone..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
        </div>

        {{-- Status Filter --}}
        <div x-data="{ showFilters: false }" class="relative">
            <button @click="showFilters = !showFilters"
                class="w-full md:w-auto px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-between gap-2">
                <span class="flex items-center gap-2">
                    <i class="fas fa-filter text-light-primary"></i>
                    <span>Filters</span>
                </span>
                <i class="fas fa-chevron-down transition-transform" :class="{ 'rotate-180': showFilters }"></i>
            </button>

            {{-- Dropdown Filter --}}
            <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" @click.away="showFilters = false"
                class="absolute right-0 z-10 mt-2 w-full md:w-[520px] bg-white rounded-lg shadow-lg border border-gray-200 p-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="pending_payment">Pending Payment</option>
                            <option value="paid">Paid</option>
                            <option value="checked_in">Checked-in</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="expired">Expired</option>
                            <option value="refunded">Refunded</option>
                            <option value="no_show">No-Show</option>
                        </select>
                    </div>

                    {{-- Product Type Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Type</label>
                        <select wire:model.live="productTypeFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">All Types</option>
                            <option value="accommodation">Accommodation</option>
                            <option value="touring">Touring</option>
                            <option value="area_rental">Area Rental</option>
                        </select>
                    </div>

                    {{-- Start Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" wire:model.live="startDate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    {{-- End Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" wire:model.live="endDate"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>

                {{-- Reset Button --}}
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button wire:click="resetFilters"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-all">
                        <i class="fas fa-redo mr-2"></i>Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bookings Table --}}
<div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Booking Info
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date Range
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    {{-- {{ dd($booking) }} --}}
                    <tr class="hover:bg-gray-50">
                        {{-- Booking Info --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">

                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $booking->booking_token }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Customer --}}
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900">{{ $booking->customer_name }}</p>
                                <p class="text-gray-500">{{ $booking->customer_phone }}</p>
                                @if ($booking->customer_email)
                                    <p class="text-gray-500">{{ $booking->customer_email }}</p>
                                @endif
                            </div>
                        </td>

                        {{-- Product --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($booking->product_type) }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $booking->items->where('item_type', 'product')->first()?->name_snapshot ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Date Range --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</p>
                                <p class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">
                                    ({{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                    {{ $booking->product_type === 'touring' ? 'day' : 'nights' }})
                                </p>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusConfig = [
                                    'draft' => [
                                        'bg' => 'bg-status-draft-bg',
                                        'text' => 'text-status-draft',
                                        'icon' => 'fa-file',
                                    ],
                                    'pending_payment' => [
                                        'bg' => 'bg-warning/10',
                                        'text' => 'text-warning',
                                        'icon' => 'fa-clock',
                                    ],
                                    'paid' => [
                                        'bg' => 'bg-success/10',
                                        'text' => 'text-success',
                                        'icon' => 'fa-check-circle',
                                    ],
                                    'checked_in' => [
                                        'bg' => 'bg-status-checkedin-bg',
                                        'text' => 'text-status-checkedin',
                                        'icon' => 'fa-sign-in-alt',
                                    ],
                                    'completed' => [
                                        'bg' => 'bg-status-completed-bg',
                                        'text' => 'text-status-completed',
                                        'icon' => 'fa-flag-checkered',
                                    ],
                                    'cancelled' => [
                                        'bg' => 'bg-status-cancelled-bg',
                                        'text' => 'text-status-cancelled',
                                        'icon' => 'fa-times-circle',
                                    ],
                                    'expired' => [
                                        'bg' => 'bg-status-expired-bg',
                                        'text' => 'text-status-expired',
                                        'icon' => 'fa-hourglass-end',
                                    ],
                                    'refunded' => [
                                        'bg' => 'bg-info-2/10',
                                        'text' => 'text-info-2',
                                        'icon' => 'fa-undo',
                                    ],
                                    'no_show' => [
                                        'bg' => 'bg-status-noshow-bg',
                                        'text' => 'text-status-noshow',
                                        'icon' => 'fa-user-slash',
                                    ],
                                ];
                                $status = $statusConfig[$booking->status] ?? $statusConfig['draft'];
                            @endphp
                            <span
                                class="{{ $status['bg'] }} {{ $status['text'] }} text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1">
                                <i class="fas {{ $status['icon'] }}"></i>
                                {{ strtoupper(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="text-sm font-bold text-gray-900">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            @if ($booking->discount_total > 0)
                                <p class="text-xs text-green-600">-Rp
                                    {{ number_format($booking->discount_total, 0, ',', '.') }}</p>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="switchToDetail({{ $booking->id }})"
                                    class="text-blue-600 hover:text-blue-800 transition-colors" title="View Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No bookings found</p>
                                <p class="text-sm">Try adjusting your filters or create a new booking</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing <span class="font-medium">{{ $bookings->firstItem() ?? 0 }}</span> to
                <span class="font-medium">{{ $bookings->lastItem() ?? 0 }}</span> of
                <span class="font-medium">{{ $bookings->total() }}</span> results
            </div>

            <div>
                {{ $bookings->links('vendor.livewire.compact') }}
            </div>
        </div>
    </div>
</div>
