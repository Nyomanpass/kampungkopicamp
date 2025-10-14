<div class="">
  <!-- Hero Section -->
  <div class="relative w-screen h-screen overflow-hidden">
      <!-- Background Video -->
      <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-screen object-cover pointer-events-none">
          <source src="videos/header.mp4" type="video/mp4">
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
          <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6"
              data-aos="fade-up" data-aos-delay="400">
              {{ $texts['headline_part1'] }} <span class="text-primary">{{ $texts['headline_part2'] }}</span>
          </h1>

          <!-- Subheadline -->
          <p class="text-lg md:text-xl mb-8 max-w-2xl"
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

          <!-- Tombol CTA -->
          <div class="flex space-x-4 mb-16" data-aos="fade-up" data-aos-delay="1000">
              <a href="#paket" class="px-6 py-3 bg-primary text-black font-semibold rounded-lg hover:bg-secondary hover:text-white transition">
                  {{ $texts['cta_packages'] }}
              </a>
              <a href="#video" class="px-6 py-3 bg-white/20 border border-white rounded-lg font-semibold hover:bg-white/30 transition">
                  {{ $texts['cta_booking'] }}
              </a>
          </div>
      </div>
  </div>


  <!-- About Section -->
<section id="about" class="relative py-20 bg-white">
  <div class="container max-w-6xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12">
    
    <!-- Text Content -->
    <div class="flex-1" data-aos="fade-right">
      <p class="text-sm font-semibold text-amber-800 mb-3" data-aos="fade-down" data-aos-delay="100">
        {{ $texts['about_badge'] }}
      </p>

      <h2 class="text-3xl md:text-4xl font-extrabold text-secondary leading-snug mb-6" data-aos="fade-up" data-aos-delay="200">
        {{ $texts['about_title_part1'] }} <span class="text-primary">{{ $texts['about_title_part2'] }}</span>
      </h2>

      <p class="text-gray-700 leading-relaxed mb-6" data-aos="fade-up" data-aos-delay="300">
        {{ $texts['about_desc1'] }}
      </p>

      <p class="text-gray-700 leading-relaxed mb-8" data-aos="fade-up" data-aos-delay="400">
        {{ $texts['about_desc2'] }}
      </p>

      <div class="grid grid-cols-2 gap-6 mb-10" data-aos="zoom-in" data-aos-delay="500">
        <div class="flex items-start space-x-3">
          <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary">
            <i class="fa-solid fa-mug-hot text-white text-lg"></i>
          </div>
          <div>
            <h4 class="font-semibold text-gray-900">{{ $texts['feature_coffee_title'] }}</h4>
            <p class="text-sm text-gray-600">{{ $texts['feature_coffee_desc'] }}</p>
          </div>
        </div>

        <div class="flex items-start space-x-3">
          <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary">
            <i class="fa-solid fa-leaf text-white text-lg"></i>
          </div>
          <div>
            <h4 class="font-semibold text-gray-900">{{ $texts['feature_nature_title'] }}</h4>
            <p class="text-sm text-gray-600">{{ $texts['feature_nature_desc'] }}</p>
          </div>
        </div>
      </div>

      <a href="#more" class="inline-block px-6 py-3 bg-secondary text-white font-semibold rounded-lg shadow hover:bg-green-800 transition">
        {{ $texts['learn_more'] }}
      </a>
    </div>

    <!-- Image Content -->
    <div class="flex-1 relative" data-aos="fade-left" data-aos-delay="400">
      <img src="images/about.jpeg" alt="Kopi Bali" class="rounded-2xl shadow-lg">

      <div class="absolute top-6 right-6 bg-white shadow-md rounded-lg px-4 py-2 text-center" data-aos="zoom-in" data-aos-delay="600">
        <span class="block text-2xl">☕</span>
        <p class="font-bold text-lg">100%</p>
        <p class="text-sm text-gray-600">{{ $texts['organic'] }}</p>
      </div>

      <div class="absolute bottom-6 left-6 bg-white shadow-md rounded-lg px-4 py-3 text-center" data-aos="zoom-in" data-aos-delay="600">
        <span class="block text-2xl">❤️</span>
        <p class="font-bold">24/7</p>
        <p class="text-sm text-gray-600">{{ $texts['support'] }}</p>
      </div>
    </div>
  </div>
</section>



<section class="py-16 bg-white" id="paket">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Heading -->
    <div class="text-center mb-12" data-aos="fade-down">
      <h2 class="text-3xl text-secondary font-bold text-gray-900">{{ $texts['paket_heading'] }}</h2>
      <p class="text-lg text-gray-600 mt-2" data-aos="fade-up" data-aos-delay="100">
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

        <h3 class="font-semibold text-gray-900 mt-1">
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
            class="flex-2 text-center px-3 block bg-secondary text-white py-2 rounded-lg hover:bg-amber-900 transition"
          >
            {{ $texts['tombol_booking'] }}
          </a>

          <a href="{{ route('paket.detail', ['slug' => str(is_array($paket->title) ? $paket->title[$lang] : $paket->title)->slug()]) }}"
            class="flex-1 text-center px-3 block bg-white border border-gray-300 text-gray-900 py-2 rounded-lg hover:bg-gray-100 transition"
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


<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

    <!-- Grid Foto -->
    <div class="relative grid grid-cols-2 grid-rows-2 gap-2 rounded-2xl overflow-hidden" data-aos="zoom-in" data-aos-duration="1000">
      <img src="https://picsum.photos/400/400?random=1" class="w-full h-48 sm:h-64 object-cover" alt="foto">
      <img src="https://picsum.photos/400/400?random=2" class="w-full h-48 sm:h-64 object-cover" alt="foto">
      <img src="https://picsum.photos/400/400?random=3" class="w-full h-48 sm:h-64 object-cover" alt="foto">
      <img src="https://picsum.photos/400/400?random=4" class="w-full h-48 sm:h-64 object-cover" alt="foto">

      <!-- Badge -->
      <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur rounded-xl shadow px-4 py-2" data-aos="fade-up" data-aos-delay="300">
        <p class="text-xs text-gray-500 flex items-center">
          <i class="fa-solid fa-camera mr-2 text-amber-600"></i> {{ __('messages.photo_spots') }}
        </p>
        <p class="font-semibold text-gray-900">{{ __('messages.photo_count') }}</p>
        <p class="text-xs text-gray-500">{{ __('messages.photo_caption') }}</p>
      </div>
    </div>

    <!-- Konten Teks -->
    <div data-aos="fade-left" data-aos-duration="1200">
      <p class="text-sm font-semibold text-amber-800 mb-2">{{ __('messages.explore_title') }}</p>
      <h2 class="text-3xl font-bold text-secondary leading-snug mb-4">{{ __('messages.explore_heading') }}</h2>
      <p class="text-gray-600 mb-8">{{ __('messages.explore_description') }}</p>

      <!-- Destinasi List -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        @foreach([
          ['icon' => 'fa-water', 'title' => 'dest_air_terjun', 'time' => 'dest_air_terjun_time', 'desc' => 'dest_air_terjun_desc'],
          ['icon' => 'fa-mountain-sun', 'title' => 'dest_jatiluwih', 'time' => 'dest_jatiluwih_time', 'desc' => 'dest_jatiluwih_desc'],
          ['icon' => 'fa-tree', 'title' => 'dest_kopi', 'time' => 'dest_kopi_time', 'desc' => 'dest_kopi_desc'],
          ['icon' => 'fa-house-chimney-user', 'title' => 'dest_desa', 'time' => 'dest_desa_time', 'desc' => 'dest_desa_desc'],
        ] as $dest)
          <div class="flex items-start p-4 bg-white shadow rounded-xl" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 + 100 }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary mr-3">
              <i class="fa-solid {{ $dest['icon'] }} text-white text-lg"></i>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">
                {{ __('messages.' . $dest['title']) }}
                <span class="ml-2 text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">{{ __('messages.' . $dest['time']) }}</span>
              </h4>
              <p class="text-sm text-gray-600">{{ __('messages.' . $dest['desc']) }}</p>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Statistik -->
      <div class="flex gap-8" data-aos="zoom-in" data-aos-delay="200">
        <div>
          <h3 class="text-3xl font-bold text-secondary">25+</h3>
          <p class="text-sm text-gray-600">{{ __('messages.stat_destinasi') }}</p>
        </div>
        <div>
          <h3 class="text-3xl font-bold text-secondary">4.9</h3>
          <p class="text-sm text-gray-600">{{ __('messages.stat_rating') }}</p>
        </div>
        <div>
          <h3 class="text-3xl font-bold text-secondary">100%</h3>
          <p class="text-sm text-gray-600">{{ __('messages.stat_experience') }}</p>
        </div>
      </div>
    </div>

  </div>
</section>



<section class="relative h-[70vh] mb-10 bg-gray-900 overflow-hidden">
  <!-- Background image -->
  <div class="absolute inset-0">
    <img src="images/about.jpeg" 
         alt="{{ $texts['heading'] }}"
         class="w-full h-full object-cover scale-110"
         data-aos="zoom-out"
         data-aos-duration="2000">
    <div class="absolute inset-0 bg-black/50"></div> <!-- Overlay -->
  </div>

  <!-- Content -->
  <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-6">
    <h2 class="text-3xl md:text-5xl font-bold mb-4"
        data-aos="fade-up"
        data-aos-duration="1000"
        >
      {{ $texts['heading'] }}
    </h2>

    <p class="text-lg md:text-xl mb-6 opacity-90 max-w-2xl"
       data-aos="fade-up"
       data-aos-delay="300"
       data-aos-duration="1200"
      >
      {{ $texts['description'] }}
    </p>

    <a href="#booking"
       class="inline-block bg-secondary hover:bg-amber-700 text-white text-lg font-semibold px-8 py-4 rounded-xl shadow-lg transition"
       data-aos="flip-up"
       data-aos-delay="600"
       data-aos-duration="1000">
      <i class="fa-solid fa-mug-hot mr-2"></i> {{ $texts['cta_text'] }}
    </a>
  </div>
</section>


<section class="bg-[#f9f7f4] py-16 min-h-screen" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">
  <div class="max-w-6xl mx-auto px-6">
           <h2 class="text-3xl font-bold text-secondary text-center" 
            data-aos="fade-down" data-aos-duration="1000">
            {{ $texts['gallery_heading'] }}
        </h2>
        <p class="text-gray-600 mb-10 text-center mt-2" 
           data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            {{ $texts['gallery_description'] }}
        </p>

  

    <!-- Grid Layout Abstrak -->
    <div class="grid grid-cols-3 grid-rows-2 gap-2" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000">
         
      <!-- Foto besar kiri -->
      <div class="col-span-2 row-span-2" >
        <img src="https://picsum.photos/800/800?random=9" 
             alt="Suasana Camp" 
             class="w-full h-full object-cover rounded-2xl">
      </div>

      <!-- Foto kanan atas -->
      <div data-aos="fade-left" >
        <img src="https://picsum.photos/400/400?random=5" 
             alt="Kopi" 
             class="w-full h-full object-cover rounded-2xl" >
      </div>

      <!-- Foto kanan tengah -->
      <div data-aos="fade-left" >
        <img src="https://picsum.photos/400/400?random=6" 
             alt="Tenda" 
             class="w-full h-full object-cover rounded-2xl" >
      </div>

      <!-- Foto kanan bawah -->
      <div data-aos="fade-left" >
        <img src="https://picsum.photos/400/400?random=7" 
             alt="Wisata Alam" 
             class="w-full h-full object-cover rounded-2xl" >
      </div>

      <!-- Foto kanan tambahan -->
      <div data-aos="fade-up" >
        <img src="https://picsum.photos/400/400?random=8" 
             alt="Wisata Alam" 
             class="w-full h-full object-cover rounded-2xl" >
      </div>

      <div data-aos="fade-up">
        <img src="https://picsum.photos/400/400?random=9" 
             alt="Wisata Alam" 
             class="w-full h-full object-cover rounded-2xl" >
      </div>
    </div>
  </div>
</section>



{{-- article terbaru --}}
@php
    $lang = app()->getLocale() ?? 'id';
@endphp

<section class="bg-white py-16 ">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Heading -->
    <h2 class="text-3xl font-bold text-center text-secondary mb-2"
        data-aos="fade-up"
        data-aos-duration="1000">
        {{ $texts['article_heading'] }}
    </h2>
    <p class="text-lg text-center text-gray-600" data-aos="fade-up" data-aos-delay="100">
        {{ $texts['article_description'] }}
    </p>

    <!-- Grid -->
    <div class="grid md:grid-cols-3 gap-8 mt-14">
      @foreach ($blogs as $index => $blog)
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden"
             data-aos="fade-up"
             data-aos-delay="{{ $index * 150 }}"
             data-aos-duration="1000"
             data-aos-easing="ease-in-out">

          <!-- Gambar -->
          <img src="{{ $blog->main_image ? asset('storage/' . $blog->main_image) : 'https://picsum.photos/400/400?random=1' }}" 
               alt="{{ $blog->title[$lang] ?? '' }}" 
               class="w-full h-72 object-cover">

          <div class="p-5">
            <!-- Meta Info -->
            <div class="flex items-center text-xs text-gray-500 mb-2 space-x-2">
              <span class="bg-secondary/10 text-secondary px-2 py-0.5 rounded">
                {{ $texts['article_type'] }}
              </span>
              <span>{{ $blog->created_at->format('d M Y') }}</span>
              <span>•</span>
              <span>By {{ $blog->author[$lang] ?? 'Admin' }}</span>
              <span>•</span>
              <span>{{ $blog->read_time ?? '3 min' }} read</span>
            </div>

            <!-- Judul -->
            <h3 class="text-lg font-semibold text-gray-900 hover:text-amber-700 cursor-pointer"
                data-aos="fade-right"
                data-aos-delay="{{ 100 + $index * 150 }}"
                data-aos-duration="900">
              {{ $blog->title[$lang] ?? '' }}
            </h3>

            <!-- Excerpt -->
            <p class="text-sm text-gray-600 mt-2"
               data-aos="fade-up"
               data-aos-delay="{{ 200 + $index * 150 }}"
               data-aos-duration="1000">
              {{ Str::limit($blog->description[$lang] ?? '', 100) }}
            </p>

            <!-- CTA -->
            <a href="{{ route('article.detail', ['slug' => Str::slug($blog->title[$lang] ?? '')]) }}"
               class="mt-3 inline-block text-sm font-medium text-secondary hover:text-amber-900"
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
    <div class="bg-white p-6 rounded-2xl shadow" 
         data-aos="fade-left" 
         data-aos-duration="1000" 
         data-aos-offset="200">
      <h3 class="flex items-center text-lg font-semibold mb-4 text-gray-900">
        <i class="fa-solid fa-map text-secondary mr-2"></i> {{ $texts['location_heading'] }}
      </h3>
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7895.1750634993!2d115.03386611055907!3d-8.343715401760706!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd229a2ecb99547%3A0x8a1a833f13b4a85b!2sKampung%20Kopi%20Camp!5e0!3m2!1sid!2sid!4v1759163429473!5m2!1sid!2sid" 
        class="w-full h-[90%] rounded-lg"
        style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>

  </div>
</section>



</div>