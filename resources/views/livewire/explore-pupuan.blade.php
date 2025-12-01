<div>
    <section class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
        data-aos="fade-zoom-in" data-aos-duration="1200" data-aos-easing="ease-in-out" data-aos-once="true">

        <!-- Background Image -->
        <img src="/images/airterjun.webp" alt="Explore Pupuan Background"
            class="absolute inset-0 w-full h-full object-cover" data-aos="zoom-out" data-aos-duration="1000">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/50 to-black/50"></div>

        <!-- Content -->
        <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
            <!-- Sub Heading -->
            <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
                {{ $texts['small'] }}
            </p>

            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-6" data-aos="fade-up" data-aos-delay="600">
                {{ $texts['heading'] }}
                @if (!empty($texts['highlight']))
                    <span class="text-secondary">{{ $texts['highlight'] }}</span>
                @endif
            </h1>


            <!-- Decorative Line -->
            <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

            <!-- Description -->
            <p class="text-sm md:text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up"
                data-aos-delay="1000">
                {{ $texts['description'] }}
            </p>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16 grid md:grid-cols-2 gap-12 items-center">

            <!-- Text Content -->
            <div data-aos="fade-right" data-aos-duration="1000">
                <p class="text-sm font-semibold text-amber-800 mb-3" data-aos="fade-down" data-aos-delay="100">
                    {{ $texts['about_explore_small'] }}
                </p>
                <h2 class="text-2xl md:text-4xl font-extrabold text-primary leading-snug mb-6" data-aos="fade-up"
                    data-aos-delay="200">
                    {{ $texts['about_explore_heading'] }}
                    {{ $texts['about_explore_highlight'] }}
                    <span class="text-secondary">{{ $texts['about_explore_heading_suffix'] }}</span>
                </h2>
                <p class="text-gray-700 text-sm md:text-lg mb-6 leading-relaxed" data-aos="fade-up"
                    data-aos-delay="300">
                    {!! $texts['about_explore_paragraph1'] !!}
                </p>
                <p class="text-gray-700 text-sm md:text-lg mb-10 leading-relaxed" data-aos="fade-up"
                    data-aos-delay="400">
                    {!! $texts['about_explore_paragraph2'] !!}
                </p>
            </div>


            <!-- Image -->
            <div class="relative" data-aos="fade-left" data-aos-duration="1000">
                <img src="/images/headerexplorepupuan.webp" alt="Explore Pupuan"
                    class="rounded-2xl shadow-lg object-cover">

            </div>

        </div>
    </section>

    <section class="py-20 bg-[#f9f7f4]">
        <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16 text-center">

            <!-- Heading -->
            <h2 class="text-2xl md:text-4xl font-extrabold text-primary leading-snug mb-6" data-aos="fade-down"
                data-aos-duration="1000">
                {!! $texts['why_explore_title'] !!}
            </h2>
            <p class="text-gray-600 text-sm md:text-lg max-w-2xl mx-auto mb-12" data-aos="fade-up"
                data-aos-duration="1000" data-aos-delay="200">
                {{ $texts['why_explore_desc'] }}
            </p>

            <!-- Grid Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Card 1 -->
                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
                            <i class="fa-solid fa-mountain text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">{{ $texts['card1_title'] }}</h3>
                    <p class="text-gray-600 text-[.8rem] md:text-sm">
                        {{ $texts['card1_desc'] }}
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up"
                    data-aos-delay="400">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
                            <i class="fa-solid fa-mug-hot text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">{{ $texts['card2_title'] }}</h3>
                    <p class="text-gray-600 text-[.8rem] md:text-sm">
                        {{ $texts['card2_desc'] }}
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up"
                    data-aos-delay="500">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
                            <i class="fa-solid fa-leaf text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">{{ $texts['card3_title'] }}</h3>
                    <p class="text-gray-600 text-[.8rem] md:text-sm">
                        {{ $texts['card3_desc'] }}
                    </p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up"
                    data-aos-delay="600">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
                            <i class="fa-solid fa-users text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">{{ $texts['card4_title'] }}</h3>
                    <p class="text-gray-600 text-[.8rem] md:text-sm">
                        {{ $texts['card4_desc'] }}
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16 text-center">

            <!-- Headline -->
            <h2 class="text-2xl md:text-4xl font-extrabold text-primary leading-snug mb-6" data-aos="fade-down"
                data-aos-duration="1000">
                {{ $texts['headline']['title'] }}
            </h2>
            <p class="text-gray-700 mb-12 max-w-2xl text-sm md:text-lg mx-auto" data-aos="fade-up"
                data-aos-duration="1000" data-aos-delay="200">
                {{ $texts['headline']['desc'] }}
            </p>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($texts['cards'] as $index => $card)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl overflow-hidden transition duration-300"
                        data-aos="fade-up" data-aos-delay="{{ 300 + $index * 100 }}">

                        <img src="{{ $card['image'] }}" class="w-full h-56 object-cover"
                            alt="{{ $card['title'] }}">

                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2">{{ $card['title'] }}</h3>
                            <p class="text-gray-600 text-[.8rem] md:text-sm mb-4">{{ $card['desc'] }}</p>
                            <a class="text-primary font-medium hover:underline">
                                {{ $texts['lihat_detail'] }}
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>


    <!-- Galeri Foto -->
    <section class="py-16 bg-white pb-32" x-data="{ imageModal: false, imageSrc: '', imageAlt: '' }" @keydown.escape.window="imageModal = false">
        <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16 text-center mb-8">
            <h2 class="text-2xl text-center md:text-4xl font-extrabold text-primary leading-snug mb-6"
                data-aos="fade-down" data-aos-duration="1000">
                {{ $texts['gallery_heading'] }}
            </h2>
            <p class="text-gray-600 mb-10 md:text-lg text-sm text-center mt-4" data-aos="fade-up"
                data-aos-duration="1000" data-aos-delay="200">
                {{ $texts['gallery_description'] }}
            </p>

            <!-- Masonry grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 auto-rows-fr">

                <img src="images/atvpupuan.webp"
                    class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg md:row-span-2" data-aos="zoom-in"
                    data-aos-delay="100"
                    @click="imageSrc = 'images/atvpupuan.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="images/gallerytiga.webp" class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg"
                    data-aos="zoom-in" data-aos-delay="200"
                    @click="imageSrc = 'images/gallerytiga.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="images/glampingkkc.webp"
                    class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg md:row-span-2" data-aos="zoom-in"
                    data-aos-delay="300"
                    @click="imageSrc = 'images/glampingkkc.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="images/toiletkampungkopi.webp" class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg"
                    data-aos="zoom-in" data-aos-delay="400"
                    @click="imageSrc = 'images/toiletkampungkopi.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="images/cofeeinpupuan.webp" class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg"
                    data-aos="zoom-in" data-aos-delay="500"
                    @click="imageSrc = 'images/cofeeinpupuan.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="images/apiunggun.webp"
                    class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg md:row-span-2" data-aos="zoom-in"
                    data-aos-delay="600"
                    @click="imageSrc = 'images/apiunggun.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="/images/airterjunpupuan.webp" class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg"
                    data-aos="zoom-in" data-aos-delay="700"
                    @click="imageSrc = 'images/airterjunpupuan.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="/images/budhapupuan.webp" class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg"
                    data-aos="zoom-in" data-aos-delay="800"
                    @click="imageSrc = 'images/budhapupuan.webp'; imageAlt = 'Suasana Camp'; imageModal = true">

                <img src="/images/pohonairterjun.webp" class="w-full h-80 sm:h-96 md:h-full object-cover rounded-lg"
                    data-aos="zoom-in" data-aos-delay="900"
                    @click="imageSrc = 'images/pohonairterjun.webp'; imageAlt = 'Suasana Camp'; imageModal = true">
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="imageModal" x-cloak
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-gray-700/50" x-transition.opacity
                @click="imageModal = false">

                <!-- Modal Container -->
                <div class="relative max-w-5xl w-full mx-auto rounded-xl overflow-hidden" @click.stop
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                    <!-- Close button -->
                    <button
                        class="absolute top-3 right-3 z-50 text-white bg-black/40 hover:bg-black/60 rounded-full p-2 transition-colors"
                        @click="imageModal = false" aria-label="Close">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>

                    <!-- Image -->
                    <div class=" flex items-center justify-center p-4">
                        <img :src="imageSrc" :alt="imageAlt"
                            class="max-h-[80vh] w-auto max-w-full object-contain rounded-md" />
                    </div>

                    <!-- Caption -->
                    <div class="text-center py-3 flex">
                        <p class="mx-auto text-sm text-black bg-white/60 w-max px-3 py-1 rounded-full"
                            x-text="imageAlt"></p>
                    </div>
                </div>
            </div>
        </template>
    </section>


    <!-- Tips & Itinerary Singkat -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center mb-12" data-aos="fade-down" data-aos-duration="1000">
            <h2 class="text-2xl md:text-4xl font-extrabold text-primary leading-snug mb-6">
                {{ $texts['tips_headline']['title'] }}</h2>
            <p class="text-sm md:text-lg text-gray-600 mt-2">{{ $texts['tips_headline']['desc'] }}</p>
        </div>

        <div class="max-w-5xl px-6 mx-auto grid gap-6 md:grid-cols-3">
            @foreach ($texts['tips_cards'] as $index => $card)
                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1"
                    data-aos="fade-up" data-aos-delay="{{ 200 + $index * 100 }}">
                    <div class="flex justify-center mb-4">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
                            <i class="fas {{ $card['icon'] }} text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2 text-center">{{ $card['title'] }}</h3>
                    <p class="text-gray-700 text-sm text-center">{{ $card['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>


    <!-- CTA / Pesan Paket -->
    <section class="py-20 bg-light text-center">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-2xl md:text-4xl font-extrabold text-primary leading-snug mb-6" data-aos="fade-down"
                data-aos-duration="800" data-aos-delay="100">
                {{ $texts['sudah_siap_jelajah'] }} <span class="text-secondary">{{ $texts['pupuan'] }}</span>
            </h2>
            <p class="text-sm md:text-md md:text-xl mb-8 text-gray-600" data-aos="fade-up" data-aos-duration="800"
                data-aos-delay="200">
                {{ $texts['pilih_paket'] }}
            </p>
            <a href="{{ route('package.product') }}"
                class="inline-block px-8 py-3 bg-secondary text-white font-semibold rounded-xl shadow-lg hover:bg-primary hover:scale-103 transform transition duration-300"
                data-aos="zoom-in" data-aos-duration="800" data-aos-delay="300">
                {{ $texts['lihat_paket'] }} <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>



</div>
