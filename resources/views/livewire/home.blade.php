<div class="">
  <!-- Hero Section -->
  <div class="relative w-screen h-screen overflow-hidden">
      <!-- Background Video -->
      <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-screen object-cover pointer-events-none">
          <source src="videos/headergambarrr.mp4" type="video/mp4">
          Browser tidak mendukung video.
      </video>

      <!-- Overlay -->
      <div class="absolute inset-0 bg-black/30 pointer-events-none"></div>

      <!-- Konten Hero -->
      <div class="relative mt-12 z-10 flex flex-col items-center justify-center h-full text-center text-white px-6">
          
          <!-- Badge -->
          <span class="bg-secondary text-white text-sm font-semibold px-4 py-1 rounded-full mb-4"
                data-aos="fade-down" data-aos-delay="200">
              {{ $texts['badge'] }}
          </span>

          <!-- Headline -->
          <h1 class="text-3xl md:text-6xl font-bold leading-tight mb-6"
              data-aos="fade-up" data-aos-delay="400">
              {{ $texts['headline_part1'] }} <span class="text-primary">{{ $texts['headline_part2'] }}</span>
          </h1>

          <!-- Subheadline -->
          <p class="text-sm md:text-xl mb-8 max-w-2xl"
            data-aos="fade-up" data-aos-delay="600">
              {{ $texts['subheadline'] }}
          </p>

          <!-- Info singkat -->
          <div class="flex flex-wrap justify-center gap-6 mb-8 text-sm md:text-base"
              data-aos="zoom-in" data-aos-delay="800">
              <div class="flex items-center space-x-2">
                  <span>👤</span>
                  <span><strong>{{ $texts['happy_travelers'] }}</strong> Happy Travelers</span>
              </div>
              <div class="flex items-center space-x-2">
                  <span>📍</span>
                  <span><strong>{{ $texts['location'] }}</strong> Premium Location</span>
              </div>
          </div>

          <div class="flex flex-col items-center space-y-4 md:flex-row md:space-y-0 md:space-x-4 mb-16" data-aos="fade-up" data-aos-delay="1000">
    
            <a href="#paket" class="w-full text-sm md:w-auto px-8 py-3 bg-primary text-black font-semibold rounded-lg hover:bg-secondary hover:text-white transition text-center">
                {{ $texts['cta_packages'] }}
            </a>
            
            <a href="#video" class="w-full text-sm md:w-auto px-8 py-3 bg-white/20 border border-white rounded-lg font-semibold hover:bg-white/30 transition text-center">
                {{ $texts['cta_booking'] }}
            </a>
            
        </div>
      </div>
  </div>


{{-- ============ABOUT HOME SECTION============ --}}
<section id="about" class="relative py-20 bg-white">
  <div class="container max-w-6xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
    
    <!-- Text Content -->
    <div class="flex-1" data-aos="fade-right">
      <p class="text-sm font-semibold text-amber-800 mb-3" data-aos="fade-down" data-aos-delay="100">
        {{ $texts['about_badge'] }}
      </p>

      <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6" data-aos="fade-up" data-aos-delay="200">
        {{ $texts['about_title_part1'] }} <span class="text-primary">{{ $texts['about_title_part2'] }}</span>
      </h2>

      <p class="text-gray-700 text-sm md:text-lg leading-relaxed mb-6" data-aos="fade-up" data-aos-delay="300">
        {{ $texts['about_desc1'] }}
      </p>

      <p class="text-gray-700 text-sm md:text-lg leading-relaxed mb-8" data-aos="fade-up" data-aos-delay="400">
        {{ $texts['about_desc2'] }}
      </p>

      <div class="grid grid-cols-2 gap-6 mb-10" data-aos="zoom-in" data-aos-delay="500">
        <div class="flex items-start space-x-3">
          <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary">
            <i class="fa-solid fa-mug-hot text-white text-lg"></i>
          </div>
          <div>
            <h4 class="font-semibold text-sm text-gray-900">{{ $texts['feature_coffee_title'] }}</h4>
            <p class="text-sm text-gray-600">{{ $texts['feature_coffee_desc'] }}</p>
          </div>
        </div>

        <div class="flex items-start space-x-3">
          <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary">
            <i class="fa-solid fa-leaf text-white text-lg"></i>
          </div>
          <div>
            <h4 class="font-semibold text-sm text-gray-900">{{ $texts['feature_nature_title'] }}</h4>
            <p class="text-sm text-gray-600">{{ $texts['feature_nature_desc'] }}</p>
          </div>
        </div>
      </div>

      <a href="/about" class="inline-block px-6 py-3 bg-secondary text-white font-semibold rounded-lg shadow hover:bg-primary transition">
        {{ $texts['learn_more'] }}
      </a>
    </div>

    <!-- Image Content -->
    <div class="flex-1 relative" data-aos="fade-down" data-aos-delay="400">
      <img src="images/headerpaket.webp" alt="Kopi Bali" class="rounded-2xl shadow-lg">
    </div>
  </div>
</section>



{{-- ============PAKET WISATA SECTION============ --}}
<section class="py-16 bg-white" id="paket">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Heading -->
    <div class="text-center mb-12" data-aos="fade-down">
      <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6">{!! $texts['paket_heading'] !!}</h2>
      <p class="text-sm md:text-lg text-gray-600 mt-2" data-aos="fade-up" data-aos-delay="100">
        {{ $texts['paket_description'] }}
      </p>
    </div>

    <!-- Grid Card -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  @foreach($pakets as $index => $paket)
    <div 
      class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden"
      data-aos="zoom-in-up"
      data-aos-delay="{{ 100 * $index }}"
    >
      <div class="relative">
        <img src="{{ asset('storage/' . $paket->main_image) }}" 
            alt="{{ is_array($paket->title) ? $paket->title[$lang] ?? '' : $paket->title }}" 
            class="w-full h-72 object-cover">
      </div>

      <div class="p-4">
        <p class="text-sm text-gray-500">
          <i class="fa-solid fa-location-dot mr-1 text-green-600"></i>
          {{ $paket->location }}
        </p>

        <h3 class="font-semibold text-xl text-gray-900 mt-1">
          {{ is_array($paket->title) ? $paket->title[$lang] ?? '' : $paket->title }}
        </h3>

        <div class="flex items-center gap-4 text-xs text-gray-500 mt-2">
          <span><i class="fa-regular fa-clock mr-1"></i> {{ $paket->duration }}</span>
          <span><i class="fa-solid fa-users mr-1"></i> Max {{ $paket->max_person }} {{ $texts['mak_person'] }}</span>
          {{ optional($paket->category)->name[$lang] ?? '-' }}
        </div>
        
        @php
            $fasilitas = is_array($paket->fasilitas) ? ($paket->fasilitas[$lang] ?? []) : [];
            $limit = 3;
            $countOthers = count($fasilitas) - $limit;
        @endphp

        <div class="flex flex-wrap gap-2 mb-4 mt-3">
            @foreach(array_slice($fasilitas, 0, $limit) as $item)
                <span class="px-3 py-1 bg-gray-100 text-xs rounded-full">{{ $item }}</span>
            @endforeach

            @if($countOthers > 0)
                <span class="px-3 py-1 bg-gray-100 text-xs rounded-full">+{{ $countOthers }} {{ $texts['fasilitas'] }}</span>
            @endif
        </div>


        <p class="text-lg font-bold text-gray-900 mt-3">
          Rp {{ number_format($paket->price, 0, ',', '.') }}
          <span class="text-sm font-normal"></span>
        </p>

        <div class="flex items-center gap-3 mt-4">
          <a href="#"
            class="flex-2 text-sm text-center px-3 block bg-secondary text-white py-2 rounded-lg hover:bg-amber-900 transition"
          >
            {{ $texts['tombol_booking'] }}
          </a>

          <a href="{{ route('paket.detail', ['slug' => str(is_array($paket->title) ? $paket->title[$lang] : $paket->title)->slug()]) }}"
            class="flex-1 text-sm text-center px-3 block bg-white border border-gray-300 text-gray-900 py-2 rounded-lg hover:bg-gray-100 transition"
          >
            {{ $texts['tombol_detail'] }}
          </a>
        </div>
      </div>
    </div>
  @endforeach
</div>
  </div>
</section>


{{-- ============EXPLORE PUPUAN SECTION============ --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

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



{{-- ============CTA HOME SECTION============ --}}
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


{{-- ============GALERRY HOME SECTION============ --}}
<section class="bg-[#f9f7f4] py-16 min-h-screen" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
  <div class="max-w-6xl mx-auto px-6">
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



{{-- ============ARTICLE HOME SECTION============ --}}
@php
    $lang = app()->getLocale() ?? 'id';
@endphp

<section class="bg-white py-16 ">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Heading -->
    <h2 class="text-2xl text-center md:text-4xl font-extrabold text-secondary leading-snug mb-6"
        data-aos="fade-up"
        data-aos-duration="1000">
        {{ $texts['article_heading'] }}
    </h2>
    <p class="md:text-lg text-sm text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">
        {{ $texts['article_description'] }}
    </p>

    <!-- Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-14">
    @foreach ($blogs as $index => $blog)
        <div class="bg-white rounded-xl shadow-lg transition duration-300 hover:shadow-2xl overflow-hidden"
             data-aos="fade-up"
             data-aos-delay="{{ $index * 150 }}"
             data-aos-duration="1000"
             data-aos-easing="ease-in-out">

            <img src="{{ $blog->main_image ? asset('storage/' . $blog->main_image) : 'https://picsum.photos/400/250?random=' . $index }}" 
                 alt="{{ $blog->title[$lang] ?? '' }}" 
                 class="w-full h-56 object-cover aspect-video">

            <div class="p-6">
                <div class="flex flex-wrap items-center text-xs font-medium text-gray-500 mb-3 space-x-3">
                    
                   
                    <span class="bg-secondary/10 text-secondary px-2 py-0.5 rounded-full uppercase tracking-wider">
                        {{ $texts['article_type'] }}
                    </span>
                    
                    
                    <span class="text-gray-400">•</span>
                    <span>{{ $blog->created_at->format('d M Y') }}</span>
                </div>

                <h3 class="text-md font-semibold text-gray-700 leading-snug"
                    data-aos="fade-right"
                    data-aos-delay="{{ 100 + $index * 150 }}"
                    data-aos-duration="900">
                  {{ $blog->title[$lang] ?? '' }}
                </h3>

                <p class="text-base md:text-md text-sm text-gray-600 mt-3 mb-4"
                   data-aos="fade-up"
                   data-aos-delay="{{ 200 + $index * 150 }}"
                   data-aos-duration="1000">
                  {{ Str::limit($blog->description[$lang] ?? '', 120) }}
                </p>

                <a href="{{ route('article.detail', ['slug' => Str::slug($blog->title[$lang] ?? '')]) }}"
                   class="inline-flex items-center text-sm font-semibold text-secondary hover:text-amber-900 transition"
                   data-aos="zoom-in"
                   data-aos-delay="{{ 300 + $index * 150 }}"
                   data-aos-duration="800">
                  {{ $lang === 'id' ? 'Baca Selengkapnya →' : 'Read More →' }}
                </a>
            </div>
        </div>
    @endforeach
</div>
  </div>
</section>


{{-- ============CONTACT HOME SECTION============ --}}
<section class="py-20 bg-[#f9f7f4] text-gray-800" id="contact">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12">

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