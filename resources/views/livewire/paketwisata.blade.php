<div>
<!-- Hero Section Paket Wisata -->
<section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden" 
  data-aos="fade-zoom-in" 
  data-aos-duration="1200" 
  data-aos-easing="ease-in-out" 
  data-aos-once="true">

  <!-- Background -->
  <img src="/images/gambarheader.jpg" 
       alt="Paket Wisata Background" 
       class="absolute inset-0 w-full h-full object-cover" 
       data-aos="zoom-out" 
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <p class="text-white mb-3 uppercase tracking-wide" data-aos="fade-down" data-aos-delay="400">
      Jelajahi Keindahan Pupuan
    </p>

    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      Paket Wisata
      <span class="text-primary">Kampung Kopi Camp</span>
    </h1>

    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <p id="paket-wisata" class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      Nikmati pengalaman unik dari tur kopi, homestay, hingga budaya lokal Bali yang autentik 
      bersama Kampung Kopi Camp.
    </p>
  </div>
</section>

<div class="flex justify-center flex-wrap gap-4 mt-10">

    <button 
        wire:click="filterPackages('all')"
        class="flex items-center gap-2 px-6 py-3 rounded-full border font-medium text-sm md:text-base transition-all duration-300
               {{ $activeCategory === 'all' ? 'bg-secondary text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
        <i class="fa-solid fa-layer-group"></i>
        Semua
    </button>

    @foreach($categories as $cat)
    <button 
        wire:click="filterPackages('{{ $cat['id'] }}')"
        class="flex items-center gap-2 px-6 py-3 rounded-full border font-medium text-sm md:text-base transition-all duration-300
               {{ $activeCategory == $cat['id'] ? 'bg-secondary text-white shadow-md' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
        {{ $cat['name'] }}
    </button>
    @endforeach
</div>


<section class="py-16"  >
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

      @foreach ($filteredProducts as $index => $product)
        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-2 overflow-hidden"
             data-aos="fade-up"
             data-aos-delay="{{ $index * 100 }}">
          <!-- Gambar -->
          <div class="relative">
            <img src="{{ asset('storage/' . $product['main_image']) }}" 
                alt="{{ $product['name'] }}" 
                class="w-full h-72 object-cover">
            
            @if ($product['is_popular'])
              <span class="absolute top-3 left-3 bg-yellow-500 text-xs font-semibold text-white px-3 py-1 rounded-full shadow">
                Populer
              </span>
            @endif

            <button class="absolute top-3 right-3 bg-white p-2 rounded-full shadow hover:bg-gray-100">
              <i class="fa-regular fa-heart text-gray-600"></i>
            </button>
          </div>

          <!-- Konten Paket -->
          <div class="p-6">
            <p class="text-sm text-gray-600 flex items-center gap-2 mb-2">
              <i class="fa-solid fa-map-marker-alt text-green-600"></i>
              Pupuan, Tabanan
            </p>

            <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $product['title'] }}</h3>

            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
              <span class="flex items-center gap-1"><i class="fa-regular fa-clock"></i> 2D1N</span>
              <span class="flex items-center gap-1"><i class="fa-solid fa-users"></i> Max 4 tamu</span>
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
              <span class="px-3 py-1 bg-gray-100 text-xs rounded-full">Glamping</span>
              <span class="px-3 py-1 bg-gray-100 text-xs rounded-full">Coffee Tour</span>
              <span class="px-3 py-1 bg-gray-100 text-xs rounded-full">+2 lainnya</span>
            </div>

            <div class="mb-5">
              <p class="text-xl font-bold text-brown-700">
                Rp {{ number_format($product['price'], 0, ',', '.') }} 
                <span class="text-sm text-gray-500">/ orang</span>
              </p>
            </div>

            <div class="flex items-center gap-3 mt-4">
              <a href="#"
                class="flex-2 text-center px-3 block bg-secondary text-white py-2 rounded-lg hover:bg-amber-900 transition">
                Pesan Sekarang
              </a>

              <a href="{{ route('paket.detail', ['slug' => str($product['title'])->slug()]) }}"
                class="flex-1 text-center px-3 block bg-white border border-gray-300 text-gray-900 py-2 rounded-lg hover:bg-gray-100 transition">
                Detail
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
    <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-3"
        data-aos="fade-down"
        data-aos-duration="800"
        data-aos-delay="100">
      Cara Memesan
    </h2>
    <p class="text-gray-600 mb-10"
      data-aos="fade-up"
      data-aos-duration="800"
      data-aos-delay="200">
      Ikuti langkah mudah ini untuk mendapatkan pengalaman wisata tak terlupakan
    </p>


    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
      @foreach ([
        ['title' => 'Pilih Paket', 'desc' => 'Pilih paket wisata yang sesuai dengan preferensi Anda'],
        ['title' => 'Jumlah Tiket / Orang', 'desc' => 'Tentukan jumlah tiket atau orang yang akan ikut'],
        ['title' => 'Konfirmasi Pembayaran', 'desc' => 'Hubungi kami via WhatsApp atau sistem pembayaran untuk konfirmasi'],
        ['title' => 'Dapatkan Tiket', 'desc' => 'Tiket akan dikirim via email dan notifikasi WhatsApp'],
        ['title' => 'Tunjukkan Tiket', 'desc' => 'Tunjukkan tiket di lokasi dan nikmati pengalaman wisata Anda']
      ] as $index => $step)
      <div class="flex flex-col items-center" 
           data-aos="fade-up"
           data-aos-delay="{{ $index * 150 }}">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-primary text-white font-bold text-lg mb-4">
          {{ $index + 1 }}
        </div>
        <h3 class="text-lg font-semibold mb-2">{{ $step['title'] }}</h3>
        <p class="text-gray-600 text-sm text-center">{{ $step['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>


<section class="bg-light py-20 mt-10">
  <div class="max-w-4xl mx-auto text-center px-6">
    <h2 class="text-3xl md:text-4xl font-bold text-secondary mb-4"
        data-aos="fade-down"
        data-aos-duration="800"
        data-aos-delay="100">
      Butuh Paket <span class="text-primary">Custom?</span>
    </h2>
    <p class="text-gray-600 text-lg mb-8"
       data-aos="fade-up"
       data-aos-duration="800"
       data-aos-delay="200">
      Kami dapat menyesuaikan paket wisata sesuai dengan kebutuhan dan preferensi Anda
    </p>
    <div class="flex flex-col md:flex-row items-center justify-center gap-4"
         data-aos="zoom-in"
         data-aos-duration="800"
         data-aos-delay="300">
      <a href="https://wa.me/6281234567890" target="_blank"
         class="px-8 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-xl shadow-lg hover:bg-amber-900 transform hover:scale-105 transition duration-300">
         Hubungi untuk Custom Package
      </a>
    </div>
  </div>
</section>



</div>
