<footer class="bg-dark-primary text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-14 grid grid-cols-1 md:grid-cols-4 gap-12">

        <!-- Logo & Deskripsi -->
        <div>
            <div class="flex items-center mb-4">
                <h2 class="text-lg font-semibold">{{ $texts['brand'] }}</h2>
            </div>
            <p class="text-sm mb-6 text-white">{{ $texts['desc'] }}</p>

            <!-- Sosmed -->
            <div class="flex space-x-4">
                @if (!empty($socialMedia['instagram']))
                    <a href="{{ $socialMedia['instagram'] }}" target="_blank"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
                        <i class="fab fa-instagram text-white text-lg"></i>
                    </a>
                @endif

                @if (!empty($socialMedia['facebook']))
                    <a href="{{ $socialMedia['facebook'] }}" target="_blank"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
                        <i class="fab fa-facebook-f text-white text-lg"></i>
                    </a>
                @endif

                @if (!empty($socialMedia['tiktok']))
                    <a href="{{ $socialMedia['tiktok'] }}" target="_blank"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
                        <i class="fab fa-tiktok text-white text-lg"></i>
                    </a>
                @endif

                @if (!empty($socialMedia['youtube']))
                    <a href="{{ $socialMedia['youtube'] }}" target="_blank"
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-secondary hover:bg-opacity-90 transition">
                        <i class="fab fa-youtube text-white text-lg"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="font-semibold text-lg mb-4">{{ $texts['quick_links'] }}</h3>
            <ul class="grid grid-cols-2 gap-2">
                <li><a href="#" class="hover:text-secondary">Home</a></li>
                <li><a href="#" class="hover:text-secondary">About</a></li>
                <li><a href="#" class="hover:text-secondary">Paket Wisata</a></li>
                <li><a href="#" class="hover:text-secondary">Explore Pupuan</a></li>
                <li><a href="#" class="hover:text-secondary">Gallery</a></li>
                <li><a href="#" class="hover:text-secondary">Contact</a></li>
            </ul>
        </div>

        <!-- Kontak -->
        <div>
            <h3 class="font-semibold text-lg mb-4">{{ $texts['contact'] }}</h3>
            <ul class="space-y-4 text-sm">
                <li class="flex items-center">

                    <i class="fa-solid fa-location-dot mr-3 text-secondary"></i>
                    {!! nl2br(e($texts['address'])) !!}
                </li>
                <li class="flex items-center">
                    <i class="fa-solid fa-phone mr-3 text-secondary"></i>

                    {{ $texts['phone'] }}
                </li>
                <li class="flex items-center">
                    <i class="fa-solid fa-envelope mr-3 text-secondary"></i>
                    {{ $texts['email'] }}
                </li>
            </ul>
        </div>

        <!-- Jam Buka -->
        <div>
            <h3 class="font-semibold text-lg mb-4">{{ $texts['open_hours'] }}</h3>
            <ul class="space-y-4 text-sm">
                <li class="flex items-center">
                    <i class="fa-solid fa-clock mr-3 text-secondary"></i>
                    {{ $texts['hours_weekdays'] }}
                </li>
                <li class="flex items-center">
                    <i class="fa-solid fa-clock mr-3 text-secondary"></i>
                    {{ $texts['hours_weekend'] }}
                </li>
                <li class="flex items-center">
                    <i class="fa-solid fa-mug-hot mr-3 text-secondary"></i>
                    {{ $texts['hours_holiday'] }}
                </li>
            </ul>
        </div>

    </div>

    <!-- Bottom -->
    <div
        class="border-t border-white mt-10 pt-6 px-6 lg:px-8 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
        <p class="text-white">{{ $texts['copyright'] }}</p>
        <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="hover:text-secondary text-white">{{ $texts['privacy'] }}</a>
            <a href="#" class="hover:text-secondary text-white">{{ $texts['terms'] }}</a>
        </div>
    </div>
</footer>
