{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Addons Management</h2>
        <p class="text-sm text-gray-600 mt-1 hidden md:inline">Kelola tambahan servis dan item untuk booking</p>
    </div>
    <button wire:click="switchToCreate"
        class="bg-primary hover:bg-light-primary text-white px-6 py-3 rounded-lg font-semibold transition-all flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah
    </button>
</div>

{{-- Statistics Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">


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

    {{-- Inactive --}}
    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Inactive</p>
                <p class="text-2xl font-bold text-danger">{{ $stats['inactive'] }}</p>
            </div>
            <div class="bg-danger/20 p-3 rounded-lg">
                <i class="fas fa-times-circle text-danger text-xl"></i>
            </div>
        </div>
    </div>

    {{-- With Inventory --}}
    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">With Inventory</p>
                <p class="text-2xl font-bold text-info">{{ $stats['with_inventory'] }}</p>
            </div>
            <div class="bg-info/20 p-3 rounded-lg">
                <i class="fas fa-warehouse text-info text-xl"></i>
            </div>
        </div>
    </div>


</div>

{{-- Filters & Search --}}
<div class="bg-white rounded-lg shadow border border-gray-200 p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Search --}}
        <div class="lg:col-span-2">
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" wire:model.live.debounce.300ms="search"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                    placeholder="Search addons...">
            </div>
        </div>

        {{-- Pricing Type Filter --}}
        <div>
            <select wire:model.live="pricingTypeFilter"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">All Pricing Types</option>
                <option value="per_booking">Per Booking</option>
                <option value="per_unit_per_night">Per Unit/Night</option>
                <option value="per_person">Per Person</option>
                <option value="per_hour">Per Hour</option>
                <option value="per_slot">Per Slot</option>
            </select>
        </div>

        {{-- Status Filter --}}
        <div>
            <select wire:model.live="statusFilter"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        {{-- Stock Filter --}}
        <div>
            <select wire:model.live="stockFilter"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">All Stock</option>
                <option value="in">In Stock</option>
                <option value="low">Low Stock</option>
                <option value="out">Out of Stock</option>
            </select>
        </div>
    </div>
</div>

{{-- Addons Table --}}
<div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Addon
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pricing
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Limits
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($addons as $addon)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Addon Info --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if ($addon->image)
                                    <img src="{{ $addon->image }}" alt="{{ $addon->name }}"
                                        class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                @else
                                    <div
                                        class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                        <i class="fas fa-puzzle-piece text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $addon->name }}</p>
                                    @if ($addon->description)
                                        <p class="text-xs text-gray-500 line-clamp-1">{{ $addon->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Pricing --}}
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $addon->formatted_price }}</p>
                                <div class="flex items-center gap-1 text-xs text-gray-500 mt-0.5">
                                    <i class="fas {{ $addon->getPricingIcon() }}"></i>
                                    <span>{{ $addon->getPricingTypeLabel() }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Stock --}}
                        <td class="px-6 py-4">
                            @if ($addon->has_inventory)
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-1 text-xs font-semibold rounded-full
                                        {{ $addon->getStockStatusColor() === 'green' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $addon->getStockStatusColor() === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $addon->getStockStatusColor() === 'red' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $addon->stock_quantity }} units
                                    </span>
                                    @if ($addon->has_inventory)
                                        <button wire:click="openStockModal({{ $addon->id }})"
                                            class="text-primary hover:text-light-primary transition-colors"
                                            title="Adjust Stock">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                </div>
                                @if ($addon->isLowStock())
                                    <p class="text-xs text-yellow-600 mt-1">
                                        <i class="fas fa-exclamation-triangle"></i> Low stock alert
                                    </p>
                                @endif
                            @else
                                <span class="text-xs text-gray-500 italic">No inventory</span>
                            @endif
                        </td>

                        {{-- Limits --}}
                        <td class="px-6 py-4">
                            <div class="text-xs text-gray-600">
                                <p>Min: {{ $addon->min_quantity }}</p>
                                <p>Max: {{ $addon->max_quantity ?? '∞' }}</p>
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            <button wire:click="toggleStatus({{ $addon->id }})"
                                class="px-3 py-1 text-xs font-semibold rounded-full transition-all
                                {{ $addon->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                {{ $addon->is_active ? '✓ Active' : '✗ Inactive' }}
                            </button>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="switchToEdit({{ $addon->id }})"
                                    class="text-info hover:text-info/70 transition-colors cursor-pointer"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteAddon({{ $addon->id }})"
                                    wire:confirm="Apakah anda yakin ingin menghapus addon ini?"
                                    class="text-danger hover:text-danger/70 transition-colors cursor-pointer"
                                    title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-puzzle-piece text-6xl mb-4"></i>
                                <p class="text-lg font-semibold text-gray-600">Data Addon tidak ditemukan</p>
                                <p class="text-sm text-gray-500 mt-1">Buat addon pertama Anda untuk memulai</p>
                                <button wire:click="switchToCreate"
                                    class="mt-4 bg-primary hover:bg-light-primary text-white px-6 py-2 rounded-lg font-semibold transition-all">
                                    <i class="fas fa-plus"></i> Tambah Addon
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($addons->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $addons->links() }}
        </div>
    @endif
</div>
