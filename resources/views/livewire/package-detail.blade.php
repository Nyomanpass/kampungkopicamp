<div class="min-h-screen bg-neutral">
    <!-- Hero Section with Large Image -->
    <section class="relative h-[60vh]">
        @if ($selectedImage)
            <img src="{{ $selectedImage }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
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
                        @if ($product->type == 'touring')
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span>Session</span>
                            </div>
                        @else
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ ucfirst($product->duration_type) }}</span>
                            </div>
                        @endif
                    @endif
                    @if ($product->capacity_per_unit || $product->max_participant)
                        @if ($product->type == 'touring')
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>{{ $product->max_participant }} guests</span>
                            </div>
                        @else
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                <span>{{ $product->capacity_per_unit }} guests</span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class=" hidden lg:flex flex-col gap-2">
                @if (!empty($product->images) && isset($product->images[0]))
                    @foreach ($product->images as $image)
                        <button wire:click="selectImage('{{ $image }}')"
                            class="flex-shrink-0 size-24 rounded-lg overflow-hidden border-2 transition-all
                                   {{ $selectedImage === $image ? 'border-white ring-2 ring-white/50' : 'border-white/30 hover:border-white/60' }}">
                            <img src="{{ $image }}" alt="Gallery" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Thumbnail Gallery -->

    @if (!empty($product->images) && isset($product->images[0]))
        <section class="bg-white lg:hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex gap-3 overflow-x-auto scrollbar-hide">
                    @foreach ($product->images as $image)
                        <button wire:click="selectImage('{{ $image }}')"
                            class="flex-shrink-0 size-24 rounded-lg overflow-hidden border-2 transition-all
                                   {{ $selectedImage === $image ? 'border-white ring-2 ring-white/50' : 'border-white/30 hover:border-white/60' }}">
                            <img src="{{ $image }}" alt="Gallery" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Main Content -->
    <section class="py-6 lg:py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Content -->
                <div class="lg:col-span-2 space-y-9">
                    <!-- Description -->
                    <div>
                       <h2 class="text-2xl font-bold mb-4 flex items-center">
                            {{ $lang === 'en' ? 'About This Package' : 'Tentang Paket Ini' }}
                        </h2>
                        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
                            @if($lang === 'en')
                                {{ $product->description_en ??  'No description available.' }}
                            @else
                                {{ $product->description ?? 'Deskripsi tidak tersedia.' }}
                            @endif
                        </div>
                    </div>

                    <!-- Facilities -->
                    @if ($product->facilities && count($product->facilities) > 0)
                        <div>
                            <h3 class="text-xl font-bold mb-4 flex items-center">
                                {{ $lang === 'en' ? 'Featured Facilities' : 'Fasilitas Unggulan' }}
                            </h3>
                            <div class="grid grid-cols-2 gap-1">
                                @foreach ($product->facilities as $facility)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-check-circle text-secondary mr-3"></i>
                                        <span class="text-gray-700">{{ $facility }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!--lokasi-->
                    <div>
                        <h2 class="text-xl font-bold mb-4 flex items-center">
                            {{ $lang === 'en' ? 'Location of Kampung Kopi Camp' : 'Lokasi Kampung Kopi Camp' }}
                        </h2>
                        {{-- google maps --}}
                        <div>
                            @if (!empty($googleMaps['embed_url']))
                                <iframe src="{{ $googleMaps['embed_url'] }}" style="border:0;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                    class="w-full h-56 md:h-64 lg:h-80 rounded-lg"></iframe>
                            @endif
                        </div>
                    </div>

                    {{-- kebijakan --}}
                    <div>
                        <h2 class="text-xl font-bold mb-5 flex items-center">
                            {{ $lang === 'en' ? 'Rules & Policies' : 'Peraturan & Kebijakan' }}
                        </h2>
                      
                        <div class="space-y-8">
                            {{-- Prosedur Check-in --}}
                            <div class="w-full flex flex-col lg:flex-row gap-2 lg:gap-8">
                                <h3 class="text-lg font-medium lg:w-[30%]">
                                    {{ $lang === 'en' ? 'Check-in Procedure' : 'Prosedur Check-in' }}
                                </h3>
                                <p class="text-gray-600 lg:w-[70%]">
                                    @if($lang === 'en')
                                        Check-in starts from 14:00 WITA. Guests are required to show an ID Card and booking confirmation. Final payment can be made at the front desk if not yet settled.
                                    @else
                                        Check-in dimulai dari pukul 14:00 WITA. Tamu wajib menunjukkan ID Card dan booking confirmation. Pembayaran pelunasan dapat dilakukan di front desk jika belum lunas.
                                    @endif
                                </p>
                            </div>

                            {{-- Kebijakan Pembatalan --}}
                            <div class="w-full flex flex-col lg:flex-row gap-2 lg:gap-8">
                                <h3 class="text-lg font-medium lg:w-[30%]">
                                    {{ $lang === 'en' ? 'Cancellation Policy' : 'Kebijakan Pembatalan' }}
                                </h3>
                                <p class="text-gray-600 lg:w-[70%]">
                                    @if($lang === 'en')
                                        Cancellations can be made up to 7 days before check-in to receive a 90% refund. Cancellations made less than 7 days prior will incur a 50% cancellation fee.
                                    @else
                                        Pembatalan dapat dilakukan maksimal 7 hari sebelum check-in untuk mendapatkan refund 90%. Pembatalan kurang dari 7 hari akan dikenakan biaya pembatalan 50%.
                                    @endif
                                </p>
                            </div>

                            {{-- Aturan Berkemah --}}
                            <div class="w-full flex flex-col lg:flex-row gap-2 lg:gap-8">
                                <h3 class="text-lg font-medium lg:w-[30%]">
                                    {{ $lang === 'en' ? 'Camping Rules' : 'Aturan Berkemah' }}
                                </h3>
                                <p class="text-gray-600 lg:w-[70%]">
                                    @if($lang === 'en')
                                        Making campfires outside of designated areas is prohibited. Please maintain the cleanliness of the camping area and dispose of trash in the provided bins. Quiet time begins at 22:00 WITA.
                                    @else
                                        Dilarang membuat api unggun di luar area yang telah ditentukan. Harap menjaga kebersihan area camping dan membuang sampah pada tempatnya. Waktu tenang dimulai pukul 22:00 WITA.
                                    @endif
                                </p>
                            </div>
                        </div>
                 
                    </div>

                    {{-- Faq --}}
                    <div>
                       <h2 class="text-xl font-bold mb-4 flex items-center">
                            {{ $lang === 'en' ? 'Frequently Asked Questions' : 'Pertanyaan yang sering ditanyakan' }}
                        </h2>
                        <div class="space-y-3">
                            <div x-data="{ open: false }" class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                                <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-gray-800">
                                        {{ $lang === 'en' ? 'Can I get a refund?' : 'Apakah bisa refund?' }}
                                    </span>
                                    <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="px-4 pb-4">
                                    <p class="text-gray-600">
                                        {{ $lang === 'en' 
                                            ? 'Yes, refunds can be processed at least 7 days before the check-in date with a 10% administrative fee deduction.' 
                                            : 'Ya, refund dapat dilakukan maksimal 7 hari sebelum tanggal check-in dengan potongan biaya administrasi 10%.' 
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div x-data="{ open: false }" class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                                <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-gray-800">
                                        {{ $lang === 'en' ? 'What is the minimum booking?' : 'Berapa minimal booking?' }}
                                    </span>
                                    <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="px-4 pb-4">
                                    <p class="text-gray-600">
                                        {{ $lang === 'en' 
                                            ? 'The minimum booking is 1 day for camping packages and 2 people for touring packages.' 
                                            : 'Minimal booking adalah 1 hari untuk paket camping dan 2 orang untuk paket touring.' 
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div x-data="{ open: false }" class="border border-gray-200 rounded-lg overflow-hidden bg-white">
                                <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                                    <span class="font-semibold text-gray-800">
                                        {{ $lang === 'en' ? 'Is parking available?' : 'Apakah tersedia fasilitas parkir?' }}
                                    </span>
                                    <i class="fas fa-chevron-down transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>
                                <div x-show="open" x-collapse class="px-4 pb-4">
                                    <p class="text-gray-600">
                                        {{ $lang === 'en' 
                                            ? 'Yes, we provide a free parking area for all staying guests.' 
                                            : 'Ya, kami menyediakan area parkir gratis untuk semua tamu yang menginap.' 
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Right Sidebar - Booking Card -->
                <div class="lg:sticky lg:top-6 h-fit hidden lg:block">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="mb-6">
                            <span class="text-gray-600 text-sm">
                                {{ $lang === 'en' ? 'Starting from' : 'Mulai dari' }}
                            </span>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-3xl font-bold text-primary">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <span class="text-gray-500 text-xs">
                                /{{ $lang === 'en' 
                                    ? ($product->duration_type === 'daily' ? 'day' : 'person') 
                                    : ($product->duration_type === 'daily' ? 'hari' : 'orang') }}
                            </span>
                        </div>

                        <a href="{{ Route('booking.flow', $product->slug) }}"
                            class="flex items-center justify-center w-full bg-primary hover:bg-light-primary text-white font-semibold py-4 rounded-xl transition-all duration-200 active:scale-95 shadow-lg shadow-primary/25">
                            <i class="fas fa-calendar-check mr-2"></i>
                            {{ $lang === 'en' ? 'Book Now' : 'Pesan Sekarang' }}
                        </a>

                        <div class="mt-4 pt-4 border-t border-gray-200 space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-accent mr-2"></i>
                                <span>{{ $lang === 'en' ? 'Secure & Trusted Payment' : 'Pembayaran aman & terpercaya' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-undo text-accent mr-2"></i>
                                <span>{{ $lang === 'en' ? 'Free Cancellation' : 'Gratis pembatalan' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Related Packages -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-8">
                {{ $lang === 'en' ? 'Other Packages' : 'Paket Lainnya' }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-20">
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
                 {{ $lang === 'en' ? 'Starting from' : 'Mulai dari' }}
                <div class="flex items-baseline gap-1">
                    <span class="text-2xl font-bold text-primary">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                     <span class="text-gray-500 text-xs">
                                /{{ $lang === 'en' 
                                    ? ($product->duration_type === 'daily' ? 'day' : 'person') 
                                    : ($product->duration_type === 'daily' ? 'hari' : 'orang') }}
                        </span>
                </div>
            </div>
            <a href="{{ Route('booking.flow', $product->slug) }}"
                class="bg-primary hover:bg-light-primary text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 active:scale-95 shadow-lg">
                {{ $lang === 'en' ? 'Book Now' : 'Pesan Sekarang' }}
            </a>
        </div>
    </div>
</div>
