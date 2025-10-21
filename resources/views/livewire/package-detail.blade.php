<div class="min-h-screen bg-neutral">
    <!-- Hero Section with Large Image -->
    <section class="relative h-[70vh]">
        @if ($selectedImage)
            <img src="{{ asset('storage/' . $selectedImage) }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                <i class="fas fa-image text-6xl"></i>
            </div>
        @endif

        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

        <!-- Breadcrumb Overlay -->
        {{-- <nav class="absolute top-6 left-0 right-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 hidden lg:flex text-sm">
            <a href="/" class="text-white/90 hover:text-white">Home</a>
            <span class="mx-2 text-white/60">/</span>
            <a href="/paket-wisata" class="text-white/90 hover:text-white">Packages</a>
            <span class="mx-2 text-white/60">/</span>
            <span class="text-white">{{ $product->name }}</span>
        </nav> --}}

        <!-- Title Overlay -->
        <div
            class="absolute bottom-0 left-0 right-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 flex justify-between items-end">
            <div>
                <span
                    class="text-sm px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-white font-medium mb-3 inline-block">
                    {{ ucfirst($product->type) }}
                </span>
                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3 drop-shadow-lg">
                    {{ $product->name }}
                </h1>
                <div class="flex items-center gap-4 text-white/90">
                    @if ($product->duration_type)
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>{{ ucfirst($product->duration_type) }}</span>
                        </div>
                    @endif
                    @if ($product->capacity_per_unit)
                        <div class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            <span>{{ $product->capacity_per_unit }} guests</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class=" hidden lg:flex flex-col gap-2">
                @if ($product->images && count($product->images) > 1)
                    @foreach ($product->images as $image)
                        <button wire:click="selectImage('{{ $image }}')"
                            class="flex-shrink-0 size-24 rounded-lg overflow-hidden border-2 transition-all
                                   {{ $selectedImage === $image ? 'border-white ring-2 ring-white/50' : 'border-white/30 hover:border-white/60' }}">
                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery"
                                class="w-full h-full object-cover">
                        </button>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Thumbnail Gallery -->
    @if ($product->images && count($product->images) > 1)
        <section class="bg-white lg:hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex gap-3 overflow-x-auto scrollbar-hide">
                    @foreach ($product->images as $image)
                        <button wire:click="selectImage('{{ $image }}')"
                            class="flex-shrink-0 size-24 md:size-28 lg:size-32 rounded-lg overflow-hidden border-2 transition-all
                                   {{ $selectedImage === $image ? 'border-primary ring-2 ring-primary/20' : 'border-gray-200 hover:border-gray-300' }}">
                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery"
                                class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Main Content -->
    <section class="py-8 lg:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Content -->
                <div class="lg:col-span-2 space-y-9">
                    <!-- Description -->
                    <div>
                        <h2 class="text-2xl font-bold mb-4 flex items-center">
                            Tentang Paket Ini
                        </h2>
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            {{ $product->description ?? 'No description available.' }}
                        </div>
                    </div>

                    <!-- Facilities -->
                    @if ($product->facilities && count($product->facilities) > 0)
                        <div>
                            <h3 class="text-xl font-bold mb-4 flex items-center">
                                Fasilitas Unggulan
                            </h3>
                            <div class="grid sm:grid-cols-2 gap-3">
                                @foreach ($product->facilities as $facility)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                        <span class="text-gray-700">{{ $facility }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!--lokasi-->
                    <div>
                        <h2 class="text-xl font-bold mb-4 flex items-center">
                            Lokasi Kampung Kopi Camp
                        </h2>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.604370894168!2d115.03691309999999!3d-8.342048799999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd229a2ecb99547%3A0x8a1a833f13b4a85b!2sKampung%20Kopi%20Camp!5e0!3m2!1sid!2sid!4v1760613519348!5m2!1sid!2sid"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-56 md:h-64 lg:h-80 rounded-lg"></iframe>
                    </div>

                    {{-- kebijakan --}}
                    <div>
                        <h2 class="text-xl font-bold mb-4 flex items-center">
                            Peraturan & Kebijakan
                        </h2>
                        <div class="space-y-8">
                            <div class="w-full flex flex-col lg:flex-row gap-2 lg:gap-8">
                                <h3 class="text-lg font-semibold lg:w-[30%]">Prosedur Check-in</h3>
                                <p class="text-gray-600 lg:w-[70%]">Check-in mulai pukul 14.00 dan check-out sebelum
                                    pukul 12.00.
                                    Harap informasikan perkiraan waktu kedatangan Anda sebelumnya.</p>
                            </div>
                            <div class="w-full flex flex-col lg:flex-row gap-2 lg:gap-8">
                                <h3 class="text-lg font-semibold lg:w-[30%]">Kebijakan Lainnya</h3>
                                <p class="text-gray-600 lg:w-[70%]">
                                    Dilarang merokok di area dalam ruangan. Harap jaga ketenangan dan hormati tamu lain.
                                    Hewan peliharaan tidak diperbolehkan kecuali telah mendapatkan izin sebelumnya.
                                    Harap ikuti semua peraturan yang ditetapkan oleh pengelola properti.
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Faq --}}
                    <div>
                        <h2 class="text-xl font-bold mb-4 flex items-center">
                            Pertanyaan yang sering ditanyakan
                        </h2>
                        <div class="space-y-3">
                            <!-- FAQ Item 1 -->
                            <div x-data="{ open: false }"
                                class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                                <button @click="open = !open"
                                    class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-gray-800">Bagaimana cara melakukan
                                        pembayaran?</span>
                                    <i class="fas fa-chevron-down transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="px-4 pb-4">
                                    <p class="text-gray-600">Kami menerima berbagai metode pembayaran, termasuk transfer
                                        bank, kartu kredit, dan dompet digital.</p>
                                </div>
                            </div>

                            <!-- FAQ Item 2 -->
                            <div x-data="{ open: false }"
                                class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                                <button @click="open = !open"
                                    class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-gray-800">Apakah saya bisa membatalkan
                                        reservasi?</span>
                                    <i class="fas fa-chevron-down transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="px-4 pb-4">
                                    <p class="text-gray-600">Ya, Anda dapat membatalkan reservasi dengan gratis hingga
                                        24 jam sebelum waktu check-in.</p>
                                </div>
                            </div>

                            <!-- FAQ Item 3 -->
                            <div x-data="{ open: false }"
                                class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                                <button @click="open = !open"
                                    class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-gray-800">Apakah hewan peliharaan
                                        diperbolehkan?</span>
                                    <i class="fas fa-chevron-down transition-transform duration-200"
                                        :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="px-4 pb-4">
                                    <p class="text-gray-600">Mohon maaf, untuk saat ini kami belum menerima tamu yang
                                        membawa hewan peliharaan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Right Sidebar - Booking Card -->
                <div class="lg:sticky lg:top-6 h-fit hidden lg:block">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="mb-6">
                            <span class="text-gray-600 text-sm">Mulai dari</span>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-3xl font-bold text-primary">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <span class="text-gray-500 text-sm">
                                / {{ $product->duration_type === 'daily' ? 'hari' : 'orang' }}
                            </span>
                        </div>

                        <a href="{{ Route('booking.flow', $product->slug) }}"
                            class="flex items-center justify-center w-full bg-primary hover:bg-light-primary text-white font-semibold py-4 rounded-xl transition-all duration-200 active:scale-95 shadow-lg shadow-primary/25">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Pesan Sekarang
                        </a>

                        <div class="mt-4 pt-4 border-t border-gray-200 space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-accent mr-2"></i>
                                <span>Pembayaran aman & terpercaya</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-undo text-accent mr-2"></i>
                                <span>Gratis pembatalan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Packages -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-8">Paket Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedPackages as $relatedProduct)
                    <livewire:package-card :product="$relatedProduct" :key="$relatedProduct->id" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Mobile Bottom Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl p-4 lg:hidden z-50">
        <div class="flex items-center justify-between gap-4">
            <div>
                <span class="text-gray-600 text-xs">Mulai dari</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xl font-bold text-primary">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <span class="text-gray-500 text-xs">
                        /{{ $product->duration_type === 'daily' ? 'hari' : 'orang' }}
                    </span>
                </div>
            </div>
            <a href="{{ Route('booking.flow', $product->slug) }}"
                class="bg-primary hover:bg-light-primary text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 active:scale-95 shadow-lg">
                Pesan
            </a>
        </div>
    </div>
</div>
