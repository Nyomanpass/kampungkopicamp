<footer class="bg-secondary text-white pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-6 lg:px-14 grid grid-cols-1 md:grid-cols-4 gap-12">

    <!-- Logo & Deskripsi -->
    <div>
     <div class="flex items-center mb-4 space-x-2">
        <img src="/images/logo.png" alt="Logo" class="w-42 h-16">
    </div>
    <p class="text-sm mb-6 text-white">{{ $texts['desc'] }}</p>


      <!-- Sosmed -->
      <div class="flex space-x-4">
        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
          <i class="fab fa-instagram text-white text-lg"></i>
        </a>
        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
          <i class="fab fa-facebook-f text-white text-lg"></i>
        </a>
        <a href="#" class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
          <i class="fab fa-tiktok text-white text-lg"></i>
        </a>
      </div>
    </div>

    <!-- Quick Links -->
    <div>
      <h3 class="font-semibold text-lg mb-4">{{ $texts['quick_links'] }}</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="#" class="hover:text-white/40">Home</a></li>
        <li><a href="#" class="hover:text-white/40">About</a></li>
        <li><a href="#" class="hover:text-white/40">Paket Wisata</a></li>
        <li><a href="#" class="hover:text-white/40">Explore Pupuan</a></li>
        <li><a href="#" class="hover:text-white/40">Gallery</a></li>
        <li><a href="#" class="hover:text-white/40">Contact</a></li>
      </ul>
    </div>

    <!-- Kontak -->
    <div>
      <h3 class="font-semibold text-lg mb-4">{{ $texts['contact'] }}</h3>
      <ul class="space-y-4 text-sm">
        <li class="flex items-start">
          <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3 mt-1">
            <i class="fa-solid fa-location-dot"></i>
          </span>
          {!! nl2br(e($texts['address'])) !!}
        </li>
        <li class="flex items-center">
          <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
            <i class="fa-solid fa-phone"></i>
          </span>
          {{ $texts['phone'] }}
        </li>
        <li class="flex items-center">
          <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
            <i class="fa-solid fa-envelope"></i>
          </span>
          {{ $texts['email'] }}
        </li>
      </ul>
    </div>

    <!-- Jam Buka -->
    <div>
      <h3 class="font-semibold text-lg mb-4">{{ $texts['open_hours'] }}</h3>
      <ul class="space-y-2 text-sm">
        <li class="flex items-center">
          <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
            <i class="fa-solid fa-clock"></i>
          </span>
          {{ $texts['hours_weekdays'] }}
        </li>
        <li class="flex items-center">
          <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
            <i class="fa-solid fa-clock"></i>
          </span>
          {{ $texts['hours_weekend'] }}
        </li>
        <li class="flex items-center">
          <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
            <i class="fa-solid fa-mug-hot"></i>
          </span>
          {{ $texts['hours_holiday'] }}
        </li>
      </ul>
    </div>

  </div>

  <!-- Bottom -->
  <div class="border-t border-white mt-10 pt-6 px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
    <p class="text-white text-center">{{ $texts['copyright'] }}</p>
    <div class="flex space-x-6 mt-4 md:mt-0">
      <a href="#" class="hover:text-secondary text-white">{{ $texts['privacy'] }}</a>
      <a href="#" class="hover:text-secondary text-white">{{ $texts['terms'] }}</a>
    </div>
  </div>
</footer>
