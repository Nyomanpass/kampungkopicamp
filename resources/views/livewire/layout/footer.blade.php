<footer class="bg-dark-primary text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-14 grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Logo & Deskripsi -->
        <div>
            <div class="flex items-center mb-4 space-x-2">
                <img src="/images/logo.png" alt="Logo" class="h-20">
            </div>
            <p class="text-sm mb-6 text-white">{{ $texts['desc'] }}</p>


            <!-- Sosmed -->
            <div class="flex space-x-4">
                @foreach ($socialMedia as $key => $url)
                    <a href="{{ $url }}" target="_blank"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
                        <i class="fab fa-{{ $key }} text-white text-lg"></i>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="font-semibold text-lg mb-4">{{ $texts['quick_links'] }}</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-white/40">Home</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-white/40">About</a></li>
                <li><a href="{{ route('package.product') }}" class="hover:text-white/40">Paket Wisata</a></li>
                <li><a href="{{ route('explore-pupuan') }}" class="hover:text-white/40">Explore Pupuan</a></li>
                <li><a href="{{ route('article') }}" class="hover:text-white/40">Artikel</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-white/40">Contact</a></li>
            </ul>
        </div>

        <!-- Kontak -->
        <div>
            <h3 class="font-semibold text-lg mb-4">{{ $texts['contact'] }}</h3>

            <ul class="space-y-4 text-sm">
                <li class="flex items-center">
                    <div class="flex items-center justify-center w-16 h-8 rounded-full text-white mr-3">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="">
                        {{$texts['address']}}
                    </div>
                </li>
                <li class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full text-white mr-3">
                        <i class="fa-solid fa-phone "></i>
                    </div>
                    {{ $texts['phone'] }}
                </li>
                <li class="flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full text-white mr-3">
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
                    <span class="flex items-center justify-center w-8 h-8 rounded-full text-white mr-3">
                        <i class="fa-solid fa-clock"></i>
                    </span>
                    {{ $texts['hours_weekdays'] }}
                </li>
                <li class="flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full text-white mr-3">
                        <i class="fa-solid fa-clock"></i>
                    </span>
                    {{ $texts['hours_weekend'] }}
                </li>
                <li class="flex items-center">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full text-white mr-3">
                        <i class="fa-solid fa-mug-hot"></i>
                    </span>
                    {{ $texts['hours_holiday'] }}
                </li>
            </ul>
        </div>

    </div>

    <!-- Bottom -->
    <div
        class="border-t border-white mt-10 pt-6 px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
        <p class="text-white text-center">{{ $texts['copyright'] }}</p>
        <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="hover:text-secondary text-white">{{ $texts['privacy'] }}</a>
            <a href="#" class="hover:text-secondary text-white">{{ $texts['terms'] }}</a>
        </div>
    </div>
</footer>
