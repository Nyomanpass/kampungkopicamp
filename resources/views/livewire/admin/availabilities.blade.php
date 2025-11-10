<div class="space-y-6 md:p-6 bg-white rounded-lg">
    {{-- Flash Messages (reuse toast component) --}}
    <div class="fixed top-4 right-4 z-90 w-96 max-w-[calc(100vw-2rem)] space-y-3">
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

    {{-- Header --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">

                Manajemen Ketersediaan
            </h1>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola stok dan ketersediaan untuk semua produk</p>
        </div>
        <button wire:click="openBulkModal"
            class="bg-primary hover:bg-light-primary text-white px-4 md:px-6 py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
            <i class="fas fa-calendar-plus"></i>
            <span>Bulk Override</span>
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold text-light-primary">{{ $stats['total_products'] }}</p>
                </div>
                <div class="bg-light-primary/20 p-3 rounded-lg">
                    <i class="fas fa-box text-light-primary text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Full Tersedia</p>
                    <p class="text-2xl font-bold text-success">{{ $stats['available_dates'] }}</p>
                </div>
                <div class="bg-success/20 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-success text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Stok Rendah</p>
                    <p class="text-2xl font-bold text-warning">{{ $stats['low_stock_dates'] }}</p>
                </div>
                <div class="bg-warning/20 p-3 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-warning text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Full Book</p>
                    <p class="text-2xl font-bold text-danger">{{ $stats['fully_booked_dates'] }}</p>
                </div>
                <div class="bg-danger/20 p-3 rounded-lg">
                    <i class="fas fa-times-circle text-danger text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Stok Berubah</p>
                    <p class="text-2xl font-bold text-info">{{ $stats['overridden_dates'] }}</p>
                </div>
                <div class="bg-info/20 p-3 rounded-lg">
                    <i class="fas fa-edit text-info text-xl"></i>
                </div>
            </div>
        </div>


    </div>

    {{-- Filters & Navigation --}}

    <div class="flex flex-col md:flex-row gap-4 mb-4 mt-10">
        {{-- Product Type Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Produk</label>
            <select wire:model.live="selectedProductType"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">All Types</option>
                <option value="accommodation">Accommodation</option>
                <option value="touring">Touring</option>
                <option value="area_rental">Area Rental</option>
            </select>
        </div>

        {{-- Specific Product Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Produk Spesifik</label>
            <select wire:model.live="selectedProductId"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                <option value="">All Products</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>


    </div>

    {{-- Calendar --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        {{-- Calendar Header --}}
        <div class="flex items-center justify-between mb-6">
            <button wire:click="previousMonth"
                class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-all">
                <i class="fas fa-chevron-left text-xl"></i>
            </button>

            <h3 class="text-xl font-bold text-gray-900">
                {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}
            </h3>

            <button wire:click="nextMonth"
                class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-all">
                <i class="fas fa-chevron-right text-xl"></i>
            </button>
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-2">
            {{-- Day Headers --}}
            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="text-center font-semibold text-gray-700 text-sm py-2">
                    {{ $day }}
                </div>
            @endforeach

            {{-- Calendar Dates --}}
            @foreach ($calendarDates as $week)
                @foreach ($week as $dateInfo)
                    @php
                        $date = $dateInfo['date'];
                        $summary = $dateInfo['summary'];
                        $colorClasses = [
                            'green' => 'bg-success',
                            'yellow' => 'bg-warning',
                            'red' => 'bg-danger',
                            'gray' => 'bg-status-draft',
                            'blue' => 'bg-info',
                        ];
                        $bgColor = $colorClasses[$summary['color']] ?? 'bg-gray-200';
                    @endphp

                    <div wire:click="openDateModal('{{ $date->format('Y-m-d') }}')"
                        class="min-h-24 p-2 border rounded-lg cursor-pointer transition-all hover:shadow-md
                            {{ $dateInfo['is_current_month'] ? 'bg-white border-gray-300' : 'bg-gray-50 border-gray-200' }}
                            {{ $dateInfo['is_today'] ? 'ring-2 ring-primary' : '' }}
                            {{ $dateInfo['is_past'] ? 'opacity-60' : '' }}">

                        {{-- Date Number --}}
                        <div class="flex items-center justify-between mb-1">
                            <span
                                class="text-sm font-semibold {{ $dateInfo['is_today'] ? 'text-primary' : 'text-gray-700' }}">
                                {{ $dateInfo['day'] }}
                            </span>
                            @if ($summary['status'] !== 'no-data')
                                <span class="w-2 h-2 rounded-fulavl {{ $bgColor }}"></span>
                            @endif
                        </div>

                        {{-- Summary --}}
                        @if ($summary['status'] !== 'no-data')
                            <div class="text-xs space-y-0.5">
                                @if (isset($summary['counts']))
                                    @if ($summary['counts']['available'] > 0)
                                        <div class="flex items-center gap-1 text-primarya">
                                            <i class="fas fa-circle text-[6px]"></i>
                                            <span>{{ $summary['counts']['available'] }} avail</span>
                                        </div>
                                    @endif
                                    @if ($summary['counts']['low'] > 0)
                                        <div class="flex items-center gap-1 text-warning">
                                            <i class="fas fa-circle text-[6px]"></i>
                                            <span>{{ $summary['counts']['low'] }} low</span>
                                        </div>
                                    @endif
                                    @if ($summary['counts']['full'] > 0)
                                        <div class="flex items-center gap-1 text-danger">
                                            <i class="fas fa-circle text-[6px]"></i>
                                            <span>{{ $summary['counts']['full'] }} full</span>
                                        </div>
                                    @endif
                                    @if ($summary['counts']['blocked'] > 0)
                                        <div class="flex items-center gap-1 text-status-draft">
                                            <i class="fas fa-ban text-[8px]"></i>
                                            <span>{{ $summary['counts']['blocked'] }} blocked</span>
                                        </div>
                                    @endif
                                    @if ($summary['counts']['overridden'] > 0)
                                        <div class="flex items-center gap-1 text-info">
                                            <i class="fas fa-edit text-[8px]"></i>
                                            <span>{{ $summary['counts']['overridden'] }} Overriden</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <div class="text-xs text-gray-400 italic">No data</div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-gray-200 text-sm">
            <span class="font-semibold text-gray-700">Legend:</span>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-primary rounded"></span>
                <span class="text-gray-700">Available</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-warning rounded"></span>
                <span class="text-gray-700">Low Stock</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-danger rounded"></span>
                <span class="text-gray-700">Fully Booked</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-status-draft rounded"></span>
                <span class="text-gray-700">Blocked</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-info rounded"></span>
                <span class="text-gray-700">Overridden</span>
            </div>
        </div>
    </div>

    {{-- Date Edit Modal --}}
    @if ($showDateModal)
        @include('livewire.admin.availabilities.date-modal')
    @endif

    {{-- Bulk Override Modal --}}
    @if ($showBulkModal)
        @include('livewire.admin.availabilities.bulk-modal')
    @endif
</div>
