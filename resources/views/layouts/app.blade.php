<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Livewire Frontend</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="text-gray-800 font-jakarta">

    <!-- Navbar -->
    <header id="navbar" x-data="{ scrolled: false, mobileMenuOpen: false }" x-init="window.addEventListener('scroll', () => {
        scrolled = window.pageYOffset > 50;
    });"
        class="fixed py-4 top-0 left-0 w-full z-50 transition-all duration-300 ease-in-out"
       :class="
    mobileMenuOpen || scrolled
        ? 'bg-white shadow-md text-secondary py-1'
        : 'bg-transparent text-white'
"
>
        <div class="relative h-16 max-w-7xl mx-auto flex items-center justify-between px-8 lg:px-14 py-5">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <img class="md:w-36 md:h-16 w-28 h-12 transition-all duration-100 ease-in-out delay-75"
                :src="scrolled || mobileMenuOpen ? '/images/logodua.png' : '/images/logo.png'"
                alt="">

            </a>

            <!-- Navbar Desktop -->
            <nav class="hidden lg:flex items-center space-x-7">
                <a href="/" class="hover:text-primary">{{ __('messages.home') }}</a>
                <a href="/about" class="hover:text-primary">{{ __('messages.about') }}</a>
                <a href="/package" class="hover:text-primary">{{ __('messages.tour_packages') }}</a>
                <a href="/explore-pupuan" class="hover:text-primary">{{ __('messages.explore_pupuan') }}</a>
                <a href="/article" class="hover:text-primary">{{ __('messages.article') }}</a>
                <a href="/contact" class="hover:text-primary">{{ __('messages.contact') }}</a>
            </nav>


            <!-- Right: Login + Language -->
            <div class="hidden lg:flex items-center relative z-50">
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-5 py-2 rounded-full text-sm font-medium border transition hover:bg-secondary"
                        :class="scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white'">
                        Admin Dashboard
                    </a>
                @elseif(Auth::check() && Auth::user()->role === 'user')
                    <a href="{{ route('user.dashboard') }}"
                        class="px-5 py-2 rounded-full text-sm font-medium border transition hover:bg-secondary"
                        :class="scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white'">
                        User Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 rounded-full text-sm font-medium border transition
                       hover:bg-secondary
                      "
                        :class="scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white'">
                        {{ __('messages.login') }}
                    </a>
                @endif
                <div class="z-50 pointer-events-auto text-white px-4 py-2 rounded-full ">
                    <livewire:language-switcher :key="session('locale')" />
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300">
                <div class="w-6 h-6 flex flex-col justify-center items-center space-y-1">
                    <span class="block w-6 h-0.5 bg-current transition transform"
                        :class="mobileMenuOpen ? 'rotate-45 translate-y-1.5' : ''"></span>
                    <span class="block w-6 h-0.5 bg-current transition"
                        :class="mobileMenuOpen ? 'opacity-0' : ''"></span>
                    <span class="block w-6 h-0.5 bg-current transition transform"
                        :class="mobileMenuOpen ? '-rotate-45 -translate-y-1.5' : ''"></span>
                </div>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-transition
           class="lg:hidden w-full  relative z-40">
            <nav class="px-6 py-6 space-y-4">
                <a href="/" class="block py-2 text-secondary hover:text-warna-400">{{ __('messages.home') }}</a>
                <a href="/about" class="block py-2 text-secondary hover:text-warna-400">{{ __('messages.about') }}</a>
                <a href="/package" class="block py-2 text-secondary hover:text-warna-400">{{ __('messages.tour_packages') }}</a>
                <a href="/explore-pupuan" class="block py-2 text-secondary hover:text-warna-400">{{ __('messages.explore_pupuan') }}</a>
                <a href="/article" class="block py-2 text-secondary hover:text-warna-400">{{ __('messages.article') }}</a>
                <a href="/contact" class="block py-2 text-secondary hover:text-warna-400">{{ __('messages.contact') }}</a>
            </nav>
            <!-- MOBILE BUTTON (login / dashboard) -->
<div class="flex lg:hidden items-center relative z-50 px-6 mt-6">
    @if (Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
            class="w-full text-center px-5 py-2 rounded-full text-sm font-medium transition
            bg-secondary text-white hover:opacity-90"
            :class="scrolled ? 'shadow-md' : ''">
            Admin Dashboard
        </a>
    @elseif(Auth::check() && Auth::user()->role === 'user')
        <a href="{{ route('user.dashboard') }}"
            class="w-full text-center px-5 py-2 rounded-full text-sm font-medium transition
            bg-secondary text-white hover:opacity-90"
            :class="scrolled ? 'shadow-md' : ''">
            User Dashboard
        </a>
    @else
        <a href="{{ route('register') }}"
            class="w-full text-center px-5 py-2 rounded-full text-sm font-medium transition
            bg-secondary text-white hover:opacity-90"
            :class="scrolled ? 'shadow-md' : ''">
            {{ __('messages.login') }}
        </a>
    @endif
</div>

            <div class="z-50 pointer-events-auto text-white px-4 py-2 rounded-full ">
                    <livewire:language-switcher :key="session('locale')" />
                </div>
        </div>
    </header>

    <!-- Isi Halaman -->
    <main class="">
        {{ $slot ?? '' }}
    </main>


    @livewireScripts


    <livewire:layout.footer :key="session('locale')" />


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // durasi animasi (ms)
            once: true, // animasi hanya sekali
        });

        window.addEventListener('load', function() {
            AOS.refresh();
        });

        Livewire.hook('message.processed', (message, component) => {
            // Refresh AOS supaya elemen baru muncul animasinya
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('scroll-to-paket', () => {
                const section = document.getElementById('paket-wisata');
                if (section) {
                    section.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</body>

</html>
