<div>

    {{-- ======================= HEADER ======================= --}}
<section 
    class="relative w-full h-[70vh] flex items-center justify-center text-center text-white overflow-hidden"
    data-aos="fade-zoom-in" data-aos-duration="1200" data-aos-easing="ease-in-out" data-aos-once="true">

    <!-- Background Image -->
    <img 
        src="{{ $data['header_image'] }}" 
        alt="{{ $data['header_title'] }}"
        class="absolute inset-0 w-full h-full object-cover"
        data-aos="zoom-out" 
        data-aos-duration="1000"
    >

    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/50 to-black/50"></div>

    <!-- Content -->
    <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">

        <!-- Category -->
        <p class="uppercase text-white mb-3 tracking-wider text-[.7rem] md:text-sm"
           data-aos="fade-down" data-aos-delay="400">
            {!! $data['header_category'] !!}
        </p>

        <!-- Title -->
        <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-6"
            data-aos="fade-up" data-aos-delay="600">
            {!! $data['header_title'] !!}
        </h1>

        <!-- Divider -->
        <div class="w-24 h-1 bg-secondary mx-auto mb-6 rounded-full"
             data-aos="zoom-in" data-aos-delay="800"></div>

        <!-- Subtitle -->
        <p class="text-sm md:text-lg max-w-3xl mx-auto leading-relaxed text-gray-100 px-0 md:px-10"
           data-aos="fade-up" data-aos-delay="1000">
            {!! $data['header_subtitle'] !!}
        </p>
    </div>
</section>



  {{-- ======================= WHY SPECIAL ======================= --}}
<section class="max-w-7xl mx-auto px-6 lg:px-14 py-20">
    <h2 class="text-2xl md:text-4xl font-extrabold text-primary text-center leading-snug mb-6">
        {!! $data['why_special_title'] !!}
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-3">
        @foreach($data['specials'] as $item)
            <div class="bg-white p-10 rounded-2xl shadow-md border border-gray-100 
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                
                <div class="text-primary text-4xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa {{ $item['icon'] }}"></i>
                </div>

                <h3 class="font-bold text-xl mb-3 group-hover:text-primary transition">
                    {!! $item['title'] !!}
                </h3>

                <p class="text-gray-600 leading-relaxed">
                    {!! $item['desc'] !!}
                </p>
            </div>
        @endforeach
    </div>
</section>



{{-- ======================= QUOTE ======================= --}}
<section class="bg-primary/5 py-14 px-6">
    <div class="max-w-3xl mx-auto text-center">
        <p class="md:text-2xl text-lg font-light italic text-gray-800 mb-6 leading-relaxed">
            “{!! $data['quote_text'] !!}”
        </p>
        <p class="text-primary font-semibold text-lg tracking-wide">
            — {!! $data['quote_source'] !!}
        </p>
    </div>
</section>



{{-- ======================= TREKKING INFO ======================= --}}
<section class="max-w-7xl mx-auto px-6 lg:px-14 py-20">

    <h2 class="text-2xl md:text-4xl text-primary font-extrabold tracking-tight mb-6">
        {!! $data['trekking_title'] !!}
    </h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Medan --}}
        <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
            <h3 class="font-bold text-xl mb-3 group-hover:text-primary transition">
                {!! $data['trekking_medan_title'] !!}
            </h3>
            <p class="text-gray-600 leading-relaxed">{!! $data['trekking_medan_desc'] !!}</p>
        </div>

        {{-- Difficulty --}}
        <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
            <h3 class="font-bold text-xl mb-3 group-hover:text-primary transition">
                {!! $data['trekking_difficulty_title'] !!}
            </h3>
            <p class="text-gray-600 leading-relaxed">{!! $data['trekking_difficulty_desc'] !!}</p>
        </div>

        {{-- Time --}}
        <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
            <h3 class="font-bold text-xl mb-3 group-hover:text-primary transition">
                {!! $data['trekking_time_title'] !!}
            </h3>
            <p class="text-gray-600 leading-relaxed">{!! $data['trekking_time_desc'] !!}</p>
        </div>

        {{-- View --}}
        <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition">
            <h3 class="font-bold text-xl mb-3 group-hover:text-primary transition">
                {!! $data['trekking_view_title'] !!}
            </h3>
            <p class="text-gray-600 leading-relaxed">{!! $data['trekking_view_desc'] !!}</p>
        </div>

    </div>
</section>



{{-- ======================= PERSIAPAN WAJIB ======================= --}}
<section class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-14 py-20">
        <h2 class="text-2xl md:text-4xl text-primary font-extrabold tracking-tight mb-10">
            {!! $data['persiapan_wajib_title'] !!}
        </h2>

        <ul class="space-y-5 text-gray-700 text-lg">
            @foreach($data['persiapan'] as $item)
                <li class="flex items-start gap-4 bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <i class="fa fa-check-circle text-secondary text-3xl mt-1"></i>
                    <span class="leading-relaxed">{!! $item !!}</span>
                </li>
            @endforeach
        </ul>
    </div>
</section>


<section class="py-20 bg-light text-center">
  <div class="max-w-3xl mx-auto px-6">
    <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6">
      {{ $texts['sudah_siap_jelajah'] }} <span class="text-primary">{{ $texts['pupuan'] }}</span>
    </h2>
    <p class="text-sm md:text-md md:text-xl mb-8 text-gray-600">
      {{ $texts['pilih_paket'] }}
    </p>
    <a href="/paket-wisata" 
       class="inline-block px-8 py-3 bg-secondary text-white font-semibold rounded-xl shadow-lg hover:bg-primary hover:scale-103 transform transition duration-300">
      {{ $texts['lihat_paket'] }} <i class="fa-solid fa-arrow-right ml-2"></i>
    </a>
  </div>
</section>

</div>
