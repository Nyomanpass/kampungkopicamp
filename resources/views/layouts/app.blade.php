<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Livewire Frontend</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="text-gray-800">

    <!-- Navbar -->
<header 
  id="header" 
  x-data="{ mobileMenuOpen: false, scrolled: false }"
  class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
  @scroll.window="scrolled = window.pageYOffset > 50"
  :class="(scrolled || mobileMenuOpen) 
      ? 'bg-white text-secondary py-8 shadow-md' 
      : 'bg-transparent text-white py-6'"
>

  <!-- Wrapper utama -->
  <div class="relative max-w-7xl mx-auto flex items-center justify-between px-8 lg:px-14">

    <!-- LEFT: Logo -->
    <a href="/" class="flex items-center space-x-2">
      <h1 class="font-semibold text-xl md:text-2xl leading-tight">
        Kampung Kopi
      </h1>
    </a>

    <!-- CENTER: Navbar Desktop -->
    <nav class="hidden lg:flex items-center space-x-8">
      <a href="/" class="hover:text-warna-400">Home</a>
      <a href="/about" class="hover:text-warna-400">About</a>
      <a href="/paket-wisata" class="hover:text-warna-400">Paket Wisata</a>
      <a href="/explore-pupuan" class="hover:text-warna-400">Explore Pupuan</a>
      <a href="/article" class="hover:text-warna-400">Article</a>
      <a href="/contact" class="hover:text-warna-400">Contact</a>
    </nav>

    <!-- RIGHT: Tombol Desktop -->
    <div class="hidden lg:flex items-center space-x-4">
      <a href="#"
         class="px-5 py-2 rounded-full text-sm font-medium border"
         :class="scrolled 
           ? 'bg-secondary text-white border-secondary hover:opacity-90' 
           : 'text-white border-white hover:bg-white hover:text-secondary'">
        Booking Now
      </a>

      <a href="#"
         class="px-5 py-2 rounded-full text-sm font-medium border"
         :class="scrolled 
           ? 'bg-white text-secondary border-secondary hover:bg-secondary hover:text-white' 
           : 'text-white border-white hover:bg-white hover:text-secondary'">
        Login
      </a>
    </div>

    <!-- Mobile Menu Button (DI LUAR GRID) -->
    <button 
      @click="mobileMenuOpen = !mobileMenuOpen"
      class="lg:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white/20 ml-auto">
      <div class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
        <span class="block w-6 h-0.5 bg-current transition"
              :class="mobileMenuOpen ? 'rotate-45 translate-y-1.5' : ''"></span>
        <span class="block w-6 h-0.5 bg-current transition"
              :class="mobileMenuOpen ? 'opacity-0' : ''"></span>
        <span class="block w-6 h-0.5 bg-current transition"
              :class="mobileMenuOpen ? '-rotate-45 -translate-y-1.5' : ''"></span>
      </div>
    </button>

  </div>

  <!-- Mobile Dropdown -->
  <div 
    x-show="mobileMenuOpen"
    x-transition
    class="lg:hidden w-full bg-warna-300/95 backdrop-blur-md shadow-md border-t border-white/10">
    <nav class="px-6 py-6 space-y-4">
      <a href="/" class="block py-2 text-secondary hover:text-warna-400" @click="mobileMenuOpen = false">Home</a>
      <a href="/about" class="block py-2 text-secondary hover:text-warna-400" @click="mobileMenuOpen = false">About</a>
      <a href="/paket-wisata" class="block py-2 text-secondary hover:text-warna-400" @click="mobileMenuOpen = false">Paket Wisata</a>
      <a href="/explore-pupuan" class="block py-2 text-secondary hover:text-warna-400" @click="mobileMenuOpen = false">Explore Pupuan</a>
      <a href="/article" class="block py-2 text-secondary hover:text-warna-400" @click="mobileMenuOpen = false">Article</a>
      <a href="/contact" class="block py-2 text-secondary hover:text-warna-400" @click="mobileMenuOpen = false">Contact</a>
      <div class="pt-4 border-t border-secondary/20 space-y-3">
        <a href="#" class="block w-full py-3 text-center rounded-lg bg-secondary text-white font-medium">Booking Now</a>
        <a href="#" class="block w-full py-3 text-center rounded-lg border text-secondary border-warna-400">Login</a>
      </div>
    </nav>
  </div>
</header>



    <!-- Isi Halaman -->
    <main class="">       
        {{ $slot ?? '' }}
    </main>


    @livewireScripts

    <footer class="bg-secondary text-white pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-6 lg:px-14 grid grid-cols-1 md:grid-cols-4 gap-12">

    <!-- Logo & Deskripsi -->
    <div>
      <div class="flex items-center mb-4">
        <div>
          <h2 class="text-lg font-semibold">Kampung Kopi Camp</h2>
        </div>
      </div>
      <p class="text-sm mb-6 text-white">
        Nikmati pengalaman otentik Bali di tengah keindahan alam Pupuan. Dari kopi hingga budaya, setiap momen adalah petualangan yang tak terlupakan.
      </p>

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
      <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
      <ul class="space-y-2">
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
  <h3 class="font-semibold text-lg mb-4">Kontak</h3>
  <ul class="space-y-4 text-sm">
    <li class="flex items-start">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3 mt-1">
        <i class="fa-solid fa-location-dot"></i>
      </span>
      Jl. Raya Pupuan No. 123<br>Desa Pupuan, Tabanan<br>Bali 82163
    </li>
    <li class="flex items-center">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
        <i class="fa-solid fa-phone"></i>
      </span>
      +62 812-3456-789
    </li>
    <li class="flex items-center">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
        <i class="fa-solid fa-envelope"></i>
      </span>
      hello@kampungkopicamp.com
    </li>
  </ul>
</div>


    <!-- Jam Buka -->
    <div>
  <h3 class="font-semibold text-lg mb-4">Jam Buka</h3>
  <ul class="space-y-2 text-sm">
    <li class="flex items-center">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
        <i class="fa-solid fa-clock"></i>
      </span>
      Senin - Jumat: 08.00 - 21.00
    </li>
    <li class="flex items-center">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
        <i class="fa-solid fa-clock"></i>
      </span>
      Sabtu - Minggu: 09.00 - 23.00
    </li>
    <li class="flex items-center">
      <span class="flex items-center justify-center w-8 h-8 rounded-full bg-secondary text-white mr-3">
        <i class="fa-solid fa-mug-hot"></i>
      </span>
      Libur Nasional: Tutup
    </li>
  </ul>
</div>


  </div>

  <!-- Bottom -->
  <div class="border-t border-white mt-10 pt-6 px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
    <p class="text-white">© 2024 Kampung Kopi Camp. All rights reserved.</p>
    <div class="flex space-x-6 mt-4 md:mt-0">
      <a href="#" class="hover:text-secondary text-white">Privacy Policy</a>
      <a href="#" class="hover:text-secondary text-white">Terms of Service</a>
    </div>
  </div>
</footer>


<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi AOS pertama kali
    AOS.init({
        duration: 1000,
        once: true,
    });

    window.addEventListener('load', () => {
        AOS.refresh();
    });

    if (typeof Livewire !== 'undefined') {
        Livewire.hook('message.processed', (message, component) => {
            if (typeof AOS !== 'undefined') {
                AOS.refreshHard(); // gunakan refreshHard supaya animasi elemen baru jalan
            }
        });
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('scroll-to-paket', () => {
        const section = document.getElementById('paket-wisata');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>




</body>
</html>
