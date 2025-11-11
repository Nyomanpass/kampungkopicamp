<div class="p-6 bg-white rounded-lg shadow-sm">
    {{-- Notifications --}}
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

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Website Settings</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola konten dan pengaturan website</p>
    </div>

    {{-- Tabs Navigation --}}
    <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto">
            <button wire:click="$set('activeTab', 'banners')"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                {{ $activeTab === 'banners' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-images mr-2"></i>
                Banners
            </button>
            <button wire:click="$set('activeTab', 'contact')"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                {{ $activeTab === 'contact' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-address-book mr-2"></i>
                Contact Info
            </button>
            <button wire:click="$set('activeTab', 'maps')"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                {{ $activeTab === 'maps' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-map-marked-alt mr-2"></i>
                Google Maps
            </button>
            <button wire:click="$set('activeTab', 'social')"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                {{ $activeTab === 'social' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-share-alt mr-2"></i>
                Social Media
            </button>
            <button wire:click="$set('activeTab', 'faq')"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                {{ $activeTab === 'faq' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-question-circle mr-2"></i>
                FAQ
            </button>
            <button wire:click="$set('activeTab', 'rules')"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                {{ $activeTab === 'rules' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-clipboard-list mr-2"></i>
                House Rules
            </button>
        </nav>
    </div>

    {{-- Tab Content --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        @if ($activeTab === 'banners')
            @include('livewire.admin.settings.banners')
        @elseif ($activeTab === 'contact')
            @include('livewire.admin.settings.contact')
        @elseif ($activeTab === 'maps')
            @include('livewire.admin.settings.maps')
        @elseif ($activeTab === 'social')
            @include('livewire.admin.settings.social')
        @elseif ($activeTab === 'faq')
            @include('livewire.admin.settings.faq')
        @elseif ($activeTab === 'rules')
            @include('livewire.admin.settings.rules')
        @endif
    </div>
</div>
