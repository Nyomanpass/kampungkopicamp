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
        class="fixed  top-0 left-0 w-full z-50 transition-all duration-300"
        :class="@if(request()->is('/'))
        scrolled ? 'bg-white shadow-md text-primary py-1' : 'bg-transparent text-white'
        @else
            'bg-white shadow-md text-primary py-1'
        @endif">
        <div class="relative h-16 max-w-7xl mx-auto flex items-center justify-between px-8 lg:px-14 py-5">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <h1 class="font-semibold text-xl md:text-2xl leading-tight">Kampung Kopi</h1>
            </a>

            <!-- Navbar Desktop -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="/" class="hover:text-light-primary transition-all">Home</a>
                <a href="/about" class="hover:text-light-primary transition-all">About</a>
                <a href="/paket-wisata" class="hover:text-light-primary transition-all">Tour Packages</a>
                <a href="/explore-pupuan" class="hover:text-light-primary transition-all">Explore Pupuan</a>
                <a href="/article" class="hover:text-light-primary transition-all">Article</a>
                <a href="/contact" class="hover:text-light-primary transition-all">Contact</a>
            </nav>

            <!-- Right: Login + Language -->
            <div class="hidden lg:flex items-center relative z-50">
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href=""
                        class="px-5 py-2 rounded-full text-sm font-medium border transition hover:bg-secondary"
                        :class="scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white'">
                        Admin Dashboard
                    </a>
                @elseif(Auth::check() && Auth::user()->role === 'user')
                    <a href=""
                        class="px-5 py-2 rounded-full text-sm font-medium border transition hover:bg-secondary"
                        :class="scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white'">
                        User Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 rounded-full text-sm font-medium border transition
                       hover:bg-secondary
                      "
                        :class="scrolled ? 'bg-white border text-secondary hover:text-white' : 'text-white'
                        }
                        }">
                        Dapatkan Promo Menarik
                    </a>
                @endif
                {{-- <div class="z-50 pointer-events-auto text-white px-4 py-2 rounded-full ">
                    <livewire:language-switcher :key="session('locale')" />
                </div> --}}
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
            class="lg:hidden w-full bg-gray-100 shadow-md border-t border-gray-300">
            <nav class="px-6 py-6 space-y-4">
                <a href="/" class="block py-2 text-secondary hover:text-warna-400">Home</a>
                <a href="/about" class="block py-2 text-secondary hover:text-warna-400">About</a>
                <a href="/paket-wisata" class="block py-2 text-secondary hover:text-warna-400">Tour Packages</a>
                <a href="/explore-pupuan" class="block py-2 text-secondary hover:text-warna-400">Explore Pupuan</a>
                <a href="/article" class="block py-2 text-secondary hover:text-warna-400">Article</a>
                <a href="/contact" class="block py-2 text-secondary hover:text-warna-400">Contact</a>
            </nav>
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




</body>

</html>
