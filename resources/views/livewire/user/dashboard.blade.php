<div class="relative w-full">
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
    {{-- carousel banner --}}
    <div class="swiper mySwiper w-full aspect-[16/9] lg:aspect-[16/6]">
        <div class="swiper-wrapper">
            @if (count($banners) > 0)

                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $banner['image']) }}" alt="Banner"
                            class="w-full h-full object-cover">
                    </div>
                @endforeach
            @else
                {{-- Fallback banners if no banners uploaded --}}
                <div class="swiper-slide bg-blue-400 flex items-center justify-center text-white text-xl font-bold">
                    Selamat Datang di Kampung Kopi Camp
                </div>
                <div class="swiper-slide bg-green-400 flex items-center justify-center text-white text-xl font-bold">
                    Nikmati Pengalaman Wisata Terbaik
                </div>
                <div class="swiper-slide bg-pink-400 flex items-center justify-center text-white text-xl font-bold">
                    Booking Sekarang!
                </div>
            @endif
        </div>

        {{-- Navigation buttons --}}
        @if (count($banners) > 1)
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        @endif
    </div>

    <div x-data="{ open: @entangle('openDisplayProducts'), active: @entangle('activeTab') }" x-cloak>
        <div x-show="open" x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in duration-300" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed top-0 right-0 h-full w-full lg:max-w-4xl lg:mr-32 bg-gray-100 shadow-2xl z-50 overflow-y-auto"
            @keydown.escape.window="open = false" style="display: none;">
            <div
                class="flex justify-between items-center border-b border-gray-300 py-4 px-4 bg-white sticky top-0 z-40">
                <button @click="open = false" class="p-2">
                    <i class="fa fa-angle-left text-lg"></i>
                </button>
                <h3 class="font-semibold text-lg lg:text-xl">All Packages</h3>
                <div class="w-6"></div>
            </div>

            <div class="p-4 space-y-4">
                {{-- category tabs --}}
                <div class="flex gap-2 overflow-x-auto pb-2">

                    <button @click="active = 'accommodation'"
                        :class="active === 'accommodation' ? 'bg-white text-primary shadow' : 'bg-transparent text-gray-700'"
                        class="whitespace-nowrap px-4 py-2 rounded-lg border border-gray-200">
                        Accommodation
                    </button>
                    <button @click="active = 'touring'"
                        :class="active === 'touring' ? 'bg-white text-primary shadow' : 'bg-transparent text-gray-700'"
                        class="whitespace-nowrap px-4 py-2 rounded-lg border border-gray-200">
                        Touring
                    </button>

                    <button @click="active = 'area'"
                        :class="active === 'area' ? 'bg-white text-primary shadow' : 'bg-transparent text-gray-700'"
                        class="whitespace-nowrap px-4 py-2 rounded-lg border border-gray-200">
                        Area
                    </button>
                </div>

                {{-- responsive grid for cards --}}
                <template x-if="active === 'touring'">
                    <div x-transition class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($touringProducts as $product)
                            {{-- card --}}
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow">
                                @if (!empty($product->images) && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        alt="{{ $product->name }}" class="aspect-[5/3] w-full object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] w-full"></div>
                                @endif
                                <div class="p-3">
                                    <h4 class="font-semibold truncate text-lg lg:text-xl">{{ $product->name }}
                                    </h4>
                                    <p class="text-xs text-gray-600 flex items-center gap-2">
                                        <span><i class="fa-regular fa-user"></i>
                                            @if ($product->type == 'touring')
                                                {{ $product->max_participant ?? 1 }}
                                            @else
                                                {{ $product->capacity_per_unit ?? 1 }}
                                            @endif
                                        </span> |
                                        <span>Daily</span>
                                    </p>
                                    <div class="mt-3 flex items-center justify-end">
                                        <p class="font-bold text-lg text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>

                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </template>

                <template x-if="active === 'accommodation'">
                    <div x-transition class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($accommodationProducts as $product)
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow">
                                @if (!empty($product->images) && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="aspect-[5/3] w-full object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] w-full"></div>
                                @endif
                                <div class="p-3">
                                    <h4 class="font-semibold text-lg lg:text-xl truncate">{{ $product->name }}</h4>
                                    <p class="text-xs text-gray-600">Kapasitas:
                                        {{ $product->capacity_per_unit ?? 1 }}
                                        orang</p>
                                    <div class="mt-3 flex items-center justify-end">
                                        <p class="font-bold text-lg text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>

                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </template>

                <template x-if="active === 'area'">
                    <div x-transition class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($areaProducts as $product)
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow">
                                @if (!empty($product->images) && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="aspect-[5/3] w-full object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] w-full"></div>
                                @endif
                                <div class="p-3">
                                    <h4 class="font-semibold text-sm truncate">{{ $product->name }}</h4>
                                    <p class="text-xs mt-1 text-gray-600">{{ ucfirst($product->type) }}</p>
                                    <div class="mt-3 flex items-center justify-between">
                                        <p class="font-semibold text-primary">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <button type="button"
                                            class="px-3 py-1 bg-light-primary text-white rounded-md text-xs">Book</button>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </template>
            </div>
        </div>

    </div>

    {{-- content overlapping --}}
    <div class="relative z-20 -mt-4">
        <div class="px-4 py-8 space-y-10 bg-white backdrop-blur-sm rounded-xl shadow-lg min-h-screen pb-24">

            {{-- section free voucher (show max 2 day after account create) --}}
            @if ($showWelcomeSection && $welcomeVoucher)
                <div>
                    <h3 class="font-bold mb-4">Hadiah Spesial Buat Pengguna Baru!</h3>
                    <div
                        class="w-full bg-gradient-to-b from-light-primary/30 to-light-primary/5 rounded-xl py-3 px-4 shadow-md border border-gray-200">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4 border-b border-gray-300 pb-4">
                                <div
                                    class="w-[10%] size-7 bg-light-primary rounded-lg flex items-center justify-center">
                                    <i class="fas fa-gift text-white text-sm"></i>
                                </div>
                                <div class="w-[90%]">
                                    <h4 class="font-semibold">{{ $welcomeVoucher->name }}</h4>
                                    <p class="text-xs text-gray-700">{{ $welcomeVoucher->description }}</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center w-full md:w-auto gap-4">
                                <div>
                                    {{-- progress bar --}}
                                    @php
                                        $currentRedemptions = \App\Models\VoucherRedemption::where(
                                            'voucher_id',
                                            $welcomeVoucher->id,
                                        )->count();
                                        $percentage = ($currentRedemptions / $welcomeVoucher->usage_limit) * 100;
                                    @endphp
                                    <div class="w-48 bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-light-primary h-2 rounded-full"
                                            style="width: {{ $percentage }}%;"></div>
                                    </div>
                                    <span
                                        class="text-xs text-gray-700">{{ $welcomeVoucher->usage_limit - $currentRedemptions }}
                                        voucher tersisa</span>
                                </div>
                                <button wire:click="claimVoucher"
                                    class="px-2.5 py-2 bg-light-primary rounded-lg text-white hover:bg-light-primary/80 transition">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            {{-- section type product (just show when mobile display) --}}
            <div class="lg:hidden " x-data="{ open: false }" x-cloak>
                <h3 class="font-bold mb-4 text-lg lg:text-xl text-dark-primary">Healingnya Mau Ngapain?</h3>
                <div class="flex w-full justify-around">
                    <button wire:click="toggleDisplayProducts('accommodation')"
                        class="flex flex-col justify-center items-center gap-1">
                        <div class="bg-secondary size-12 rounded-full flex justify-center items-center">
                            <i class="fas fa-campground text-white text-xl"></i>
                        </div>
                        <p class="text-sm">Camping</p>
                    </button>
                    <button wire:click="toggleDisplayProducts('touring')"
                        class="flex flex-col justify-center items-center gap-1">
                        <div class="bg-secondary size-12 rounded-full flex justify-center items-center">
                            <i class="fas fa-person-hiking text-white text-xl"></i>
                        </div>
                        <p class="text-sm">Touring</p>
                    </button>
                    <button wire:click="toggleDisplayProducts('area')"
                        class="flex flex-col justify-center items-center gap-1">
                        <div class="bg-secondary size-12 rounded-full flex justify-center items-center">
                            <i class="fas fa-tree text-white text-xl"></i>
                        </div>
                        <p class="text-sm">Rekreasi</p>
                    </button>
                </div>

                {{-- all package --}}
                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="absolute top-0 right-0 h-full w-full lg:max-w-4xl lg:mr-32  bg-gray-200 shadow-2xl z-50 overflow-y-auto ">

                    {{-- header detail booking --}}
                    <div
                        class="flex justify-between items-center border-b border-gray-300 pb-4 mb-4 py-5 px-4 bg-white ">
                        <button @click="open = false">
                            <i class="fa fa-angle-left text-lg"></i>
                        </button>
                        <h3 class="font-semibold text-lg lg:text-xl">Detail Booking</h3>
                        <div class="text-white">
                            <i class="fa fa-angle-left text-lg"></i>
                        </div>
                    </div>

                    {{-- content detail booking --}}
                    <div class="space-y-4 ">

                    </div>

                </div>

            </div>

            {{-- section highlight paket --}}
            <div class="w-full lg:hidden">
                <h3 class="font-bold mb-4 text-lg lg:text-xl">Udah Waktunya Liburan Nih</h3>
                <div class="w-full overflow-x-scroll snap-x">
                    <div class="flex gap-3 w-max">
                        @forelse($popularProducts as $product)
                            {{-- card --}}
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="snap-start rounded-lg overflow-hidden border border-gray-200 shadow-md w-max">
                                @if (!empty($product->images) && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="aspect-[5/3] h-32 object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] h-32"></div>
                                @endif
                                <div class="px-2.5 py-2.5">
                                    <p class="truncate w-40">{{ $product->name }}</p>
                                    <p class="text-xs mt-1 text-gray-600 flex items-center gap-2">
                                        <span>Kapasitas:
                                            @if ($product->type === 'touring')
                                                {{ $product->max_participant ?? 1 }} orang
                                            @else
                                                {{ $product->capacity_per_unit ?? 1 }} orang
                                            @endif
                                        </span>
                                    </p>
                                    <p class="font-bold text-primary pt-4">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada produk tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- section type accommodation paket (camping) --}}
            <div class="w-full hidden lg:block">
                <h3 class="font-bold mb-4 text-lg lg:text-xl">Camping di Alam Terbuka</h3>
                <div class="w-full overflow-x-scroll snap-x">
                    <div class="flex gap-3 w-max">
                        @forelse($accommodationProducts as $product)
                            {{-- card --}}
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="snap-start rounded-lg overflow-hidden border border-gray-200 shadow-md w-max">
                                @if (!empty($product->images) && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="aspect-[5/3] h-32 object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] h-32"></div>
                                @endif
                                <div class="px-2.5 py-2.5">
                                    <p class="truncate w-40">{{ $product->name }}</p>
                                    <p class="text-xs mt-1 text-gray-600">Kapasitas: {{ $product->capacity ?? 1 }}
                                        orang</p>
                                    <p class="font-semibold text-primary pt-4">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada paket camping tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- section type touring paket (tour) --}}
            <div class="w-full hidden lg:block">
                <h3 class="font-bold mb-4 text-lg lg:text-xl">Petualangan Seru Menanti</h3>
                <div class="w-full overflow-x-scroll snap-x">
                    <div class="flex gap-3 w-max">
                        @forelse($touringProducts as $product)
                            {{-- card --}}
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="snap-start rounded-lg overflow-hidden border border-gray-200 shadow-md w-max">
                                @if (!empty($product->images) && isset($product->images[0]))
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                        class="aspect-[5/3] h-32 object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] h-32"></div>
                                @endif
                                <div class="px-2.5 py-2.5">
                                    <p class="truncate w-40">{{ $product->name }}</p>
                                    <p class="text-xs mt-1 text-gray-600 flex items-center gap-2">
                                        <span><i class="fa-regular fa-user"></i> {{ $product->capacity ?? 1 }}</span>
                                        | <span>Daily</span>
                                    </p>
                                    <p class="font-semibold text-primary pt-4">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada paket touring tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- section type rekreasi paket (area) --}}
            <div class="w-full hidden lg:block">
                <h3 class="font-bold mb-4 text-lg lg:text-xl">Area Rekreasi Spesial</h3>
                <div class="w-full overflow-x-scroll snap-x">
                    <div class="flex gap-3 w-max">
                        @forelse($areaProducts as $product)
                            {{-- card --}}
                            <a href="{{ route('package.detail', $product->slug) }}"
                                class="snap-start rounded-lg overflow-hidden border border-gray-200 shadow-md w-max">

                                @if ($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                        alt="{{ $product->name }}" class="aspect-[5/3] h-32 object-cover">
                                @else
                                    <div class="bg-gray-300 aspect-[5/3] h-32"></div>
                                @endif

                                <div class="px-2.5 py-2.5">
                                    <p class="truncate w-40">{{ $product->name }}</p>
                                    <p class="text-xs mt-1 text-gray-600">{{ ucfirst($product->type) }}</p>
                                    <p class="font-semibold text-primary pt-4">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada area rekreasi tersedia</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- section history latest booking --}}
            <div>
                <h3 class="font-bold mb-4 text-lg lg:text-xl">Yuk, Liburan Lagi!</h3>
                <div class="space-y-3">
                    @forelse($latestBookings as $booking)
                        @php
                            // Get main product item
                            $productItem = $booking->items->where('item_type', 'product')->first();
                            $product = $productItem?->product;
                        @endphp

                        {{-- card history latest booking (max 3) --}}
                        <a href="{{ route('user.bookings') }}"
                            class="w-full rounded-lg py-4 px-5 flex gap-2 shadow-md border border-gray-200 hover:shadow-lg transition">
                            @if (!empty($product->images) && isset($product->images[0]))
                                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                    class="w-14 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-14 h-12 bg-gray-300 rounded-lg"></div>
                            @endif
                            <div class="flex flex-col w-full">
                                <p class="font-semibold">
                                    {{ $product ? $product->name : 'Produk tidak tersedia' }}</p>
                                <div class="flex justify-between w-full">
                                    <p class="text-xs text-gray-600">
                                        {{ \Carbon\Carbon::parse($booking->checkin_date)->format('d M Y') }}</p>
                                    <p class="font-semibold text-primary">Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div
                            class="w-full rounded-lg py-8 px-5 flex flex-col items-center justify-center gap-2 border border-gray-200">
                            <i class="fas fa-calendar-check text-gray-300 text-4xl"></i>
                            <p class="text-gray-500 text-sm">Belum ada riwayat booking</p>
                            <p class="text-gray-400 text-xs">Yuk mulai petualanganmu!</p>
                        </div>
                    @endforelse

                </div>
            </div>


        </div>
    </div>
</div>

</div>
