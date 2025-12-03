<div class="space-y-6">
    {{-- Header --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">

                Product Management
            </h1>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola Akomodasi, Touring dan Area Rental</p>
        </div>
        <button wire:click="switchToCreate"
            class="bg-primary hover:bg-light-primary text-white px-4 md:px-6 py-3 md:py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
            <i class="fas fa-plus"></i>
            <span>Tambah</span>
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Accommodation</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $stats['accommodation'] }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-bed text-light-primary text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Touring</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $stats['touring'] }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-hiking text-light-primary text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Area Rental</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $stats['area_rental'] }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-map-marked-alt text-light-primary text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
        <div class="flex flex-col md:flex-row justify-center md:items-end gap-4">
            {{-- Search --}}
            <div class="w-full md:w-[90%]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Search by name or description...">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

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
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    @click.away="showFilters = false"
                    class="absolute right-0 z-10 mt-2 w-full md:w-[520px] bg-white rounded-lg shadow-lg border border-gray-200 p-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Type Filter --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select wire:model.live="typeFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                <option value="">All Types</option>
                                <option value="accommodation">Accommodation</option>
                                <option value="touring">Touring</option>
                                <option value="area_rental">Area Rental</option>
                            </select>
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select wire:model.live="statusFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>


                    </div>
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

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div
                class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                {{-- Product Image --}}
                <div class="relative h-48 bg-gray-200">
                    @if (!empty($product->images) && isset($product->images[0]))
                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif

                    {{-- Status Badge --}}
                    <div class="absolute top-2 right-2">
                        @if ($product->is_active)
                            <span class="bg-success text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                                <i class="fas fa-check-circle"></i> Active
                            </span>
                        @else
                            <span class="bg-danger text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                                <i class="fas fa-times-circle"></i> Inactive
                            </span>
                        @endif
                    </div>

                    {{-- Type Badge --}}
                    <div class="absolute top-2 left-2">
                        @php
                            $typeConfig = [
                                'accommodation' => ['bg' => 'bg-info', 'icon' => 'fa-bed'],
                                'touring' => ['bg' => 'bg-info', 'icon' => 'fa-hiking'],
                                'area_rental' => ['bg' => 'bg-info', 'icon' => 'fa-map-marked-alt'],
                            ];
                            $config = $typeConfig[$product->type] ?? $typeConfig['accommodation'];
                        @endphp
                        <span
                            class="{{ $config['bg'] }} text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                            <i class="fas {{ $config['icon'] }}"></i>
                            {{ ucfirst(str_replace('_', ' ', $product->type)) }}
                        </span>
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2 min-h-[2.5rem]">
                        {{ $product->description ?: 'No description available' }}
                    </p>

                    {{-- Product Details --}}
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Price</span>
                            <span class="font-semibold text-primary">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        @if ($product->type !== 'touring')
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Capacity/Unit</span>
                                <span class="font-semibold text-gray-900">{{ $product->capacity_per_unit }}
                                    person(s)</span>
                            </div>
                        @endif



                        @if ($product->type == 'touring')
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Max Participant</span>
                                <span class="font-semibold text-gray-900">{{ $product->max_participant }}
                                    person(s)</span>
                            </div>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2">
                        <button wire:click="switchToEdit({{ $product->id }})"
                            class="flex-1 bg-primary hover:bg-primary/70 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-all flex items-center justify-center gap-1">
                            <i class="fas fa-edit"></i> Edit
                        </button>

                        <button wire:click="toggleActive({{ $product->id }})"
                            class="flex-1 {{ $product->is_active ? 'bg-danger hover:bg-danger/70' : 'bg-success hover:bg-success/70' }} text-neutral px-3 py-2 rounded-lg text-sm font-semibold transition-all flex items-center justify-center gap-1">
                            <i class="fas {{ $product->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                        </button>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow border border-gray-200 p-12 text-center">
                <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-gray-600 mb-6">Mulai dengan membuat produk pertama Anda.</p>
                <button wire:click="switchToCreate"
                    class="bg-primary hover:bg-light-primary text-white px-6 py-3 rounded-lg font-semibold transition-all inline-flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Buat Produk
                </button>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($products->hasPages())
        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
