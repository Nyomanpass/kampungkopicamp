@props(['show' => false, 'email' => ''])

<div x-data="{ show: @entangle('showEmailConfirmModal') }" x-show="show" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
    @keydown.escape.window="show = false" x-effect="document.body.style.overflow = show ? 'hidden' : 'auto'">
    <!-- Backdrop -->
    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-xl bg-white shadow-2xl transition-all w-full max-w-md">
            <div class="p-8">
                <!-- Icon -->
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100 mb-4">
                    <i class="fas fa-user-check text-yellow-600 text-2xl"></i>
                </div>

                <!-- Content -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                        Email Sudah Terdaftar
                    </h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Email <span class="font-semibold text-primary">{{ $email }}</span> sudah terdaftar di
                        sistem kami.
                    </p>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-2">Keuntungan Login:</p>
                                <ul class="space-y-1 list-disc list-inside">
                                    <li>Gunakan voucher & promo</li>
                                    <li>Lihat riwayat booking</li>
                                    <li>Akses lebih cepat di booking berikutnya</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button wire:click="switchToLoginFromEmail"
                            class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-light-primary transition-all active:scale-95">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login untuk Gunakan Voucher
                        </button>

                        <button wire:click="continueAsGuest"
                            class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-all active:scale-95">
                            Lanjut sebagai Guest
                        </button>
                    </div>

                    <p class="text-xs text-gray-500 mt-4">
                        Dengan login, Anda dapat memanfaatkan semua fitur yang tersedia
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
