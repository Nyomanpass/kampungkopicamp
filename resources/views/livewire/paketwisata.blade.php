<div>
<!-- Hero Section Paket Wisata -->
<section 
  class="relative w-full h-[60vh] flex items-center justify-center text-center text-white overflow-hidden" 
  data-aos="fade-zoom-in" 
  data-aos-duration="1200" 
  data-aos-easing="ease-in-out" 
  data-aos-once="true">

  <!-- Background -->
  <img src="/images/headerpaketwisata.webp" 
       alt="Paket Wisata Background" 
       class="absolute inset-0 w-full h-full object-cover" 
       data-aos="zoom-out" 
       data-aos-duration="1000">

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

    <p id="paket-wisata" class="text-sm md:text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {!! $texts['description'] !!}
    </p>
</div>

</section>

<div class="flex justify-center flex-wrap gap-4 mt-10">

    <button 
        wire:click="filterPackages('all')"
        class="flex items-center gap-2 px-6 py-3 rounded-full border font-medium text-sm md:text-base transition-all duration-300
               {{ $activeCategory === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
        <i class="fa-solid fa-layer-group"></i>
       {!! $texts['filter_paket'] !!}
    </button>

        @foreach($categories as $cat)
    <button 
        wire:click="filterPackages('{{ $cat['id'] }}')"
        class="flex items-center gap-2 px-6 py-3 rounded-full border font-medium text-sm md:text-base transition-all duration-300
              {{ $activeCategory == $cat['id'] ? 'bg-secondary text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
        {{ $cat['name'][$lang] ?? '' }}
    </button>
    @endforeach



</div>

<section class="py-16">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

      @foreach ($filteredProducts as $index => $product)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-2 overflow-hidden"
             data-aos="fade-up"
             data-aos-delay="{{ $index * 100 }}">
          <!-- Gambar -->
          <div class="relative">
            <img src="{{ asset('storage/' . ($product['main_image'] ?? 'placeholder.jpg')) }}" 
                alt="{{ is_array($product['name']) ? ($product['name'][$lang] ?? '') : $product['name'] }}" 
                class="w-full h-70 object-cover">
        
          </div>

          <!-- Konten Paket -->
          <div class="p-6">
            <p class="text-sm text-gray-600 flex items-center gap-2 mb-2">
              <i class="fa-solid fa-map-marker-alt text-green-600"></i>
              Pupuan, Tabanan
            </p>

            <h3 class="text-lg font-bold text-gray-800 mb-3">
              {{ is_array($product['title']) ? ($product['title'][$lang] ?? '') : $product['title'] }}
            </h3>

            <div class="flex items-center gap-4 text-xs text-gray-500 mt-2">
              <span><i class="fa-regular fa-clock mr-1"></i> {{ $product->duration }}</span>
              <span><i class="fa-solid fa-users mr-1"></i> Max {{ $product->max_person }} {{ $texts['mak_person'] }}</span>
              {{ optional($product->category)->name[$lang] ?? '-' }}
            </div>

            @php
                $fasilitas = is_array($product['fasilitas']) ? ($product['fasilitas'][$lang] ?? []) : [];
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


            <div class="mb-5">
              <p class="text-xl font-bold text-brown-700">
                Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }} 
                <span class="text-sm text-gray-500"></span>
              </p>
            </div>

            <div class="flex items-center gap-3 mt-4">
              <a href="#"
                class="flex-2 text-center px-3 block bg-secondary text-white py-2 rounded-lg hover:bg-amber-900 transition">
                 {{ $texts['tombol_booking'] }}
              </a>

              <a href="{{ route('paket.detail', ['slug' => str(is_array($product['title']) ? ($product['title'][$lang] ?? '') : $product['title'])->slug()]) }}"
                class="flex-1 text-center px-3 block bg-white border border-gray-300 text-gray-900 py-2 rounded-lg hover:bg-gray-100 transition">
                 {{ $texts['tombol_detail'] }}
              </a>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>


<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto px-6 text-center mb-12">
    <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6"
        data-aos="fade-down"
        data-aos-duration="800"
        data-aos-delay="100">
     {{ $texts['how_to_order_heading'] }}
    </h2>
    <p class="text-gray-600 mb-10 text-sm md:text-lg"
      data-aos="fade-up"
      data-aos-duration="800"
      data-aos-delay="200">
      {{ $texts['how_to_order_description'] }}
    </p>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8">
    @foreach ($texts['how_to_order_steps'] as $index => $step)
    
    <div class="flex flex-col items-center text-center">
        
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary text-white font-bold text-lg mb-4 flex-shrink-0 md:mb-6">
            {{ $index + 1 }}
        </div>
        
        <h3 class="text-md font-semibold text-gray-900 mb-2">
            {{ $step['title'] }}
        </h3>
        
        <p class="text-base text-sm md:px-2 px-8 text-gray-600">
            {{ $step['desc'] }}
        </p>
    </div>
    @endforeach
</div>
    
  </div>
</section>


<section class="bg-light py-20 mt-10">
  <div class="max-w-4xl mx-auto text-center px-6">
    <h2 class="text-2xl md:text-4xl font-extrabold text-secondary leading-snug mb-6"
        data-aos="fade-down"
        data-aos-duration="800"
        data-aos-delay="100">
      {!! $texts['custom_package_heading'] !!}
    </h2>
    <p class="text-gray-600 md:text-lg mb-8 text-sm"
       data-aos="fade-up"
       data-aos-duration="800"
       data-aos-delay="200">
      {{ $texts['custom_package_description'] }}
    </p>
    <div class="flex flex-col md:flex-row items-center justify-center gap-4"
         data-aos="zoom-in"
         data-aos-duration="800"
         data-aos-delay="300">
      <a href="https://wa.me/6281234567890" target="_blank"
         class="px-8 py-3 bg-secondary text-white font-semibold rounded-xl shadow-lg hover:bg-primary transform hover:scale-103 transition duration-300">
         {{ $texts['custom_package_button'] }}
      </a>
    </div>
  </div>
</section>




</div>
