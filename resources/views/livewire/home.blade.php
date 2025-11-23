<div class="overflow-x-hidden">
    <!-- Hero Section -->
    <section class="relative w-full min-h-screen overflow-hidden">
        <!-- Background Video -->
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="videos/headergambarrr.mp4" type="video/mp4">
            Browser tidak mendukung video.
        </video>

        <!-- Overlay Gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/45 to-black/40"></div>

        <!-- Hero Content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8 pt-20 pb-16">
            <div class="max-w-4xl mx-auto text-center text-white space-y-6 sm:space-y-8">

                <!-- Badge -->
                <span
                    class="inline-block bg-secondary backdrop-blur-sm text-white text-xs sm:text-sm font-semibold px-4 sm:px-6 py-2 rounded-full shadow-lg"
                    data-aos="fade-down" data-aos-delay="200">
                    {{ $texts['badge'] }}
                </span>

                <!-- Headline -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight" data-aos="fade-up"
                    data-aos-delay="400">
                    {{ $texts['headline_part1'] }} 
                    <span class="text-primary">{{ $texts['headline_part2'] }}</span>
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
                        <i class="fa-solid fa-users text-primary"></i>
                        <span><strong>{{ $texts['happy_travelers'] }}</strong> Happy Travelers</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full">
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        <span><strong>{{ $texts['location'] }}</strong> Premium Location</span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col md:px-10 px-10 sm:flex-row items-center justify-center gap-4 pt-4" data-aos="fade-up"
                    data-aos-delay="1000">
                    <a href="#paket"
                        class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-primary hover:bg-secondary text-white font-semibold rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105">
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
    <section id="about" class="relative py-12 sm:py-16 lg:py-20">
        <div class="container max-w-7xl mx-auto px-6 lg:px-14 py-16">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">

                <!-- Text Content -->
                <div class="flex-1 w-full" data-aos="fade-right">
                    <p class="text-xs sm:text-sm font-semibold text-amber-800 uppercase tracking-wide mb-3"
                        data-aos="fade-down" data-aos-delay="100">
                        {{ $texts['about_badge'] }}
                    </p>

                    <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6"
                        data-aos="fade-up" data-aos-delay="200">
                        {{ $texts['about_title_part1'] }}
                        <span class="text-primary">{{ $texts['about_title_part2'] }}</span>
                    </h2>

                    <p class="text-md sm:text-base text-gray-700 leading-relaxed mb-4" data-aos="fade-up"
                        data-aos-delay="300">
                        {{ $texts['about_desc1'] }}
                    </p>

                    <p class="text-md sm:text-base text-gray-700 leading-relaxed mb-6 sm:mb-8" data-aos="fade-up"
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
                        class="inline-block w-full sm:w-auto px-6 sm:px-8 py-3 bg-secondary hover:bg-primary text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 text-center">
                        <i class="fa-solid fa-arrow-right mr-2"></i>{{ $texts['learn_more'] }}
                    </a>
                </div>

                <!-- Image Content -->
                <div class="flex-1 w-full relative" data-aos="fade-left" data-aos-delay="400">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="images/headerpaket.webp" alt="Kopi Bali" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Paket Wisata Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white" id="paket">
        <div class="container max-w-7xl mx-auto px-6 lg:px-14 py-16">
            <!-- Section Header -->
           <div class="text-center mb-12" data-aos="fade-down">
                <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6">{!! $texts['paket_heading'] !!}</h2>
                <p class="text-sm md:text-lg text-gray-600 mt-2" data-aos="fade-up" data-aos-delay="100">
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
                            <img src="{{ $paket->images[0] }}"
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
                                <a href="{{ Route('booking.flow', $paket->slug) }}"
                                    class="flex-1 text-center px-3 py-2.5 bg-primary hover:bg-secondary text-white text-sm font-semibold rounded-lg transition-all duration-300 hover:shadow-lg">
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
 <section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        <div 
        class="relative grid grid-cols-2 gap-4 rounded-2xl overflow-hidden" 
        data-aos="zoom-in" 
        data-aos-duration="1000"
          >
        <img 
            src="images/explorepupuansatu.webp" 
            class="col-span-2 w-full h-72 object-cover rounded-xl" 
            alt="Foto Bawah Penuh"
        />
        <img 
            src="images/about.webp" 
            class="w-full h-72 object-cover rounded-xl" 
            alt="Foto Kiri Atas"
        />
        
        <img 
            src="images/airterjun.webp" 
            class="w-full h-72 object-cover rounded-xl" 
            alt="Foto Kanan Atas"
        />
    </div>
    

    <!-- Konten Teks -->
    <div data-aos="fade-up" data-aos-duration="1200">
      <p class="text-sm font-semibold text-amber-800 mb-2">{{ __('messages.explore_title') }}</p>
      <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6">{!! __('messages.explore_heading') !!}</h2>
      <p class="text-gray-600 text-sm md:text-lg mb-8">{{ __('messages.explore_description') }}</p>

      <!-- Destinasi List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4 mb-8">
          @foreach([
            ['icon' => 'fa-water', 'title' => 'dest_air_terjun', 'time' => 'dest_air_terjun_time', 'desc' => 'dest_air_terjun_desc'],
            ['icon' => 'fa-mountain-sun', 'title' => 'dest_jatiluwih', 'time' => 'dest_jatiluwih_time', 'desc' => 'dest_jatiluwih_desc'],
            ['icon' => 'fa-tree', 'title' => 'dest_kopi', 'time' => 'dest_kopi_time', 'desc' => 'dest_kopi_desc'],
            ['icon' => 'fa-house-chimney-user', 'title' => 'dest_desa', 'time' => 'dest_desa_time', 'desc' => 'dest_desa_desc'],
          ] as $dest)
            {{-- Penyesuaian: Padding lebih kecil, Shadow minimalis, Border tipis --}}
            <div class="flex items-start p-3 sm:p-4 bg-white border border-gray-100 rounded-xl transition duration-300 hover:shadow-md" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}">
              
              {{-- Ikon: Ukuran sedikit diperkecil dan diletakkan lebih dekat --}}
              <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary mr-3 flex-shrink-0 mt-0.5">
                <i class="fa-solid {{ $dest['icon'] }} text-white text-base"></i>
              </div>
              
              {{-- Konten Teks --}}
              <div>
                <h4 class="font-medium text-gray-900 leading-snug">
                  {{ __('messages.' . $dest['title']) }}
                
                </h4>
                {{-- Deskripsi: Ukuran font tetap kecil (text-sm) tapi warna lebih lembut --}}
                <p class="text-sm text-gray-500 mt-1">
                  {{ __('messages.' . $dest['desc']) }}
                </p>
              </div>
            </div>
          @endforeach
      </div>

      <!-- Statistik -->
      <div class="flex gap-8" data-aos="zoom-in" data-aos-delay="200">
        <div>
          <h3 class="md:text-3xl text-xl font-bold text-secondary">10+</h3>
          <p class="text-sm text-gray-600">{{ __('messages.stat_destinasi') }}</p>
        </div>
        <div>
          <h3 class="md:text-3xl text-xl font-bold text-secondary">4.9</h3>
          <p class="text-sm text-gray-600">{{ __('messages.stat_rating') }}</p>
        </div>
        <div>
          <h3 class="md:text-3xl text-xl font-bold text-secondary">100%</h3>
          <p class="text-sm text-gray-600">{{ __('messages.stat_experience') }}</p>
        </div>
      </div>
    </div>

  </div>
</section>


    <!-- CTA Parallax Section -->
<section class="relative h-[70vh] pb-10 bg-gray-900 overflow-hidden">
  <!-- Background image -->
  <div class="absolute inset-0">
    <img src="images/pupuan.webp" 
         alt="{{ $texts['heading'] }}"
         class="w-full h-full object-cover scale-110"
         data-aos="zoom-out"
         data-aos-duration="2000">
    <div class="absolute inset-0 bg-black/50"></div> <!-- Overlay -->
  </div>

  <!-- Content -->
  <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-6">
    <h2 class="text-2xl md:text-5xl font-bold mb-4"
        data-aos="fade-up"
        data-aos-duration="1000"
        >
      {{ $texts['heading'] }}
    </h2>

    <p class="text-lg text-sm md:text-xl mb-6 opacity-90 max-w-2xl"
       data-aos="fade-up"
       data-aos-delay="300"
       data-aos-duration="1200"
      >
      {{ $texts['description'] }}
    </p>

    <a href="#booking"
       class="inline-block bg-primary hover:bg-secondary hover:text-white  text-secondary text-md md:text-lg font-semibold px-8 py-4 rounded-xl shadow-lg duration-300 transition"
       data-aos="flip-up"
       data-aos-delay="600"
       data-aos-duration="1000">
      <i class="fa-solid fa-mug-hot mr-2"></i> {{ $texts['cta_text'] }}
    </a>
  </div>
</section>


    <!-- Gallery Section -->
 <section class="bg-[#f9f7f4] py-16 min-h-screen" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
  <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16">
           <h2 class="text-2xl text-center md:text-4xl font-extrabold text-secondary leading-snug mb-6"
            data-aos="fade-down" data-aos-duration="1000">
            {{ $texts['gallery_heading'] }}
        </h2>
        <p class="text-gray-600 mb-10 md:text-lg text-sm text-center mt-4" 
           data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            {{ $texts['gallery_description'] }}
        </p>

  

    <!-- Grid Layout Abstrak -->
    <div 
            class="grid grid-cols-1 md:grid-cols-3 grid-rows-none md:grid-rows-2 gap-4 rounded-2xl overflow-hidden" 
            data-aos="zoom-in" 
            data-aos-delay="200" 
            data-aos-duration="1000"
        >
                
            <div class="md:col-span-2 md:row-span-2">
                <img 
                    src="images/kampungkopipupuan.webp" 
                    alt="Suasana Camp" 
                    class="w-full h-80 md:h-[600px] object-cover rounded-2xl"
                >
            </div>


            <div data-aos="fade-left">
                <img 
                    src="images/kampungkopipupuansatu.webp" 
                    alt="Kopi" 
                    class="w-full h-80 md:h-[300px] object-cover rounded-2xl" >
            </div>

            
            <div data-aos="fade-left">
                <img 
                    src="images/kampungkopicamp.webp" 
                    alt="Tenda" 
                    class="w-full h-80 md:h-[300px] object-cover rounded-2xl" >
            </div>

            
            <div class="md:col-span-1" data-aos="fade-left">
                <img 
                    src="images/kopicamp.webp" 
                    alt="Wisata Alam" 
                    class="w-full h-80 md:h-[500px] object-cover rounded-2xl" >
            </div>

        
            <div class="md:col-span-1" data-aos="fade-up">
                <img 
                    src="/images/ayokepupuan.webp" 
                    alt="Wisata Alam" 
                    class="w-full h-80 md:h-[500px] object-cover rounded-2xl" >
            </div>

            <div class="md:col-span-1" data-aos="fade-up">
                <img 
                    src="/images/pupuankopi.webp" 
                    alt="Wisata Alam" 
                    class="w-full h-80 md:h-[500px] object-cover rounded-2xl" >
            </div>

        </div>
  </div>
</section>


    {{-- Article Section --}}
    @php
        $lang = app()->getLocale() ?? 'id';
    @endphp

    <section class="py-12 sm:py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16">
            <!-- Section Header -->
              <h2 class="text-2xl text-center md:text-4xl font-extrabold text-secondary leading-snug mb-6"
        data-aos="fade-up"
        data-aos-duration="1000">
        {{ $texts['article_heading'] }}
    </h2>
    <p class="md:text-lg text-sm text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">
        {{ $texts['article_description'] }}
    </p>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-14 lg:gap-8">
                @foreach ($blogs as $index => $blog)
                     <article
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <!-- Image Container with Overlay -->
                        <div class="relative overflow-hidden h-56">
                            <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://picsum.photos/400/400?random=' . $blog->id }}"
                                alt="{{ $blog->title[$lang] ?? '' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-secondary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-secondary/95 text-white px-4 py-1.5 rounded-full text-xs font-bold tracking-wide shadow-lg">
                                    <i class="fas fa-bookmark mr-1"></i>
                                    {{ $texts['article_type'] ?? 'Article' }}
                                </span>
                            </div>

                            <!-- Read More Icon (appears on hover) -->
                           
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Meta Information -->
                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <i class="far fa-calendar text-accent"></i>
                                    {{ $blog->published_at->format('d M Y') ?? '3 min' }}
                                </span>
                                <span class="text-gray-300">•</span>
                                <span class="flex items-center gap-1">
                                    <i class="far fa-user text-accent"></i>
                                    Admin
                                </span>

                            </div>

                            <!-- Title -->
                            <h3
                                class="text-xl font-bold text-slate-800 mb-3 line-clamp-2 transition-colors duration-300">
                                {{ $blog->title ?? '' }}
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed">
                                {{ Str::limit($blog->excerpt ?? '', 120) }}
                            </p>

                            <!-- Read More Link -->
                            <a href="{{ route('article.detail', $blog->slug) }}"
                                class="inline-flex items-center gap-2 text-primary font-semibold hover:text-dark-primary transition-colors group/link">
                                {{ $lang === 'id' ? 'Baca Selengkapnya' : 'Read More' }}
                                <i
                                    class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
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
<section class="py-20 bg-[#f9f7f4] text-gray-800" id="contact">
  <div class="max-w-7xl mx-auto px-6 lg:px-14 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12">

    <!-- Info Kontak -->
    <div class="space-y-6" data-aos="fade-right" data-aos-duration="1000" data-aos-offset="200">

      <!-- WhatsApp -->
      <div class="bg-white p-6 rounded-2xl shadow" data-aos="fade-up" data-aos-delay="100">
        <h4 class="flex items-center text-lg font-semibold mb-3">
          <span class="flex items-center justify-center w-10 h-10 bg-green-500 rounded-full mr-3">
            <i class="fa-brands fa-whatsapp text-white"></i>
          </span>
          {{ $texts['whatsapp_heading'] }}
        </h4>
        <p class="text-sm text-gray-600 mb-4">{{ $texts['whatsapp_description'] }}</p>
        <a href="https://wa.me/628123456789" target="_blank"
           class="flex items-center bg-secondary hover:bg-secondary/90 text-white font-medium px-4 py-3 rounded-lg transition">
          <i class="fa-brands fa-whatsapp text-xl mr-2"></i> {{ $texts['whatsapp_number'] }}
        </a>
      </div>

      <!-- Telepon & Email -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow" data-aos="fade-up" data-aos-delay="200">
          <h4 class="flex items-center font-semibold mb-2">
            <i class="fa-solid fa-phone mr-2 text-secondary"></i> {{ $texts['phone_heading'] }}
          </h4>
          <p class="text-sm text-gray-600">{{ $texts['phone_number'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow" data-aos="fade-up" data-aos-delay="300">
          <h4 class="flex items-center font-semibold mb-2">
            <i class="fa-solid fa-envelope mr-2 text-secondary"></i> {{ $texts['email_heading'] }}
          </h4>
          <p class="text-sm text-gray-600">{{ $texts['email_address'] }}</p>
        </div>
      </div>

      <!-- Alamat -->
      <div class="bg-white p-6 rounded-2xl shadow" data-aos="fade-up" data-aos-delay="400">
        <h4 class="flex items-center font-semibold mb-2">
          <i class="fa-solid fa-location-dot mr-2 text-secondary"></i> {{ $texts['address_heading'] }}
        </h4>
        <p class="text-sm text-gray-600 mb-4">{!! nl2br(e($texts['address_details'])) !!}</p>
        <a href="https://www.google.com/maps?ll=-8.342049,115.036913&z=14&t=m&hl=id&gl=ID&mapclient=embed&cid=9951410633565317211" target="_blank"
           class="inline-block bg-secondary hover:bg-secondary/90 px-4 py-2 rounded-lg font-medium transition text-white">
          <i class="fa-solid fa-map-location-dot mr-2"></i> {{ $texts['address_map_cta'] }}
        </a>
      </div>
    </div>

    <!-- Google Maps -->
   <div class="bg-white p-6 rounded-2xl shadow overflow-hidden" 
          data-aos="fade-up" 
          data-aos-duration="1000" 
          data-aos-offset="200">
          
        <h3 class="flex items-center text-lg font-semibold mb-4 text-gray-900">
          <i class="fa-solid fa-map text-secondary mr-2"></i> {{ $texts['location_heading'] }}
        </h3>
        
        {{-- Tambahkan wrapper dengan rasio aspek tetap untuk Mobile --}}
        <div class="relative h-[400px] w-full" style="padding-top: 56.25%;">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7895.1750634993!2d115.03386611055907!3d-8.343715401760706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd229a2ecb99547%3A0x8a1a833f13b4a85b!2sKampung%20Kopi%20Camp!5e0!3m2!1sid!2sid!4v1759163429473!5m2!1sid!2sid"
            class="absolute top-0 left-0 w-full h-full rounded-lg"
            style="border:0;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>

     </div>

  </div>
</section>



</div>
