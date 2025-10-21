@props(['show' => false, 'view' => 'login'])

<div x-data="{ show: @entangle('showLoginModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
    @keydown.escape.window="show = false"
    x-effect="document.body.style.overflow = show ? 'hidden' : 'auto'">
    <!-- Backdrop -->
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500/75 transition-opacity" @click="$wire.closeLoginModal()"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all w-full max-w-md">
            <!-- Close Button -->
            <button @click="$wire.closeLoginModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <!-- Login View -->
            @if ($view === 'login')
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                            <i class="fas fa-sign-in-alt text-primary text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Login</h2>
                        <p class="text-sm text-gray-600 mt-2">Login untuk menggunakan voucher</p>
                    </div>

                    <form wire:submit.prevent="login" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" wire:model="loginEmail"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="email@example.com">
                            @error('loginEmail')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" wire:model="loginPassword"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="••••••••">
                            @error('loginPassword')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-light-primary transition-all disabled:opacity-50">
                            <span wire:loading.remove wire:target="login">Login</span>
                            <span wire:loading wire:target="login">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Loading...
                            </span>
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <button wire:click="switchToRegister" class="text-primary font-semibold hover:underline">
                                Daftar sekarang
                            </button>
                        </p>
                    </div>
                </div>
            @else
                <!-- Register View -->
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                            <i class="fas fa-user-plus text-primary text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Daftar</h2>
                        <p class="text-sm text-gray-600 mt-2">Buat akun untuk mendapatkan promo</p>
                    </div>

                    <form wire:submit.prevent="register" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" wire:model="registerName"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="John Doe">
                            @error('registerName')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" wire:model="registerEmail"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="email@example.com">
                            @error('registerEmail')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                            <input type="tel" wire:model="registerPhone"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="08xxxxxxxxxx">
                            @error('registerPhone')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" wire:model="registerPassword"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="••••••••">
                            @error('registerPassword')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" wire:model="registerPasswordConfirmation"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="••••••••">
                        </div>

                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-light-primary transition-all disabled:opacity-50">
                            <span wire:loading.remove wire:target="register">Daftar</span>
                            <span wire:loading wire:target="register">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Loading...
                            </span>
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <button wire:click="switchToLogin" class="text-primary font-semibold hover:underline">
                                Login di sini
                            </button>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
