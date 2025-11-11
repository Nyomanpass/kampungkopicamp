<div class="min-h-screen overflow-y-hidden max-w-3xl mx-auto space-y-6">
    <div>

        {{-- Flash Messages --}} {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

        <div class="fixed top-4 right-4 z-50 w-96 max-w-[calc(100vw-2rem)] space-y-3">
            @if (session()->has('message'))
                <div wire:key="message-{{ md5(session('message') . microtime()) }}" x-data="{
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
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="transform ease-in duration-200"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-full opacity-0"
                    class="relative rounded-xl border border-green-200 bg-gradient-to-br from-green-50 to-white text-green-800 shadow-lg ring-1 ring-green-100">
                    <div class="flex items-start gap-3 p-4">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                        <div class="flex-1">
                            <p class="font-medium">message</p>
                            <p class="text-sm opacity-90">{{ session('message') }}</p>
                        </div>
                        <button @click="close()" class="p-1.5 rounded-md text-green-700 hover:bg-green-100/60">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="absolute left-0 bottom-0 h-1 bg-green-200/60 w-full overflow-hidden rounded-b-xl">
                        <div class="h-full bg-green-500 transition-all ease-linear" :style="`width: ${progress}%`">
                        </div>
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
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transform ease-in duration-200"
                    x-transition:leave-start="translate-x-0 opacity-100"
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
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-20 h-20 rounded-full bg-primary text-white flex items-center justify-center text-3xl font-bold">
                    {{ strtoupper(substr($name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $name }}</h1>
                    <p class="text-sm text-gray-600">{{ $email }}</p>
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-phone mr-1"></i>{{ $phone ?: 'Belum ada nomor telepon' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-lg shadow-sm">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button wire:click="switchTab('profile')"
                        class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                    {{ $activeTab === 'profile' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fas fa-user mr-2"></i>
                        Edit Profile
                    </button>
                    <button wire:click="switchTab('password')"
                        class="px-6 py-4 text-sm font-medium border-b-2 transition-colors
                    {{ $activeTab === 'password' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <i class="fas fa-lock mr-2"></i>
                        Ubah Password
                    </button>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div class="p-6">
                @if ($activeTab === 'profile')
                    {{-- Edit Profile Form --}}
                    <form wire:submit.prevent="updateProfile" class="space-y-6">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                            @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" wire:model="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                            @error('email') border-red-500 @enderror"
                                placeholder="Masukkan email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" wire:model="phone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Masukkan nomor telepon">
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.dashboard') }}"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">

                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                @else
                    {{-- Change Password Form --}}
                    <form wire:submit.prevent="updatePassword" class="space-y-6">
                        {{-- Current Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <input type="password" wire:model="current_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                            @error('current_password') border-red-500 @enderror"
                                placeholder="Masukkan password saat ini">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" wire:model="new_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                            @error('new_password') border-red-500 @enderror"
                                placeholder="Masukkan password baru (min. 8 karakter)">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Password minimal 8 karakter</p>
                        </div>

                        {{-- Confirm New Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" wire:model="new_password_confirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Ketik ulang password baru">
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end gap-3">
                            <button type="button" wire:click="resetPasswordFields"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                Reset
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">

                                Ubah Password
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
