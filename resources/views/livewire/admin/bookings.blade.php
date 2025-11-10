<div class="md:p-6 bg-white rounded-lg">
    {{-- Flash Messages (reuse toast component) --}}
    <div class="fixed top-4 right-4 z-80 w-96 max-w-[calc(100vw-2rem)] space-y-3">
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

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">

                Booking Management
            </h1>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola semua booking online & offline</p>
        </div>
        @if ($viewMode === 'list')
            <button wire:click="switchToCreate"
                class="bg-primary hover:bg-light-primary text-white px-4 md:px-6 py-3 md:py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
                <i class="fas fa-plus"></i>
                <span>Tambah</span>
            </button>
        @else
            <button wire:click="switchToList"
                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 md:px-6 py-3 md:py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-sm text-sm md:text-base">
                {{-- <i class="fas fa-plus"></i> --}}
                <span>Back To List</span>
            </button>
        @endif
    </div>

    {{-- Content based on viewMode --}}
    @if ($viewMode === 'list')
        @include('livewire.admin.bookings.list')
    @elseif($viewMode === 'create')
        @include('livewire.admin.bookings.create')
    @elseif($viewMode === 'detail')
        @include('livewire.admin.bookings.detail')
    @endif
</div>
