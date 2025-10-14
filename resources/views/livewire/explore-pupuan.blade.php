<div>
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
  data-aos="fade-zoom-in"
  data-aos-duration="1200"
  data-aos-easing="ease-in-out"
  data-aos-once="true">

  <!-- Background Image -->
  <img src="/images/gambarheader.jpg" 
       alt="Explore Pupuan Background" 
       class="absolute inset-0 w-full h-full object-cover"
       data-aos="zoom-out"
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/40 to-black/40"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <!-- Sub Heading -->
    <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
      {{ $texts['small'] }}
    </p>

    <!-- Title -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      {{ $texts['heading'] }}
      @if(!empty($texts['highlight']))
        <span class="text-primary">{{ $texts['highlight'] }}</span>
      @endif
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {{ $texts['description'] }}
    </p>
  </div>
</section>


<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
    
    <!-- Text Content -->
    <div data-aos="fade-right" data-aos-duration="1000">
      <p class="text-sm font-semibold text-amber-800 mb-3" data-aos="fade-down" data-aos-delay="100">
          {{ $texts['about_explore_small'] }}
      </p>
      <h2 class="text-3xl md:text-4xl font-extrabold text-secondary leading-snug mb-6" 
          data-aos="fade-up" data-aos-delay="200">
          {{ $texts['about_explore_heading'] }} 
          <span class="text-primary">{{ $texts['about_explore_highlight'] }}</span> 
          {{ $texts['about_explore_heading_suffix'] }}
      </h2>
      <p class="text-gray-700 mb-6 leading-relaxed" data-aos="fade-up" data-aos-delay="300">
          {!! $texts['about_explore_paragraph1'] !!}
      </p>
      <p class="text-gray-700 mb-10 leading-relaxed" data-aos="fade-up" data-aos-delay="400">
          {!! $texts['about_explore_paragraph2'] !!}
      </p>
  </div>


    <!-- Image -->
    <div class="relative" data-aos="fade-left" data-aos-duration="1000">
      <img src="/images/about.jpeg" alt="Explore Pupuan" 
           class="rounded-2xl shadow-lg object-cover">
      
      <div class="absolute top-4 right-4 bg-white shadow rounded-lg px-4 py-2 text-center" 
           data-aos="zoom-in" data-aos-delay="500">
        <span class="block text-lg font-bold text-yellow-600">100%</span>
        <span class="text-xs text-gray-500">Natural</span>
      </div>

      <div class="absolute bottom-4 left-4 bg-white shadow rounded-lg px-4 py-2 flex items-center space-x-2"
           data-aos="zoom-in" data-aos-delay="600">
        <i class="fas fa-heart text-red-500"></i>
        <span class="text-sm font-medium">Traveler's Choice</span>
      </div>
    </div>

  </div>
</section>


<section class="py-20 bg-[#f9f7f4]">
  <div class="max-w-6xl mx-auto px-6 text-center">
    
    <!-- Heading -->
    <h2 class="text-3xl text-secondary font-bold mb-4" data-aos="fade-down" data-aos-duration="1000">
      {{ $texts['why_explore_title'] }}
    </h2>
    <p class="text-gray-600 max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
      {{ $texts['why_explore_desc'] }}
    </p>

    <!-- Grid Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      
      <!-- Card 1 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up" data-aos-delay="300">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-mountain text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['card1_title'] }}</h3>
        <p class="text-gray-600 text-sm">
          {{ $texts['card1_desc'] }}
        </p>
      </div>

      <!-- Card 2 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up" data-aos-delay="400">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-mug-hot text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['card2_title'] }}</h3>
        <p class="text-gray-600 text-sm">
          {{ $texts['card2_desc'] }}
        </p>
      </div>

      <!-- Card 3 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up" data-aos-delay="500">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-leaf text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['card3_title'] }}</h3>
        <p class="text-gray-600 text-sm">
          {{ $texts['card3_desc'] }}
        </p>
      </div>

      <!-- Card 4 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition" data-aos="fade-up" data-aos-delay="600">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-users text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['card4_title'] }}</h3>
        <p class="text-gray-600 text-sm">
          {{ $texts['card4_desc'] }}
        </p>
      </div>

    </div>
  </div>
</section>


<section class="py-16 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 text-center">

    <!-- Headline -->
    <h2 class="text-3xl text-secondary font-bold mb-4" data-aos="fade-down" data-aos-duration="1000">
      {{ $texts['headline']['title'] }}
    </h2>
    <p class="text-gray-700 mb-12 max-w-2xl mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
      {{ $texts['headline']['desc'] }}
    </p>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach ($texts['cards'] as $index => $card)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl overflow-hidden transition duration-300"
             data-aos="fade-up"
             data-aos-delay="{{ 300 + ($index * 100) }}">

          <img src="{{ $card['image'] }}" class="w-full h-56 object-cover" alt="{{ $card['title'] }}">

          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">{{ $card['title'] }}</h3>
            <p class="text-gray-600 text-sm mb-4">{{ $card['desc'] }}</p>
            <a href="#" class="text-primary font-medium hover:underline">
              {{ $texts['lihat_detail'] }}
            </a>
          </div>

        </div>
      @endforeach
    </div>

  </div>
</section>


<!-- Galeri Foto -->
<section class="py-16 bg-white pb-32">
  <div class="max-w-6xl mx-auto px-6 text-center mb-8">
      <h2 class="text-3xl font-bold text-secondary text-center" 
            data-aos="fade-down" data-aos-duration="1000">
            {{ $texts['gallery_heading'] }}
        </h2>
        <p class="text-gray-600 mb-10 text-center mt-2" 
           data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            {{ $texts['gallery_description'] }}
        </p>

    <!-- Masonry grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 auto-rows-fr">
      <img src="https://picsum.photos/400/400?random=1" 
           class="w-full h-full object-cover rounded-lg row-span-2"
           data-aos="zoom-in" data-aos-delay="100">
      <img src="https://picsum.photos/400/400?random=2" 
           class="w-full h-full object-cover rounded-lg"
           data-aos="zoom-in" data-aos-delay="200">
      <img src="https://picsum.photos/400/400?random=3" 
           class="w-full h-full object-cover rounded-lg row-span-2"
           data-aos="zoom-in" data-aos-delay="300">
      <img src="https://picsum.photos/400/400?random=4" 
           class="w-full h-full object-cover rounded-lg"
           data-aos="zoom-in" data-aos-delay="400">
      <img src="https://picsum.photos/400/400?random=5" 
           class="w-full h-full object-cover rounded-lg"
           data-aos="zoom-in" data-aos-delay="500">
      <img src="https://picsum.photos/400/400?random=6" 
           class="w-full h-full object-cover rounded-lg row-span-2"
           data-aos="zoom-in" data-aos-delay="600">
      <img src="https://picsum.photos/400/400?random=7" 
           class="w-full h-full object-cover rounded-lg"
           data-aos="zoom-in" data-aos-delay="700">
      <img src="https://picsum.photos/400/400?random=8" 
           class="w-full h-full object-cover rounded-lg"
           data-aos="zoom-in" data-aos-delay="800">
      <img src="https://picsum.photos/400/400?random=9" 
           class="w-full h-full object-cover rounded-lg"
           data-aos="zoom-in" data-aos-delay="900">
    </div>
  </div>
</section>


<!-- Tips & Itinerary Singkat -->
<section class="py-16 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 text-center mb-12" data-aos="fade-down" data-aos-duration="1000">
    <h2 class="text-3xl text-secondary font-bold">{{ $texts['tips_headline']['title'] }}</h2>
    <p class="text-gray-600 mt-2">{{ $texts['tips_headline']['desc'] }}</p>
  </div>

  <div class="max-w-5xl mx-auto grid gap-6 md:grid-cols-3">
    @foreach ($texts['tips_cards'] as $index => $card)
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1"
           data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
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
    <h2 class="text-3xl text-secondary md:text-4xl font-bold mb-4"
        data-aos="fade-down"
        data-aos-duration="800"
        data-aos-delay="100">
      {{ $texts['sudah_siap_jelajah'] }} <span class="text-primary">{{ $texts['pupuan'] }}</span>
    </h2>
    <p class="text-lg md:text-xl mb-8 text-gray-600"
       data-aos="fade-up"
       data-aos-duration="800"
       data-aos-delay="200">
      {{ $texts['pilih_paket'] }}
    </p>
    <a href="/paket-wisata" 
       class="inline-block px-8 py-4 bg-yellow-400 text-gray-900 font-semibold rounded-xl shadow-lg hover:bg-yellow-500 hover:scale-105 transform transition duration-300"
       data-aos="zoom-in"
       data-aos-duration="800"
       data-aos-delay="300">
      {{ $texts['lihat_paket'] }} <i class="fa-solid fa-arrow-right ml-2"></i>
    </a>
  </div>
</section>





</div>
