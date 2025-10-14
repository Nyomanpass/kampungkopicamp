<header id="navbar"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300
        {{ $scrolled ? 'bg-white shadow-md text-secondary py-1' : 'bg-transparent text-white' }}">
    <div class="relative max-w-7xl mx-auto flex items-center justify-between px-8 lg:px-14 py-4">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-2">
            <h1 class="font-semibold text-xl md:text-2xl leading-tight">Kampung Kopi</h1>
        </a>

        <!-- Navbar Desktop -->
        <nav class="hidden lg:flex items-center space-x-8">
            <a href="/" class="hover:text-warna-400">{{ $texts['home'] }}</a>
            <a href="/about" class="hover:text-warna-400">{{ $texts['about'] }}</a>
            <a href="/paket-wisata" class="hover:text-warna-400">{{ $texts['tour_packages'] }}</a>
            <a href="/explore-pupuan" class="hover:text-warna-400">{{ $texts['explore_pupuan'] }}</a>
            <a href="/article" class="hover:text-warna-400">{{ $texts['article'] }}</a>
            <a href="/contact" class="hover:text-warna-400">{{ $texts['contact'] }}</a>
        </nav>

        <!-- Right: Login + Language -->
        <div class="hidden lg:flex items-center relative z-50">
        <a href="#"
   class="px-5 py-2 rounded-full text-sm font-medium border transition
           hover:bg-secondary
          {{ $scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white' }}">
   {{ $texts['login'] }}
</a>




            <div class="z-50 pointer-events-auto text-white px-4 py-2 rounded-full ">
                <livewire:language-switcher :key="session('locale')" />
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button wire:click="toggleMobileMenu" class="lg:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300">
            <div class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
                <span class="block w-6 h-0.5 bg-current transition {{ $mobileMenuOpen ? 'rotate-45 translate-y-1.5' : '' }}"></span>
                <span class="block w-6 h-0.5 bg-current transition {{ $mobileMenuOpen ? 'opacity-0' : '' }}"></span>
                <span class="block w-6 h-0.5 bg-current transition {{ $mobileMenuOpen ? '-rotate-45 -translate-y-1.5' : '' }}"></span>
            </div>
        </button>
    </div>

    @if($mobileMenuOpen)
        <div class="lg:hidden w-full bg-gray-100 shadow-md border-t border-gray-300">
            <nav class="px-6 py-6 space-y-4">
                <a href="/" class="block py-2 text-secondary hover:text-warna-400">{{ $texts['home'] }}</a>
                <a href="/about" class="block py-2 text-secondary hover:text-warna-400">{{ $texts['about'] }}</a>
                <a href="/paket-wisata" class="block py-2 text-secondary hover:text-warna-400">{{ $texts['tour_packages'] }}</a>
                <a href="/explore-pupuan" class="block py-2 text-secondary hover:text-warna-400">{{ $texts['explore_pupuan'] }}</a>
                <a href="/article" class="block py-2 text-secondary hover:text-warna-400">{{ $texts['article'] }}</a>
                <a href="/contact" class="block py-2 text-secondary hover:text-warna-400">{{ $texts['contact'] }}</a>
            </nav>
        </div>
    @endif
</header>

<script>
    document.addEventListener('scroll', function () {
        // @this.set('variabel', value) -> Livewire akan menerima update
        @this.set('scrolled', window.pageYOffset > 50);
    });
</script>
