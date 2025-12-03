<div class="bg-white space-y-6 p-6 shadow-sm rounded-lg">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">

                Voucher Management
            </h1>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola Voucher Promosi</p>
        </div>
        <button wire:click="switchToCreate"
            class="bg-primary hover:bg-light-primary text-white px-4 md:px-6 py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
            <i class="fas fa-plus"></i>
            <span>Tambah</span>
        </button>
    </div>

    {{-- Statistics Cards - Minimalist --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        {{-- Total Vouchers --}}
        {{-- <div class="bg-white rounded-lg shadow-sm border border-blue-200 p-3 md:p-4">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-blue-600 text-sm md:text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-600 truncate">Total</p>
                    <p class="text-xl md:text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div> --}}

        {{-- Active --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Active</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $stats['active'] }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-light-primary text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Expired --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Expired</p>
                    <p class="text-2xl font-bold text-danger">{{ $stats['expired'] }}</p>
                </div>
                <div class="bg-danger/20 p-3 rounded-lg">
                    <i class="fas fa-times-circle text-danger text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Scheduled --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Scheduled</p>
                    <p class="text-2xl font-bold text-warning">{{ $stats['scheduled'] }}</p>
                </div>
                <div class="bg-warning/20 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-warning text-xl"></i>
                </div>
            </div>
        </div>


        {{-- Total Redemptions --}}
        {{-- <div class="bg-white rounded-lg shadow-sm border border-purple-200 p-3 md:p-4">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-purple-600 text-sm md:text-base"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-600 truncate">Used</p>
                    <p class="text-lg md:text-xl font-bold text-gray-900">
                        {{ number_format($stats['total_redemptions']) }}
                    </p>
                </div>
            </div>
        </div> --}}

        {{-- Total Discount Given --}}
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Saved</p>
                    <p class="text-2xl font-bold text-info">
                        {{ number_format($stats['total_discount_given'] / 1000) }}K
                    </p>
                </div>
                <div class="bg-info/20 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-info text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Filters & Search --}}
    <div class="bg-white rounded-lg shadow-sm md:border border-gray-200 md:p-4">
        <div class="flex flex-col md:flex-row gap-3">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="w-full pl-10 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Search vouchers...">
                </div>
            </div>

            {{-- Type Filter --}}
            <div class="w-full md:w-48">
                <select wire:model.live="typeFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Types</option>
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>
                    <option value="bonus">Bonus</option>
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="w-full md:w-48">
                <select wire:model.live="statusFilter"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                    <option value="scheduled">Scheduled</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Vouchers List - Card Style for Mobile --}}
    @forelse ($vouchers as $voucher)

        {{-- Desktop Table Row --}}
        <div class="">
            @if ($loop->first)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Code</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Type & Value
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Usage</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Validity</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
            @endif

            <tr class="hover:bg-gray-50 transition-colors">
                {{-- Code --}}
                <td class="px-4 py-3">
                    <div>
                        <p class="font-mono font-bold text-gray-900 text-sm">{{ $voucher->code }}</p>
                        <p class="text-xs text-gray-500 truncate max-w-[120px]">{{ $voucher->name }}</p>
                    </div>
                </td>

                {{-- Type & Value --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                            <i class="fas {{ $voucher->getTypeIcon() }} text-primary text-sm"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $voucher->formatted_value }}</p>
                            @if ($voucher->min_order > 0)
                                <p class="text-xs text-gray-500">Min: Rp
                                    {{ number_format($voucher->min_order / 1000) }}K</p>
                            @endif
                        </div>
                    </div>
                </td>

                {{-- Usage --}}
                <td class="px-4 py-3">
                    @if ($voucher->usage_limit)
                        @php
                            $percentage = $voucher->getUsagePercentage();
                            $remaining = $voucher->getRemainingUses();
                        @endphp
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="text-sm font-semibold text-gray-900">{{ $voucher->redemptions_count }}/{{ $voucher->usage_limit }}</span>
                                @if ($percentage >= 100)
                                    <span class="text-xs text-red-600 font-semibold">FULL</span>
                                @endif
                            </div>
                            <div class="w-20 bg-gray-200 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full transition-all {{ $percentage >= 100 ? 'bg-red-500' : ($percentage >= 80 ? 'bg-orange-500' : 'bg-green-500') }}"
                                    style="width: {{ min($percentage, 100) }}%"></div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5">
                            <i class="fas fa-infinity text-primary text-sm"></i>
                            <span class="text-sm font-semibold text-gray-900">{{ $voucher->redemptions_count }}</span>
                        </div>
                    @endif
                </td>

                {{-- Validity --}}
                <td class="px-4 py-3">
                    <div class="text-xs">
                        @if ($voucher->end_date)
                            <p class="text-gray-900 font-medium">{{ $voucher->end_date->format('d M Y') }}</p>
                            @php $days = $voucher->getDaysUntilExpiration(); @endphp
                            @if ($days !== null && $days <= 7 && $days > 0)
                                <p class="text-danger">Sisa {{ $days }} hari lagi</p>
                            @endif
                        @else
                            <p class="text-gray-500 italic">No expiry</p>
                        @endif
                    </div>
                </td>

                {{-- Status --}}
                <td class="px-4 py-3">
                    @php
                        $statusColor = $voucher->getStatusColor();
                        $statusLabel = $voucher->getStatusLabel();
                    @endphp
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full inline-block
                        {{ $statusColor === 'green' ? 'bg-success/20 text-success' : '' }}
                        {{ $statusColor === 'yellow' ? 'bg-warning/20 text-warning' : '' }}
                        {{ $statusColor === 'red' ? 'bg-danger/20 text-danger' : '' }}
                        {{ $statusColor === 'orange' ? 'bg-status-expired/20 text-status-expired' : '' }}
                        {{ $statusColor === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ $statusLabel }}
                    </span>
                </td>

                {{-- Actions --}}
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button wire:click="switchToEdit({{ $voucher->id }})"
                            class="w-8 h-8 flex items-center justify-center text-info hover:bg-info/10 rounded-lg transition-all"
                            title="Edit">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <button wire:click="duplicateVoucher({{ $voucher->id }})"
                            class="w-8 h-8 flex items-center justify-center text-status-draft hover:bg-status-draft/10 rounded-lg transition-all"
                            title="Duplicate">
                            <i class="fas fa-copy text-sm"></i>
                        </button>
                        <button wire:click="deleteVoucher({{ $voucher->id }})" onclick="return confirm('Delete?')"
                            class="w-8 h-8 flex items-center justify-center text-danger hover:bg-danger/10 rounded-lg transition-all"
                            title="Delete">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </div>
                </td>
            </tr>

            @if ($loop->last)
                </tbody>
                </table>
        </div>
    @endif

@empty
    {{-- Empty State --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 md:p-12 text-center">
        <div class="flex flex-col items-center justify-center text-gray-400">
            <i class="fas fa-ticket-alt text-5xl md:text-6xl mb-4"></i>
            <p class="text-base md:text-lg font-semibold text-gray-600">Voucher Tidak Ditemukan</p>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Ayo coba buat voucher baru!</p>
            <button wire:click="switchToCreate"
                class="mt-4 bg-primary hover:bg-light-primary text-white px-6 py-2 rounded-lg font-semibold transition-all text-sm">
                <i class="fas fa-plus"></i> Buat Voucher
            </button>
        </div>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if ($vouchers->hasPages())
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        {{ $vouchers->links() }}
    </div>
@endif

</div>
