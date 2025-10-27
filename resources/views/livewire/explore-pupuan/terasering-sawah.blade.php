<div class="antialiased">
    
    <section 
        class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
        data-aos="fade-zoom-in" data-aos-duration="1200" data-aos-easing="ease-in-out" data-aos-once="true">

        <img src="/images/teraseringpupuan.jpg" 
            alt="Air Terjun Blemantung Background" 
            class="absolute inset-0 w-full h-full object-cover" data-aos="zoom-out" data-aos-duration="1000">

        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/50 to-black/50"></div>

        <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
            <p class="uppercase text-white mb-3 tracking-wider text-[.7rem] md:text-sm" data-aos="fade-down" data-aos-delay="400">
                {{ $texts['terassering_section_tagline'] }}
            </p>

            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-6" data-aos="fade-up" data-aos-delay="600">
                {{ $texts['terassering_title'] }}
            </h1>

            <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

            <p class="text-sm md:text-lg max-w-3xl mx-auto leading-relaxed text-gray-100 px-0 md:px-10" data-aos="fade-up" data-aos-delay="1000">
                {{ $texts['terassering_desc'] }}
            </p>
        </div>
    </section>

    <div class="relative h-12 bg-white -mt-1"></div>

    <section class="py-16 md:py-24 bg-white -mt-10">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-14 text-center" data-aos="fade-up">
            {!! $texts['belimbing_section_title'] !!}
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Poin 1 --}}
            <div class="p-8 bg-white rounded-3xl shadow-xl transition duration-500 transform hover:scale-[1.02] hover:shadow-primary/30" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-globe-asia text-3xl md:text-4xl text-primary mb-4 block"></i>
                <h3 class="font-semibold text-lg mb-2">{{ $texts['belimbing_poin1_judul'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $texts['belimbing_poin1_desc'] }}</p>
            </div>

            {{-- Poin 2 --}}
            <div class="p-8 bg-white rounded-3xl shadow-xl transition duration-500 transform hover:scale-[1.02] hover:shadow-primary/30" data-aos="fade-up" data-aos-delay="200">
                <i class="fas fa-mountain text-3xl md:text-4xl text-primary mb-4 block"></i>
                <h3 class="font-semibold text-lg mb-2">{{ $texts['belimbing_poin2_judul'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $texts['belimbing_poin2_desc'] }}</p>
            </div>

            {{-- Poin 3 --}}
            <div class="p-8 bg-white rounded-3xl shadow-xl transition duration-500 transform hover:scale-[1.02] hover:shadow-primary/30" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-water text-3xl md:text-4xl text-primary mb-4 block"></i>
                <h3 class="font-semibold text-lg mb-2">{{ $texts['belimbing_poin3_judul'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $texts['belimbing_poin3_desc'] }}</p>
            </div>

            {{-- Poin 4 --}}
            <div class="p-8 bg-white rounded-3xl shadow-xl transition duration-500 transform hover:scale-[1.02] hover:shadow-primary/30" data-aos="fade-up" data-aos-delay="400">
                <i class="fas fa-tint text-3xl md:text-4xl text-primary mb-4 block"></i>
                <h3 class="font-semibold text-lg mb-2">{{ $texts['belimbing_poin4_judul'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $texts['belimbing_poin4_desc'] }}</p>
            </div>

        </div>
    </div>
</section>

    <section class="py-16 md:py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-4xl">
            <i class="fas fa-quote-left text-5xl text-primary/50 mb-6" data-aos="fade-down"></i>
            <p class="text-md md:text-2xl italic text-gray-700 leading-relaxed font-light" data-aos="fade-up" data-aos-delay="200">
                 "{{ $texts['trekking_quote'] }}"
            </p>
            <p class="mt-8 text-sm md:text-lg font-semibold text-gray-500" data-aos="fade-up" data-aos-delay="400">— {{$texts['quote_blematung_source']}}</p>
        </div>
    </section>

<section class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto p-0 md:p-8 rounded-none md:rounded-3xl bg-white">
            
            {{-- TITLE SECTION --}}
            <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6 text-center" data-aos="fade-up">
                {!! $texts['trekking_section_title'] !!}
            </h2>

            <div class="flex flex-col md:flex-row md:space-x-8 space-y-8 md:space-y-0 items-start">
                
                {{-- 1. CARD RECOMMENDED ACTIVITIES --}}
                <div class="w-full md:w-1/2 p-6 rounded-none md:rounded-2xl bg-white" data-aos="fade-right">
                    <div class="flex items-center mb-5 border-b border-gray-100 pb-3">
                        <i class="fas fa-route text-3xl text-primary mr-4"></i>
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $texts['trekking_card1_title'] }}
                        </h3>
                    </div>

                    <p class="text-sm md:text-lg text-gray-600 leading-relaxed mb-6">
                        {{ $texts['trekking_card1_desc'] }}
                    </p>

                    <div class="p-4 border border-gray-100 rounded-lg">
                        <ul class="space-y-4">

                            <li class="flex flex-col items-start text-gray-700">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-hiking text-xl text-primary mr-3"></i>
                                    <span class="font-bold text-gray-800 text-lg">{{ $texts['trekking_trekking_title'] }}</span>
                                </div>
                                <span class="ml-0 md:ml-8 font-normal text-gray-600">
                                    {{ $texts['trekking_trekking_desc'] }}
                                </span>
                            </li>

                            <li class="flex flex-col items-start text-gray-700">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-bicycle text-xl text-primary mr-3"></i>
                                    <span class="font-bold text-gray-800 text-lg">{{ $texts['trekking_cycling_title'] }}</span>
                                </div>
                                <span class="ml-0 md:ml-8 font-normal text-gray-600">
                                    {{ $texts['trekking_cycling_desc'] }}
                                </span>
                            </li>

                            <li class="flex flex-col items-start text-gray-700">
                                <div class="flex items-center mb-1">
                                    <i class="fas fa-umbrella-beach text-xl text-primary mr-3"></i>
                                    <span class="font-bold text-gray-800 text-lg">{{ $texts['trekking_waterfall_title'] }}</span>
                                </div>
                                <span class="ml-0 md:ml-8 font-normal text-gray-600">
                                    {{ $texts['trekking_waterfall_desc'] }}
                                </span>
                            </li>

                        </ul>
                    </div>
                </div>

                {{-- 2. CARD RICE FIELD ETIQUETTE --}}
                <div class="w-full md:w-1/2 p-6 rounded-none md:rounded-2xl bg-white" 
                    data-aos="fade-right" data-aos-delay="200">

                    <div class="flex items-center mb-5 border-b border-gray-100 pb-3">
                        <i class="fas fa-hand-paper text-3xl text-primary mr-4"></i>
                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $texts['trekking_card2_title'] }}
                        </h3>
                    </div>

                    <ul class="space-y-4 text-gray-700 p-4 border border-gray-100 rounded-lg">
                        <li class="flex items-start">
                            <i class="fas fa-leaf text-xl text-primary mr-3"></i>
                            {{ $texts['trekking_etika1'] }}
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-trash-alt text-xl text-primary mr-3"></i>
                            {{ $texts['trekking_etika2'] }}
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-camera text-xl text-primary mr-3"></i>
                            {{ $texts['trekking_etika3'] }}
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-sun text-xl text-primary mr-3"></i>
                            {{ $texts['trekking_etika4'] }}
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</section>



    <section class="py-20 bg-light text-center">
  <div class="max-w-3xl mx-auto px-6">
    <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6"
        data-aos="fade-down"
        data-aos-duration="800"
        data-aos-delay="100">
      {{ $texts['sudah_siap_jelajah'] }} <span class="text-primary">{{ $texts['pupuan'] }}</span>
    </h2>
    <p class="text-sm md:text-md md:text-xl mb-8 text-gray-600"
       data-aos="fade-up"
       data-aos-duration="800"
       data-aos-delay="200">
      {{ $texts['pilih_paket'] }}
    </p>
    <a href="/paket-wisata" 
       class="inline-block px-8 py-3 bg-secondary text-white font-semibold rounded-xl shadow-lg hover:bg-primary hover:scale-103 transform transition duration-300"
       data-aos="zoom-in"
       data-aos-duration="800"
       data-aos-delay="300">
      {{ $texts['lihat_paket'] }} <i class="fa-solid fa-arrow-right ml-2"></i>
    </a>
  </div>
</section>
</div>