<div>

   <section 
  class="relative w-full h-[55vh] flex items-center justify-center text-center text-white overflow-hidden"
  data-aos="fade-zoom-in"
  data-aos-duration="1200"
  data-aos-easing="ease-in-out"
  data-aos-once="true">

  <!-- Background -->
  <img src="/images/gambarheader.jpg" 
       alt="Detail Paket Wisata" 
       class="absolute inset-0 w-full h-full object-cover"
       data-aos="zoom-out"
       data-aos-duration="1000">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/40"></div>

  <!-- Content -->
  <div class="relative z-10 px-6" data-aos="fade-up" data-aos-delay="300">
    <!-- Sub Heading -->
    <p class="uppercase text-white mb-3 tracking-wide" data-aos="fade-down" data-aos-delay="400">
      {!! $texts['detail_paket_subheading'] !!}
    </p>

    <!-- Title -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-6" data-aos="fade-up" data-aos-delay="600">
      {!! $texts['detail_paket_title'] !!}
    </h1>

    <!-- Decorative Line -->
    <div class="w-24 h-1 bg-white mx-auto mb-6 rounded-full" data-aos="zoom-in" data-aos-delay="800"></div>

    <!-- Description -->
    <p class="text-lg max-w-2xl mx-auto leading-relaxed text-gray-100" data-aos="fade-up" data-aos-delay="1000">
      {!! $texts['detail_paket_description'] !!}
    </p>
</div>

</section>

<div class="max-w-6xl mx-auto py-20 px-6 grid grid-cols-1 md:grid-cols-2 gap-12">

  <!-- Gallery -->
  <div class="order-2 md:order-1" 
     x-data="{ mainImage: '{{ asset('storage/' . $paket->main_image) }}' }">
    <!-- Gambar Utama -->
    <div class="relative overflow-hidden rounded-2xl shadow-lg">
      <img :src="mainImage"
           
           class="w-full h-96 object-cover hover:scale-105 transition duration-500">
      {{-- <span class="absolute top-4 left-4 bg-green-600 text-white text-sm font-semibold px-3 py-1 rounded-full shadow">
        Best Seller
      </span> --}}
    </div>

    <!-- Thumbnails -->
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 gap-3 mt-4">
      @foreach ($paket->gallery as $img)
        <img 
          src="{{ asset('storage/' . $img) }}"
          @click="mainImage = '{{ asset('storage/' . $img) }}'"
          class="w-full h-24 object-cover rounded-lg cursor-pointer hover:ring-2 hover:ring-secondary transition">
      @endforeach
    </div>


   @php
    $fasilitas = $paket->fasilitas[$lang] ?? [];
@endphp

<div class="hidden md:block mt-10">
    <h4 class="text-2xl font-bold mb-3 text-gray-700">{{ $texts['fasilitas_dua'] }}</h4>
    <ul class="list-disc list-inside text-gray-600 space-y-1">
        @foreach ($fasilitas as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
</div>




  </div>

  <!-- Detail kanan -->
    <div class="order-1 md:order-2">
      <h1 class="text-3xl font-extrabold text-gray-900 mb-3">
    {{ is_array($paket->title) ? ($paket->title[$lang] ?? '') : $paket->title }}

      </h1>
     <p class="text-gray-600 mb-6 flex items-center gap-2">
          <i class="fa-solid fa-map-marker-alt text-secondary"></i> 
          {{ $paket->location }} | {{ optional($paket->category)->name[$lang] ?? '-' }}
      </p>


      <div class="bg-white border-2 border-gray-100 rounded-2xl p-6 shadow-xl">
        <p class="text-3xl font-extrabold text-primary mb-4">
          Rp {{ number_format($paket->price, 0, ',', '.') }} 
        </p>

        <p class="text-gray-600 text-sm flex items-center gap-2 mb-4">
            <i class="fa-solid fa-user-group"></i>
            Max {{ $paket->max_person }} {{ $texts['mak_person'] }}
        </p>

         <p class="text-gray-600 text-sm flex items-center gap-2 mb-4">
            <i class="fa-solid fa-clock"></i>
            {{ $paket->duration }} 
        </p>
      
        <div class="flex items-center gap-2 mb-6">
          <input type="number" value="1" min="1" 
                class="border rounded-lg px-3 py-2 w-24 focus:ring-2 focus:ring-secondary outline-none">
        </div>

        <p class="text-lg font-semibold text-gray-800 flex items-center gap-2">
          <i class="fa-solid fa-wallet text-primary"></i>
          Total: <span class="text-secondary font-bold">
            Rp {{ number_format($paket->price, 0, ',', '.') }}
          </span>
        </p>

        <button
          class="mt-6 w-full bg-secondary text-white py-3 rounded-xl font-semibold 
                shadow-lg hover:scale-[1.02] transition flex items-center justify-center gap-2">
         {{ $texts['tombol_booking'] }}
        </button>
      </div>

      <!-- Tentang Paket -->
      <div class="mt-12 text-gray-700">
        <h2 class="text-2xl font-bold mb-4">{{ $texts['about_paket'] }}</h2>
        <p class="leading-relaxed mb-6">
          {{ is_array($paket->description) ? ($paket->description[$lang] ?? '') : $paket->description }}

        </p>



         @php
         $fasilitas = $paket->fasilitas[$lang] ?? [];
         @endphp

      <div class="md:hidden block mt-10">
          <h4 class="text-2xl font-bold mb-3 text-gray-700">{{ $texts['fasilitas_dua'] }}</h4>
          <ul class="list-disc list-inside text-gray-600 space-y-1">
              @foreach ($fasilitas as $item)
                  <li>{{ $item }}</li>
              @endforeach
          </ul>
      </div>


        @if (optional($paket->category)->name !== 'activity')
        <!-- Konfirmasi Reservasi -->
          <div class="text-gray-900 py-6 rounded-2xl">
            <h4 class="text-xl font-bold mb-3 text-gray-700">{{ $texts['reservation_confirmation_title'] }}</h4>
            <ul class="space-y-2">
              <li>✅ {{ str_replace(':time', '14:00', $texts['checkin_time']) }}</li>
              <li>✅ {{ str_replace(':time', '12:00', $texts['checkout_time']) }}</li>
            </ul>
            <p class="mt-4 text-sm text-secondary">
              {{ $texts['show_reservation_proof'] }}
            </p>
        </div>

        @endif

      </div>

  </div>


</div>

</div>
