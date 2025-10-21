<div class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class="relative w-full min-h-screen overflow-hidden">
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="videos/header.mp4" type="video/mp4">
            Browser tidak mendukung video.
        </video>

        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/50"></div>

        <!-- Hero Content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8 pt-20 pb-16">
            <div class="max-w-4xl mx-auto text-center text-white space-y-6 sm:space-y-8">

                <!-- Badge -->
                <span
                    class="inline-block bg-accent/90 backdrop-blur-sm text-white text-xs sm:text-sm font-semibold px-4 sm:px-6 py-2 rounded-full shadow-lg"
                    data-aos="fade-down" data-aos-delay="200">
                    {{ $texts['badge'] }}
                </span>

                <!-- Headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight" data-aos="fade-up"
                    data-aos-delay="400">
                    {{ $texts['headline_part1'] }} <br class="hidden sm:inline">
                    <span class="text-light-primary">{{ $texts['headline_part2'] }}</span>
                </h1>

                <!-- Subheadline -->
                <p class="text-base sm:text-lg md:text-xl text-gray-100 max-w-2xl mx-auto px-4" data-aos="fade-up"
                    data-aos-delay="600">
                    {{ $texts['subheadline'] }}
                </p>

                <!-- Stats -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 text-sm sm:text-base"
                    data-aos="zoom-in" data-aos-delay="800">
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full">
                        <i class="fa-solid fa-users text-light-primary"></i>
                        <span><strong>{{ $texts['happy_travelers'] }}</strong> Happy Travelers</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full">
                        <i class="fa-solid fa-location-dot text-light-primary"></i>
                        <span><strong>{{ $texts['location'] }}</strong> Premium Location</span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4" data-aos="fade-up"
                    data-aos-delay="1000">
                    <a href="#paket"
                        class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-primary hover:bg-light-primary text-white font-semibold rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
                        <i class="fa-solid fa-compass mr-2"></i>{{ $texts['cta_packages'] }}
                    </a>
                    <a href="#contact"
                        class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-white/20 backdrop-blur-md border-2 border-white/50 text-white font-semibold rounded-lg hover:bg-white/30 transition-all duration-300">
                        <i class="fa-solid fa-calendar-check mr-2"></i>{{ $texts['cta_booking'] }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce" data-aos="fade-up"
            data-aos-delay="1200">
            <i class="fa-solid fa-chevron-down text-white text-2xl opacity-70"></i>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="relative py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-white to-neutral">
        <div class="container max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">

                <!-- Text Content -->
                <div class="flex-1 w-full" data-aos="fade-right">
                    <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-3"
                        data-aos="fade-down" data-aos-delay="100">
                        {{ $texts['about_badge'] }}
                    </p>

                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark leading-tight mb-4 sm:mb-6"
                        data-aos="fade-up" data-aos-delay="200">
                        {{ $texts['about_title_part1'] }}
                        <span class="text-primary">{{ $texts['about_title_part2'] }}</span>
                    </h2>

                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-4" data-aos="fade-up"
                        data-aos-delay="300">
                        {{ $texts['about_desc1'] }}
                    </p>

                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed mb-6 sm:mb-8" data-aos="fade-up"
                        data-aos-delay="400">
                        {{ $texts['about_desc2'] }}
                    </p>

                    <!-- Features Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8" data-aos="zoom-in"
                        data-aos-delay="500">
                        <div
                            class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div
                                class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-primary/10">
                                <i class="fa-solid fa-mug-hot text-primary text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-dark text-sm sm:text-base mb-1">
                                    {{ $texts['feature_coffee_title'] }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    {{ $texts['feature_coffee_desc'] }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-3 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                            <div
                                class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-full bg-success/10">
                                <i class="fa-solid fa-leaf text-success text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-dark text-sm sm:text-base mb-1">
                                    {{ $texts['feature_nature_title'] }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    {{ $texts['feature_nature_desc'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <a href="#paket"
                        class="inline-block w-full sm:w-auto px-6 sm:px-8 py-3 bg-primary hover:bg-light-primary text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                        <i class="fa-solid fa-arrow-right mr-2"></i>{{ $texts['learn_more'] }}
                    </a>
                </div>

                <!-- Image Content -->
                <div class="flex-1 w-full relative" data-aos="fade-left" data-aos-delay="400">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="images/about.jpeg" alt="Kopi Bali" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                    </div>

                    <!-- Floating Badges -->
                    <div class="absolute -top-4 -right-4 sm:top-4 sm:right-4 bg-white shadow-lg rounded-xl px-4 py-3 text-center transform hover:scale-105 transition-transform"
                        data-aos="zoom-in" data-aos-delay="600">
                        <span class="block text-3xl mb-1">☕</span>
                        <p class="font-bold text-lg text-primary">100%</p>
                        <p class="text-xs text-gray-600">{{ $texts['organic'] }}</p>
                    </div>

                    <div class="absolute -bottom-4 -left-4 sm:bottom-4 sm:left-4 bg-white shadow-lg rounded-xl px-4 py-3 text-center transform hover:scale-105 transition-transform"
                        data-aos="zoom-in" data-aos-delay="700">
                        <span class="block text-3xl mb-1">🌟</span>
                        <p class="font-bold text-lg text-success">24/7</p>
                        <p class="text-xs text-gray-600">{{ $texts['support'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Paket Wisata Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white" id="paket">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-10 sm:mb-12" data-aos="fade-down">
                <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-2">
                    {{ $texts['paket_heading'] }}
                </p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark mb-3">
                    {{ $texts['paket_heading'] }}
                </h2>
                <p class="text-sm sm:text-base lg:text-lg text-gray-600 max-w-2xl mx-auto" data-aos="fade-up"
                    data-aos-delay="100">
                    {{ $texts['paket_description'] }}
                </p>
            </div>

            <!-- Paket Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($pakets as $index => $paket)
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3) }}">

                        <!-- Image Container -->
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <img src="{{ asset('storage/' . $paket->main_image) }}"
                                alt="{{ is_array($paket->title) ? $paket->title[$lang] ?? '' : $paket->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                            <!-- Overlay Badge -->
                            <div
                                class="absolute top-3 right-3 bg-primary/90 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ optional($paket->category)->name[$lang] ?? 'Tour' }}
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4 sm:p-5">
                            <!-- Title -->
                            <h3 class="font-bold text-dark text-xl mb-3 line-clamp-2 min-h-[3rem]">
                                {{ is_array($paket->name) ? $paket->name[$lang] ?? '' : $paket->name }}
                            </h3>

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-clock"></i> {{ $paket->duration_type }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-users"></i> Max {{ $paket->capacity_per_unit }}
                                </span>
                            </div>

                            <!-- Facilities -->
                            @php
                                $facilities = is_array($paket->facilities) ? $paket->facilities[$lang] ?? [] : [];
                                $limit = 2;
                                $countOthers = count($facilities) - $limit;
                            @endphp

                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach (array_slice($facilities, 0, $limit) as $item)
                                    <span class="px-2 sm:px-3 py-1 bg-neutral text-xs rounded-full text-gray-700">
                                        {{ $item }}
                                    </span>
                                @endforeach

                                @if ($countOthers > 0)
                                    <span
                                        class="px-2 sm:px-3 py-1 bg-accent/10 text-accent text-xs rounded-full font-semibold">
                                        +{{ $countOthers }} {{ $texts['facilities'] }}
                                    </span>
                                @endif
                            </div>

                            <!-- Price -->
                            <div class="flex items-baseline gap-1 mb-4">
                                <span class="text-xl sm:text-2xl font-bold text-primary">
                                    Rp {{ number_format($paket->price, 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-gray-500">/paket</span>
                            </div>

                            <!-- CTA Buttons -->
                            <div class="flex gap-2">
                                <a href="#"
                                    class="flex-1 text-center px-3 py-2.5 bg-primary hover:bg-light-primary text-white text-sm font-semibold rounded-lg transition-all duration-300 hover:shadow-lg">
                                    <i class="fa-solid fa-calendar-check mr-1"></i>
                                    {{ $texts['tombol_booking'] }}
                                </a>

                                <a href="{{ route('package.detail', $paket->slug) }}"
                                    class="flex-shrink-0 px-4 py-2.5 bg-white border border-primary text-primary text-sm font-semibold rounded-lg hover:bg-primary hover:text-white transition-all duration-300">
                                    <i class="fa-solid fa-circle-info text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- View All Button -->
            @if ($pakets->count() >= 6)
                <div class="text-center mt-10" data-aos="fade-up">
                    <a href="{{ route('paketwisata') }}"
                        class="inline-block px-6 sm:px-8 py-3 bg-white border-2 border-primary text-primary font-semibold rounded-lg hover:bg-primary hover:text-white transition-all duration-300">
                        Lihat Semua Paket <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>


    <!-- Explore Pupuan Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-white to-neutral">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">

                <!-- Photo Grid -->
                <div class="order-2 lg:order-1 relative" data-aos="zoom-in">
                    <div class="grid grid-cols-2 gap-3 rounded-2xl overflow-hidden">
                        <img src="https://picsum.photos/400/400?random=1"
                            class="w-full h-40 sm:h-56 object-cover rounded-xl shadow-lg hover:scale-105 transition-transform duration-300"
                            alt="Pupuan View">
                        <img src="https://picsum.photos/400/400?random=2"
                            class="w-full h-40 sm:h-56 object-cover rounded-xl shadow-lg hover:scale-105 transition-transform duration-300"
                            alt="Coffee Plantation">
                        <img src="https://picsum.photos/400/400?random=3"
                            class="w-full h-40 sm:h-56 object-cover rounded-xl shadow-lg hover:scale-105 transition-transform duration-300"
                            alt="Camping">
                        <img src="https://picsum.photos/400/400?random=4"
                            class="w-full h-40 sm:h-56 object-cover rounded-xl shadow-lg hover:scale-105 transition-transform duration-300"
                            alt="Waterfall">
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -bottom-4 left-4 sm:bottom-4 sm:left-4 bg-white shadow-xl rounded-xl p-4 transform hover:scale-105 transition-transform"
                        data-aos="fade-up" data-aos-delay="300">
                        <p class="text-xs text-gray-500 flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-camera text-accent"></i>
                            {{ __('messages.photo_spots') }}
                        </p>
                        <p class="font-bold text-lg text-dark">{{ __('messages.photo_count') }}</p>
                        <p class="text-xs text-gray-500">{{ __('messages.photo_caption') }}</p>
                    </div>
                </div>

                <!-- Content -->
                <div class="order-1 lg:order-2" data-aos="fade-left">
                    <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-2">
                        {{ __('messages.explore_title') }}
                    </p>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark leading-tight mb-4">
                        {{ __('messages.explore_heading') }}
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8">
                        {{ __('messages.explore_description') }}
                    </p>

                    <!-- Destinations -->
                    <div class="space-y-3 mb-8">
                        @foreach ([['icon' => 'fa-water', 'title' => 'dest_air_terjun', 'time' => 'dest_air_terjun_time', 'desc' => 'dest_air_terjun_desc'], ['icon' => 'fa-mountain-sun', 'title' => 'dest_jatiluwih', 'time' => 'dest_jatiluwih_time', 'desc' => 'dest_jatiluwih_desc'], ['icon' => 'fa-tree', 'title' => 'dest_kopi', 'time' => 'dest_kopi_time', 'desc' => 'dest_kopi_desc'], ['icon' => 'fa-house-chimney-user', 'title' => 'dest_desa', 'time' => 'dest_desa_time', 'desc' => 'dest_desa_desc']] as $dest)
                            <div class="flex items-start gap-3 p-3 sm:p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-all"
                                data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div
                                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary/10">
                                    <i class="fa-solid {{ $dest['icon'] }} text-primary text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <h4 class="font-semibold text-dark text-sm sm:text-base">
                                            {{ __('messages.' . $dest['title']) }}
                                        </h4>
                                        <span
                                            class="text-xs text-gray-500 bg-neutral px-2 py-0.5 rounded-full whitespace-nowrap">
                                            {{ __('messages.' . $dest['time']) }}
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                        {{ __('messages.' . $dest['desc']) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap gap-6 sm:gap-8" data-aos="zoom-in" data-aos-delay="200">
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-primary">25+</h3>
                            <p class="text-xs sm:text-sm text-gray-600">{{ __('messages.stat_destinasi') }}</p>
                        </div>
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-primary">4.9</h3>
                            <p class="text-xs sm:text-sm text-gray-600">{{ __('messages.stat_rating') }}</p>
                        </div>
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-primary">100%</h3>
                            <p class="text-xs sm:text-sm text-gray-600">{{ __('messages.stat_experience') }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- CTA Parallax Section -->
    <section class="relative h-[60vh] sm:h-[70vh] overflow-hidden">
        <!-- Background Image with Parallax Effect -->
        <div class="absolute inset-0">
            <img src="images/about.jpeg" alt="{{ $texts['heading'] }}" class="w-full h-full object-cover scale-110"
                data-aos="zoom-out" data-aos-duration="2000">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/60"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex items-center justify-center h-full px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center text-white space-y-6">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold leading-tight" data-aos="fade-up"
                    data-aos-duration="1000">
                    {{ $texts['heading'] }}
                </h2>

                <p class="text-sm sm:text-base md:text-lg lg:text-xl opacity-90 max-w-2xl mx-auto px-4"
                    data-aos="fade-up" data-aos-delay="300">
                    {{ $texts['description'] }}
                </p>

                <div class="pt-4" data-aos="zoom-in" data-aos-delay="600">
                    <a href="#contact"
                        class="inline-block bg-primary hover:bg-light-primary text-white text-base sm:text-lg font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-xl shadow-2xl hover:shadow-primary/50 transition-all duration-300 transform hover:scale-105">
                        <i class="fa-solid fa-calendar-check mr-2"></i> {{ $texts['cta_text'] }}
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- Gallery Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-neutral" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-12" data-aos="fade-down">
                <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-2">
                    Gallery
                </p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark mb-3">
                    {{ $texts['gallery_heading'] }}
                </h2>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                    {{ $texts['gallery_description'] }}
                </p>
            </div>

            <!-- Mobile Gallery: Simple Grid -->
            <div class="grid grid-cols-2 gap-3 sm:hidden" data-aos="zoom-in">
                @for ($i = 5; $i <= 10; $i++)
                    <div class="relative aspect-square overflow-hidden rounded-xl shadow-md">
                        <img src="https://picsum.photos/400/400?random={{ $i }}"
                            alt="Gallery {{ $i }}"
                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                @endfor
            </div>

            <!-- Desktop Gallery: Masonry Layout -->
            <div class="hidden sm:grid sm:grid-cols-3 gap-3 lg:gap-4" data-aos="zoom-in" data-aos-delay="200">
                <!-- Large Featured Image -->
                <div class="col-span-2 row-span-2 relative overflow-hidden rounded-2xl shadow-xl group">
                    <img src="https://picsum.photos/800/800?random=9" alt="Suasana Camp"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="font-bold text-xl mb-1">Camping Experience</h3>
                            <p class="text-sm opacity-90">Pupuan, Tabanan</p>
                        </div>
                    </div>
                </div>

                <!-- Side Images -->
                @foreach ([5, 6, 7, 8] as $index)
                    <div class="relative aspect-square overflow-hidden rounded-xl shadow-lg group">
                        <img src="https://picsum.photos/400/400?random={{ $index }}"
                            alt="Gallery {{ $index }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div
                            class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View More Button -->
            <div class="text-center mt-8 sm:mt-12" data-aos="fade-up" data-aos-delay="400">
                <a href="#gallery"
                    class="inline-block px-6 sm:px-8 py-3 bg-white border-2 border-primary text-primary font-semibold rounded-lg hover:bg-primary hover:text-white transition-all duration-300 shadow-md hover:shadow-xl">
                    <i class="fa-solid fa-images mr-2"></i>Lihat Semua Foto
                </a>
            </div>
        </div>
    </section>



    {{-- Article Section --}}
    @php
        $lang = app()->getLocale() ?? 'id';
    @endphp

    <section class="py-12 sm:py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-12" data-aos="fade-up">
                <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-2">
                    Blog & Article
                </p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark mb-3">
                    {{ $texts['article_heading'] }}
                </h2>
                <p class="text-sm sm:text-base lg:text-lg text-gray-600 max-w-2xl mx-auto" data-aos="fade-up"
                    data-aos-delay="100">
                    {{ $texts['article_description'] }}
                </p>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($blogs as $index => $blog)
                    <article
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <!-- Image -->
                        <a href="{{ route('article.detail', ['slug' => Str::slug($blog->title[$lang] ?? '')]) }}"
                            class="block relative overflow-hidden aspect-[4/3]">
                            <img src="{{ $blog->main_image ? asset('storage/' . $blog->main_image) : 'https://picsum.photos/400/300?random=' . ($index + 1) }}"
                                alt="{{ $blog->title[$lang] ?? '' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                            <!-- Category Badge -->
                            <div
                                class="absolute top-3 left-3 bg-primary/90 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $texts['article_type'] ?? 'Travel' }}
                            </div>
                        </a>

                        <!-- Content -->
                        <div class="p-4 sm:p-5">
                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-3">
                                <time datetime="{{ $blog->created_at->format('Y-m-d') }}">
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    {{ $blog->created_at->format('d M Y') }}
                                </time>
                                <span>•</span>
                                <span>
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ $blog->read_time ?? '3 min' }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3
                                class="font-bold text-dark text-base sm:text-lg mb-2 line-clamp-2 min-h-[3rem] group-hover:text-primary transition-colors">
                                <a
                                    href="{{ route('article.detail', ['slug' => Str::slug($blog->title[$lang] ?? '')]) }}">
                                    {{ $blog->title[$lang] ?? '' }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-xs sm:text-sm text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($blog->description[$lang] ?? '', 120) }}
                            </p>

                            <!-- Read More -->
                            <a href="{{ route('article.detail', ['slug' => Str::slug($blog->title[$lang] ?? '')]) }}"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-light-primary transition-colors group">
                                {{ $lang === 'id' ? 'Baca Selengkapnya' : 'Read More' }}
                                <i
                                    class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- View All Button -->
            @if ($blogs->count() >= 3)
                <div class="text-center mt-10 sm:mt-12" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('article') }}"
                        class="inline-block px-6 sm:px-8 py-3 bg-primary hover:bg-light-primary text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        Lihat Semua Artikel <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>


    <!-- Contact Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-neutral to-white" id="contact">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center mb-8 sm:mb-12" data-aos="fade-down">
                <p class="text-xs sm:text-sm font-semibold text-accent uppercase tracking-wide mb-2">
                    Get In Touch
                </p>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark mb-3">
                    Hubungi Kami
                </h2>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">
                    Siap membantu Anda merencanakan pengalaman glamping terbaik
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                <!-- Contact Info Cards -->
                <div class="space-y-4" data-aos="fade-right">

                    <!-- WhatsApp Card -->
                    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-success/10 rounded-full">
                                <i class="fa-brands fa-whatsapp text-success text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base sm:text-lg font-bold text-dark mb-1">
                                    {{ $texts['whatsapp_heading'] }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-600 mb-3">
                                    {{ $texts['whatsapp_description'] }}
                                </p>
                                <a href="https://wa.me/628123456789" target="_blank"
                                    class="inline-flex items-center gap-2 bg-success hover:bg-success/90 text-white font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md hover:shadow-lg text-sm">
                                    <i class="fa-brands fa-whatsapp text-lg"></i>
                                    <span>{{ $texts['whatsapp_number'] }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Phone & Email Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-white p-5 rounded-2xl shadow-md hover:shadow-lg transition-shadow"
                            data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-full">
                                    <i class="fa-solid fa-phone text-primary"></i>
                                </div>
                                <h4 class="font-bold text-dark text-sm sm:text-base">
                                    {{ $texts['phone_heading'] }}
                                </h4>
                            </div>
                            <a href="tel:{{ str_replace([' ', '-'], '', $texts['phone_number']) }}"
                                class="text-xs sm:text-sm text-gray-600 hover:text-primary transition-colors">
                                {{ $texts['phone_number'] }}
                            </a>
                        </div>

                        <div class="bg-white p-5 rounded-2xl shadow-md hover:shadow-lg transition-shadow"
                            data-aos="fade-up" data-aos-delay="250">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex items-center justify-center w-10 h-10 bg-accent/10 rounded-full">
                                    <i class="fa-solid fa-envelope text-accent"></i>
                                </div>
                                <h4 class="font-bold text-dark text-sm sm:text-base">
                                    {{ $texts['email_heading'] }}
                                </h4>
                            </div>
                            <a href="mailto:{{ $texts['email_address'] }}"
                                class="text-xs sm:text-sm text-gray-600 hover:text-primary transition-colors break-all">
                                {{ $texts['email_address'] }}
                            </a>
                        </div>
                    </div>

                    <!-- Address Card -->
                    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow"
                        data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-start gap-4">
                            <div
                                class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-danger/10 rounded-full">
                                <i class="fa-solid fa-location-dot text-danger text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-dark text-base sm:text-lg mb-2">
                                    {{ $texts['address_heading'] }}
                                </h4>
                                <p class="text-xs sm:text-sm text-gray-600 mb-4 leading-relaxed">
                                    {!! nl2br(e($texts['address_details'])) !!}
                                </p>
                                <a href="https://www.google.com/maps?ll=-8.342049,115.036913&z=14&t=m&hl=id&gl=ID&mapclient=embed&cid=9951410633565317211"
                                    target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 bg-primary hover:bg-light-primary text-white font-semibold px-4 py-2.5 rounded-lg transition-all shadow-md hover:shadow-lg text-sm">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                    <span>{{ $texts['address_map_cta'] }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow"
                    data-aos="fade-left">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-full">
                            <i class="fa-solid fa-map text-primary text-lg"></i>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-dark">
                            {{ $texts['location_heading'] }}
                        </h3>
                    </div>
                    <div class="relative w-full h-[300px] sm:h-[400px] lg:h-[500px] rounded-xl overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7895.1750634993!2d115.03386611055907!3d-8.343715401760706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd229a2ecb99547%3A0x8a1a833f13b4a85b!2sKampung%20Kopi%20Camp!5e0!3m2!1sid!2sid!4v1759163429473!5m2!1sid!2sid"
                            class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>



</div>
