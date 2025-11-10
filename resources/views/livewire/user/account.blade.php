<div class="" x-data="{
    showEditProfile: false,
    showChangePassword: false,
    showFAQ: false
}">
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

    <header
        class="pt-8 px-4 py-5 border-b border-gray-300 mb-5 flex items-center justify-start gap-3 bg-gradient-to-b from-light-primary/40 to-light-primary/10">
        <div
            class="rounded-full size-18 bg-light-primary font-semibold flex items-center justify-center text-white text-2xl">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="flex flex-col items-start text-center">
            <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
        </div>
    </header>

    {{-- account setting goes here --}}
    <div class="w-full px-4 ">
        <div class="pb-4 mb-4 border-b border-gray-200 w-full flex flex-col">
            <p class="font-semibold mb-2">Account Settings</p>
            <button @click="showEditProfile = true" class="py-2 hover:bg-gray-100 text-left">
                <i class="fas fa-user-pen mr-3"></i>Edit Profile
            </button>
            <button @click="showChangePassword = true" class="py-2 hover:bg-gray-100 text-left">
                <i class="fas fa-lock mr-3"></i>Ubah Password
            </button>
        </div>
        <div class="pb-4 mb-4 border-b border-gray-200 w-full flex flex-col">
            <p class="font-semibold mb-2">Help</p>
            <a href="" class="py-2 hover:bg-gray-100"><i class="fas fa-headset mr-3"></i>Customer Service</a>
            <button @click="showFAQ = true" class="py-2 hover:bg-gray-100 text-left">
                <i class="fas fa-question-circle mr-3"></i>FAQ
            </button>
        </div>
        <a href="{{ route('logout') }}" class="py-2 text-danger lg:hidden"><i class="fas fa-sign-out-alt mr-3"></i>Log
            Out</a>
    </div>

    {{-- Edit Profile Slide Panel --}}
    <div>
        {{-- Overlay --}}
        <div x-show="showEditProfile" x-cloak x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="showEditProfile = false"
            class="fixed inset-0 z-40 bg-gray-500/50" style="display: none;"></div>

        {{-- Slide Panel --}}
        <div x-show="showEditProfile" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full" @profile-updated.window="showEditProfile = false"
            class="fixed top-0 right-0 h-full w-full lg:max-w-4xl  bg-white shadow-2xl z-70 overflow-y-auto"
            style="display: none;">

            <div class="min-h-screen relative">
                {{-- Header --}}
                <div
                    class="sticky top-0 bg-white border-b border-gray-200 px-2 py-4 flex items-center justify-between shadow-sm">

                    <button @click="showEditProfile = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-angle-left text-xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold">Edit Profile</h2>
                    <div class="p-2 text-white">
                        <i class="fas fa-times text-xl"></i>
                    </div>
                </div>

                {{-- Form Content --}}
                <div class="px-4 py-6">
                    <form wire:submit.prevent="updateProfile" class="space-y-5">
                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" wire:model="name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-light-primary focus:border-transparent"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" wire:model="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-light-primary focus:border-transparent"
                                placeholder="Masukkan email">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" id="phone" wire:model="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-light-primary focus:border-transparent"
                                placeholder="Masukkan nomor telepon">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="absolute bottom-0 left-0 right-0 z-60 flex gap-3 py-4 px-4">

                            <button type="submit"
                                class="w-full px-6 py-3 bg-light-primary text-white rounded-lg hover:bg-light-primary/90 font-medium">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Slide Panel --}}
    <div>
        <div x-show="showChangePassword" x-cloak x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="showEditProfile = false"
            class="fixed inset-0 z-40 bg-gray-500/50" style="display: none;"></div>

        <div x-show="showChangePassword" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full" @password-updated.window="showChangePassword = false"
            class="fixed top-0 right-0 h-full w-full lg:max-w-4xl  bg-white shadow-2xl z-70 overflow-y-auto"
            style="display: none;">

            <div class="min-h-screen">
                {{-- Header --}}
                <div
                    class="sticky top-0 bg-white border-b border-gray-200 px-2 py-4 flex items-center justify-between shadow-sm">
                    <button @click="showChangePassword = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-angle-left text-xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold">Ubah Password</h2>
                    <div class="p-2">
                        <i class="fas fa-angle-left text-xl text-white"></i>
                    </div>
                </div>

                {{-- Form Content --}}
                <div class="px-4 py-6">
                    <form wire:submit.prevent="updatePassword" class="space-y-5">
                        {{-- Current Password --}}
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="current_password" wire:model="current_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-light-primary focus:border-transparent"
                                placeholder="Masukkan password saat ini">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="new_password" wire:model="new_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-light-primary focus:border-transparent"
                                placeholder="Masukkan password baru (min. 8 karakter)">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm New Password --}}
                        <div>
                            <label for="new_password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="new_password_confirmation"
                                wire:model="new_password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-light-primary focus:border-transparent"
                                placeholder="Ulangi password baru">
                        </div>

                        {{-- Password Requirements --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm font-medium text-blue-900 mb-2">Persyaratan Password:</p>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li><i class="fas fa-check mr-2"></i>Minimal 8 karakter</li>
                                <li><i class="fas fa-check mr-2"></i>Kombinasi huruf dan angka lebih aman</li>
                            </ul>
                        </div>

                        {{-- Submit Button --}}
                        <div class="absolute bottom-0 left-0 right-0 z-60 flex gap-3 py-4 px-4">

                            <button type="submit"
                                class="w-full px-6 py-4 bg-light-primary text-white rounded-lg hover:bg-light-primary/90 font-medium">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FAQ Slide Panel --}}
    <div>
        <div x-show="showFAQ" x-cloak x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="showEditProfile = false"
            class="fixed inset-0 z-40 bg-gray-500/50" style="display: none;"></div>

        <div x-show="showFAQ" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed top-0 right-0 h-full w-full lg:max-w-4xl  bg-white shadow-2xl z-70 overflow-y-auto"
            style="display: none;">

            <div class="min-h-screen">
                {{-- Header --}}
                <div
                    class="sticky top-0 bg-white border-b border-gray-200 px-4 py-4 flex items-center justify-between shadow-sm">
                    <button @click="showFAQ = false" class="p-2 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-angle-left text-xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold">Frequently Asked Questions</h2>
                    <i class="fas fa-times text-xl text-white"></i>
                </div>

                {{-- FAQ Content --}}
                <div class="p-6" x-data="{ openFaq: null }">
                    <div class="space-y-4">
                        {{-- FAQ Item 1 --}}
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 1 ? null : 1"
                                class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left">
                                <span class="font-medium text-gray-900">Bagaimana cara melakukan pemesanan?</span>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === 1 }"></i>
                            </button>
                            <div x-show="openFaq === 1" x-collapse
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Untuk melakukan pemesanan, Anda dapat memilih paket wisata yang diinginkan dari
                                    halaman
                                    "Paket Wisata",
                                    pilih tanggal dan jumlah peserta, kemudian klik tombol "Pesan Sekarang".
                                    Isi data diri dan lakukan pembayaran sesuai instruksi yang diberikan.
                                </p>
                            </div>
                        </div>

                        {{-- FAQ Item 2 --}}
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 2 ? null : 2"
                                class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left">
                                <span class="font-medium text-gray-900">Metode pembayaran apa saja yang
                                    tersedia?</span>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === 2 }"></i>
                            </button>
                            <div x-show="openFaq === 2" x-collapse
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Kami menerima berbagai metode pembayaran termasuk transfer bank, e-wallet (GoPay,
                                    OVO,
                                    Dana),
                                    dan kartu kredit/debit. Semua pembayaran diproses secara aman melalui payment
                                    gateway
                                    terpercaya.
                                </p>
                            </div>
                        </div>

                        {{-- FAQ Item 3 --}}
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 3 ? null : 3"
                                class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left">
                                <span class="font-medium text-gray-900">Bagaimana cara menggunakan voucher?</span>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === 3 }"></i>
                            </button>
                            <div x-show="openFaq === 3" x-collapse
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Voucher dapat digunakan pada saat checkout pemesanan. Salin kode voucher dari
                                    halaman
                                    "Rewards",
                                    kemudian masukkan kode tersebut pada kolom voucher di halaman pembayaran.
                                    Diskon akan otomatis teraplikasi jika voucher memenuhi syarat dan ketentuan yang
                                    berlaku.
                                </p>
                            </div>
                        </div>

                        {{-- FAQ Item 4 --}}
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 4 ? null : 4"
                                class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left">
                                <span class="font-medium text-gray-900">Apakah bisa membatalkan atau mengubah
                                    pesanan?</span>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === 4 }"></i>
                            </button>
                            <div x-show="openFaq === 4" x-collapse
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Pembatalan atau perubahan pesanan dapat dilakukan maksimal 3 hari sebelum tanggal
                                    check-in.
                                    Silakan hubungi customer service kami untuk proses pembatalan atau perubahan.
                                    Ketentuan refund akan disesuaikan dengan kebijakan yang berlaku.
                                </p>
                            </div>
                        </div>

                        {{-- FAQ Item 5 --}}
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 5 ? null : 5"
                                class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left">
                                <span class="font-medium text-gray-900">Apa yang termasuk dalam paket wisata?</span>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === 5 }"></i>
                            </button>
                            <div x-show="openFaq === 5" x-collapse
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Setiap paket wisata memiliki fasilitas yang berbeda-beda. Umumnya sudah termasuk
                                    transportasi,
                                    pemandu wisata, tiket masuk objek wisata, dan makan sesuai itinerary.
                                    Untuk detail lengkap, silakan cek deskripsi pada masing-masing paket wisata.
                                </p>
                            </div>
                        </div>

                        {{-- FAQ Item 6 --}}
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button @click="openFaq = openFaq === 6 ? null : 6"
                                class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left">
                                <span class="font-medium text-gray-900">Bagaimana cara menghubungi customer
                                    service?</span>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === 6 }"></i>
                            </button>
                            <div x-show="openFaq === 6" x-collapse
                                class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Anda dapat menghubungi customer service kami melalui WhatsApp, email, atau langsung
                                    datang ke kantor kami.
                                    Tim kami siap membantu Anda setiap hari dari pukul 08.00 - 20.00 WITA.
                                    Informasi kontak lengkap tersedia di halaman "Contact".
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Section --}}
                    <div class="mt-8 bg-light-primary/10 border border-light-primary/20 rounded-lg p-6">
                        <p class="font-semibold text-gray-900 mb-2">Masih ada pertanyaan?</p>
                        <p class="text-sm text-gray-600 mb-4">
                            Tim customer service kami siap membantu Anda dengan senang hati.
                        </p>
                        <a href=""
                            class="inline-flex items-center gap-2 px-4 py-2 bg-light-primary text-white rounded-lg hover:bg-light-primary/90 text-sm font-medium">
                            <i class="fas fa-headset"></i>
                            Hubungi Customer Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
