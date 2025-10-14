<div>
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden" 
  data-aos="fade-zoom-in" 
  data-aos-duration="1200" 
  data-aos-easing="ease-in-out" 
  data-aos-once="true">

  <!-- Background -->
  <img src="/images/gambarheader.jpg" 
       alt="Kopi Background" 
       class="absolute inset-0 w-full h-full object-cover" 
       data-aos="zoom-out" 
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <p class="text-white mb-3 uppercase tracking-wide" data-aos="fade-down" data-aos-delay="400">
      {{ $texts['small'] }}
    </p>

    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      {!! $texts['heading'] !!}
    </h1>

    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <p class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {{ $texts['description'] }}
    </p>
  </div>
</section>




<section class="py-20 bg-white text-gray-800">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Bagian Judul -->
    <div data-aos="fade-up" data-aos-duration="800">
    <p class="text-sm font-semibold text-amber-800 mb-3">
        {{ $texts['about_small'] }}
    </p>

    <h2 class="text-4xl font-extrabold text-secondary mb-4">
        {!! $texts['about_heading'] !!}
    </h2>

    <p class="text-lg max-w-4xl text-gray-600 mb-6">
        {{ $texts['about_description'] }}
    </p>
</div>


    <!-- Grid Gambar -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Gambar 1 -->
      <div 
        class="relative rounded-xl overflow-hidden shadow-lg h-[500px]" 
        data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000">
        <img src="/images/about.jpeg" alt="kopi camp" class="w-full h-full object-cover">
      </div>

      <!-- Gambar 2 -->
      <div 
        class="relative rounded-xl overflow-hidden shadow-lg h-[500px]" 
        data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000">
        <img src="/images/kecak-dance.jpg" alt="Uluwatu Kecak Dance" class="w-full h-full object-cover">
      </div>

      <!-- Dua Gambar Kecil -->
      <div class="grid grid-rows-2 gap-6">
        <div 
          class="relative rounded-xl overflow-hidden shadow-lg"
          data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
          <img src="/images/labuan-sait.jpg" alt="Labuan Sait Beach" class="w-full h-56 object-cover">
        </div>

        <div 
          class="relative rounded-xl overflow-hidden shadow-lg"
          data-aos="fade-left" data-aos-delay="400" data-aos-duration="1000">
          <img src="/images/about.jpeg" alt="Conservation & Wildlife" class="w-full h-56 object-cover">
        </div>
      </div>
    </div>
  </div>
</section>


<section class="py-20 bg-white text-gray-800">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    
    <!-- Bagian Teks -->
    <div data-aos="fade-right" data-aos-duration="1000">
    <p class="text-sm font-semibold text-amber-800 mb-3">
        {{ $texts['story_small'] }}
    </p>

    <h2 class="text-4xl text-secondary font-extrabold mb-4">
        {!! $texts['story_heading'] !!}
    </h2>

    <p class="text-lg text-gray-600 font-medium mb-6">
        {{ $texts['story_subheading'] }}
    </p>

    <p class="text-gray-700 leading-relaxed mb-4">
        {{ $texts['story_paragraph1'] }}
    </p>
    <p class="text-gray-700 leading-relaxed">
        {{ $texts['story_paragraph2'] }}
    </p>
</div>


    <!-- Bagian Gambar -->
    <div class="grid grid-cols-2 gap-5" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1000">
      <img src="/images/aboutheader.jpg" alt="Homestay Kampung Kopi" 
           class="rounded-2xl shadow-lg object-cover h-64 w-full hover:scale-105 transition-transform duration-500">
      <img src="/images/aboutheader.jpg" alt="Kopi Pupuan" 
           class="rounded-2xl shadow-lg object-cover h-64 w-full mt-6 hover:scale-105 transition-transform duration-500">
    </div>

  </div>
</section>

<section class="py-20 bg-[#f9f7f4]">
  <div class="max-w-6xl mx-auto px-6 text-center">
    
    <!-- Heading -->
    <div data-aos="fade-up" data-aos-duration="1000">
      <h2 class="text-3xl text-secondary font-bold mb-4">{{ $texts['value_heading'] }}</h2>
      <p class="text-gray-600 max-w-2xl mx-auto mb-12">{{ $texts['value_description'] }}</p>
    </div>

    <!-- Grid Nilai -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      
      <!-- Card 1 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition"
           data-aos="fade-up" data-aos-delay="100" data-aos-duration="900">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-mug-hot text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['value_card1_title'] }}</h3>
        <p class="text-gray-600 text-sm">{{ $texts['value_card1_desc'] }}</p>
      </div>

      <!-- Card 2 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition"
           data-aos="fade-up" data-aos-delay="200" data-aos-duration="900">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-users text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['value_card2_title'] }}</h3>
        <p class="text-gray-600 text-sm">{{ $texts['value_card2_desc'] }}</p>
      </div>

      <!-- Card 3 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition"
           data-aos="fade-up" data-aos-delay="300" data-aos-duration="900">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-award text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['value_card3_title'] }}</h3>
        <p class="text-gray-600 text-sm">{{ $texts['value_card3_desc'] }}</p>
      </div>

      <!-- Card 4 -->
      <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition"
           data-aos="fade-up" data-aos-delay="400" data-aos-duration="900">
        <div class="flex justify-center mb-4">
          <div class="w-12 h-12 flex items-center justify-center bg-primary rounded-full">
            <i class="fa-solid fa-leaf text-white text-xl"></i>
          </div>
        </div>
        <h3 class="font-semibold text-lg mb-2">{{ $texts['value_card4_title'] }}</h3>
        <p class="text-gray-600 text-sm">{{ $texts['value_card4_desc'] }}</p>
      </div>

    </div>
  </div>
</section>


<!-- Perjalanan Kami -->
<section class="py-20 bg-white">
  <div class="max-w-5xl mx-auto px-6">
    
    <!-- Heading -->
    <div data-aos="fade-up" data-aos-duration="1000">
      <h2 class="text-3xl text-secondary font-bold text-center mb-4">{{ $texts['journey_heading'] }}</h2>
      <p class="text-gray-600 text-center mb-12">{{ $texts['journey_description'] }}</p>
    </div>

    <!-- Timeline -->
    <div class="relative border-l-2 border-amber-200" data-aos="fade-up" data-aos-duration="1200">
      @foreach ($texts['journey'] as $item)
      <div class="mb-10 ml-6" data-aos="fade-right" data-aos-delay="{{ $loop->iteration * 100 }}">
        <span class="absolute -left-9 flex items-center justify-center w-14 h-14 rounded-full bg-primary text-white font-bold">
          {{ $item['year'] }}
        </span>
        <div class="bg-[#f9f7f4] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="font-semibold">{{ $item['title'] }}</h3>
          <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>


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


<section class="pb-32 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <!-- Heading -->
    <h2 class="text-3xl text-secondary font-bold text-center mb-4" 
        data-aos="fade-down" data-aos-duration="1000">
      {{ $texts['testimonial_heading'] }}
    </h2>
    <p class="text-gray-600 text-center mb-12" 
       data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
      {{ $texts['testimonial_description'] }}
    </p>

    <!-- Grid Testimonial -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($texts['testimonials'] as $index => $testimonial)
        <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-secondary"
             data-aos="fade-up" data-aos-delay="{{ 300 + ($index * 100) }}">
            <i class="fa-solid fa-quote-left text-2xl text-secondary mb-4"></i>
            <p class="text-gray-700 italic mb-6">{!! $testimonial['quote'] !!}</p>
            <div class="flex items-center">
                <img class="w-12 h-12 rounded-full object-cover mr-4" 
                     src="https://placehold.co/100x100/A0A0A0/FFFFFF?text={{ substr($testimonial['name'], 0, 1) }}" 
                     alt="Avatar {{ $testimonial['name'] }}">
                <div>
                    <p class="font-semibold text-gray-800">{{ $testimonial['name'] }}</p>
                    <p class="text-sm text-gray-500">{{ $testimonial['role'] }}</p>
                </div>
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
