<div class="min-h-screen bg-white">
    <!-- Hero Section Paket Wisata -->
    <section class="relative w-full h-[60vh] flex items-center justify-center text-center text-white overflow-hidden"
        data-aos="fade-zoom-in" data-aos-duration="1200" data-aos-easing="ease-in-out" data-aos-once="true">

        <!-- Background -->
        <img src="/images/headerpaketwisata.webp" alt="Paket Wisata Background"
            class="absolute inset-0 w-full h-full object-cover" data-aos="zoom-out" data-aos-duration="1000">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Content -->
        <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
            <p class="text-white mb-3 uppercase tracking-wide" data-aos="fade-down" data-aos-delay="400">
                {!! $texts['subheading'] !!}
            </p>

            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-6" data-aos="fade-up" data-aos-delay="600">
                {!! $texts['title'] !!}
            </h1>


            <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

            <p id="paket-wisata" class="text-sm md:text-lg max-w-2xl mx-auto leading-relaxed text-gray-100"
                data-aos="fade-up" data-aos-delay="1000">
                {!! $texts['description'] !!}
            </p>
        </div>

    </section>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-14 py-12 space-y-16">
        {{-- Accommodation Section (Camping) --}}
        <section class="w-full">
            @if (count($accommodationProducts) > 0)
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-primary flex items-center gap-3">
                            Camping & Penginapan
                        </h2>
                        <p class="text-gray-600 mt-2">Nikmati pengalaman camping di alam terbuka</p>
                    </div>
                    <div class="text-primary font-semibold">
                        {{ count($accommodationProducts) }} Paket
                    </div>
                </div>
                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true">
                    @foreach ($accommodationProducts as $product)
                        <swiper-slide
                            class="group rounded-lg bg-white shadow-lg overflow-hidden border border-gray-100">
                            <a href="{{ route('package.detail', $product->slug) }}">
                                <div class="bg-gray-100 aspect-[4/3] overflow-hidden">
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" alt=""
                                        class=" w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 ">
                                </div>
                                <div class="h-auto p-4 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                        <div class="flex gap-2 text-xs">
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-users"></i>
                                                {{ $product->capacity_per_unit ?? 1 }} orang
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-clock"></i>
                                                {{ $product->duration_type === 'daily' ? 'Per Hari' : 'Per Orang' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start mb-2 mt-7">
                                        <p class="text-sm">Mulai dari</p>
                                        <p class="text-primary text-xl font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex ">
                                        <a href="{{ Route('booking.flow', $product->slug) }}"
                                            class="flex-1 text-center py-2.5 bg-primary hover:bg-secondary text-white text-sm font-semibold rounded-lg transition-all duration-300 hover:shadow-lg mr-2">
                                            <i class="fa-solid fa-calendar-check mr-1"></i>
                                            {{ $texts['tombol_booking'] }}
                                        </a>

                                        <a href="{{ route('package.detail', $product->slug) }}"
                                            class="flex-shrink-0 px-4 py-2.5 bg-white border border-primary text-primary text-sm font-semibold rounded-lg hover:bg-primary hover:text-white transition-all duration-300">
                                            <i class="fa-solid fa-circle-info text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            @endif
        </section>

        {{-- Touring Section --}}
        <section class="w-full">
            @if (count($touringProducts) > 0)
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-primary flex items-center gap-3">

                            Paket Touring
                        </h2>
                        <p class="text-gray-600 mt-2">Jelajahi keindahan alam dengan paket touring pilihan</p>
                    </div>
                    <div class="text-primary font-semibold">
                        {{ count($touringProducts) }} Paket
                    </div>
                </div>
                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="30"
                    slides-per-view="3">
                    @foreach ($touringProducts as $product)
                        <swiper-slide
                            class="group rounded-lg bg-white shadow-lg overflow-hidden border border-gray-100">
                            <a href="{{ route('package.detail', $product->slug) }}">
                                <div class="bg-gray-100 aspect-[4/3] overflow-hidden">
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" alt=""
                                        class=" w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 ">
                                </div>
                                <div class="h-auto p-4 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                        <div class="flex gap-2 text-xs">
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-users"></i>
                                                {{ $product->capacity_per_unit ?? 1 }} orang
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-clock"></i>
                                                per sesi
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start mb-2 mt-7">
                                        <p class="text-sm">Mulai dari</p>
                                        <p class="text-primary text-xl font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex">
                                        <a href="{{ Route('booking.flow', $product->slug) }}"
                                            class="flex-1 text-center py-2.5 bg-primary hover:bg-secondary text-white text-sm font-semibold rounded-lg transition-all duration-300 hover:shadow-lg mr-2">
                                            <i class="fa-solid fa-calendar-check mr-1"></i>
                                            {{ $texts['tombol_booking'] }}
                                        </a>

                                        <a href="{{ route('package.detail', $product->slug) }}"
                                            class="flex-shrink-0 px-4 py-2.5 bg-white border border-primary text-primary text-sm font-semibold rounded-lg hover:bg-primary hover:text-white transition-all duration-300">
                                            <i class="fa-solid fa-circle-info text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            @endif
        </section>

        {{-- Touring Section --}}
        <section class="w-full">
            @if (count($areaProducts) > 0)
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-3xl font-bold text-primary flex items-center gap-3">
                            Area Rekreasi
                        </h2>
                        <p class="text-gray-600 mt-2">Fasilitas dan area rekreasi spesial untuk liburan Anda</p>
                    </div>
                    <div class="text-primary font-semibold">
                        {{ count($areaProducts) }} Paket
                    </div>
                </div>
                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="30"
                    slides-per-view="3">
                    @foreach ($areaProducts as $product)
                        <swiper-slide
                            class="group rounded-lg bg-white shadow-lg overflow-hidden border border-gray-100">
                            <a href="{{ route('package.detail', $product->slug) }}">
                                <div class="bg-gray-100 aspect-[4/3] overflow-hidden">
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" alt=""
                                        class=" w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 ">
                                </div>
                                <div class="h-auto p-4 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                        <div class="flex gap-2 text-xs">
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-users"></i>
                                                {{ $product->capacity_per_unit ?? 1 }} orang
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-clock"></i>
                                                per sesi
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start mb-2 mt-7">
                                        <p class="text-sm">Mulai dari</p>
                                        <p class="text-primary text-xl font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex">
                                        <a href="{{ Route('booking.flow', $product->slug) }}"
                                            class="flex-1 text-center py-2.5 bg-primary hover:bg-secondary text-white text-sm font-semibold rounded-lg transition-all duration-300 hover:shadow-lg mr-2">
                                            <i class="fa-solid fa-calendar-check mr-1"></i>
                                            {{ $texts['tombol_booking'] }}
                                        </a>

                                        <a href="{{ route('package.detail', $product->slug) }}"
                                            class="flex-shrink-0 px-4 py-2.5 bg-white border border-primary text-primary text-sm font-semibold rounded-lg hover:bg-primary hover:text-white transition-all duration-300">
                                            <i class="fa-solid fa-circle-info text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </a>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            @endif
        </section>



        {{-- Area Recreation Section --}}


    </div>
</div>

<script>
    const swiperEls = document.querySelectorAll('swiper-container');

    const swiperEl = new Proxy({}, {
        set(target, prop, value) {
            swiperEls.forEach(el => {
                try {
                    el[prop] = value
                } catch (e) {
                    /* ignore */
                }
            });
            target[prop] = value;
            return true;
        },
        get(target, prop) {
            if (prop === 'initialize') {
                return () => swiperEls.forEach(el => {
                    if (typeof el.initialize === 'function') el.initialize();
                });
            }
            return target[prop];
        }
    });
    Object.assign(swiperEl, {
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
        },
    });
    swiperEl.initialize();
</script>
