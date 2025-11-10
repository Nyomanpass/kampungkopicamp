<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}"> <!-- PERBAIKAN: Membuat atribut lang dinamis -->

<head>
    <meta charset="UTF-8">
    <title>KKC - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</head>

<body class="bg-white flex h-screen overflow-hidden font-jakarta max-w-6xl mx-auto">

    {{-- desktop Sidebar --}}
    <aside
        class="border-2 bg-white border-light-primary/50 w-72 hidden lg:block h-max py-5 rounded-lg sticky top-6 mr-4">
        <!-- Header -->
        <div class="px-5 flex items-center justify-start gap-4">
            <div class="size-14 rounded-full bg-primary"></div>
            <div class="">
                <h2 class="font-semibold text-xl">{{ auth()->user()->name }}</h2>
                <p class="text-sm text-gray-600">{{ auth()->user()->role }}</p>
            </div>
        </div>
        <div class="h-[1px] w-[90%] border-b border-gray-400 mt-6 mb-3 mx-auto"></div>
        {{-- navigation --}}
        <div class="">
            <div class="">
                <a href="{{ route('user.dashboard') }}"
                    class="px-5 py-2.5 flex items-center gap-4 text-gray-800 {{ request()->routeIs('user.dashboard') ? 'bg-light-primary text-white font-semibold hover:bg-light-primary/80' : 'hover:bg-gray-100' }}">
                    <i
                        class="{{ request()->routeIs('user.dashboard') ? 'fas fa-home' : 'fa-regular fa-home ' }} text-xl"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('user.bookings') }}"
                    class="px-5 py-2.5 flex items-center gap-4 text-gray-800 {{ request()->routeIs('user.bookings') ? 'bg-light-primary text-white font-semibold hover:bg-light-primary/80' : 'hover:bg-gray-100' }}">
                    <i
                        class="{{ request()->routeIs('user.bookings') ? 'fas fa-file-lines' : 'fa-regular fa-file-lines ' }} text-xl"></i>
                    <span>My Booking</span>
                </a>
                <a href="{{ route('user.rewards') }}"
                    class="px-5 py-2.5 flex items-center gap-4 text-gray-800 {{ request()->routeIs('user.rewards') ? 'bg-light-primary text-white font-semibold hover:bg-light-primary/80' : 'hover:bg-gray-100' }}">
                    <i
                        class="{{ request()->routeIs('user.rewards') ? 'fas fa-heart' : 'fa-regular fa-heart ' }} text-xl"></i>
                    <span>Rewards</span>
                </a>
            </div>
            <div class="h-[1px] w-[90%] border-b border-gray-400 mt-3 mb-3 mx-auto"></div>
            <div>
                <a href="{{ route('user.account') }}"
                    class="px-5 py-2.5 flex items-center gap-4 text-gray-800 {{ request()->routeIs('user.account') ? 'bg-light-primary text-white font-semibold hover:bg-light-primary/80' : 'hover:bg-gray-100' }}">
                    <i
                        class="{{ request()->routeIs('user.account') ? 'fas fa-user' : 'fa-regular fa-user ' }} text-xl"></i>
                    <span>Account Settings</span>
                </a>
                <a href="/" class="px-5 py-2.5 flex items-center gap-4 text-gray-800 hover:bg-gray-100">
                    <i class="fa-regular fa-compass text-xl"></i>
                    <span>Go To Website</span>
                </a>
            </div>
            <div class="h-[1px] w-[90%] border-b border-gray-400 mt-3 mb-3 mx-auto"></div>
            <div>
                <a href="{{ route('logout') }}"
                    class="px-5 py-2.5 flex items-center gap-4 text-danger hover:bg-gray-100">
                    <i class="fa-solid fa-power-off text-xl"></i>
                    <span>Log Out</span>
                </a>

            </div>
        </div>
    </aside>

    {{-- mobile bottom navbar --}}
    <nav class="px-3 z-30 fixed bottom-0 left-0 right-0 w-full bg-white shadow-md lg:hidden">
        <div class="flex justify-around py-3 gap-4">
            <a href="{{ route('user.dashboard') }}"
                class="text-center space-y-1.5 {{ request()->routeIs('user.dashboard') ? 'text-light-primary font-semibold' : 'text-gray-500 ' }}">
                <i
                    class="{{ request()->routeIs('user.dashboard') ? 'fas fa-home' : 'fa-regular fa-home ' }} text-lg"></i>
                <p class="text-xs">Home</p>
            </a>
            <a href="{{ route('user.bookings') }}"
                class="text-center space-y-1.5 {{ request()->routeIs('user.bookings') ? 'text-light-primary font-semibold' : 'text-gray-500 ' }}">
                <i
                    class="{{ request()->routeIs('user.bookings') ? 'fas fa-file-lines' : 'fa-regular fa-file-lines ' }} text-lg"></i>
                <p class="text-xs">My Booking</p>
            </a>
            <a href="{{ route('user.rewards') }}"
                class="text-center space-y-1.5 {{ request()->routeIs('user.rewards') ? 'text-light-primary font-semibold' : 'text-gray-500 ' }}">
                <i
                    class="{{ request()->routeIs('user.rewards') ? 'fas fa-heart' : 'fa-regular fa-heart ' }} text-lg"></i>
                <p class="text-xs">Rewards</p>
            </a>
            <a href="{{ route('user.account') }}"
                class="text-center space-y-1.5 {{ request()->routeIs('user.account') ? 'text-light-primary font-semibold' : 'text-gray-500 ' }}">
                <i
                    class="{{ request()->routeIs('user.account') ? 'fas fa-user' : 'fa-regular fa-user ' }} text-lg"></i>
                <p class="text-xs">Account</p>
            </a>

            <!-- Tambahkan item navbar lainnya di sini -->
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto bg-white lg:mt-6">
        <div class="">
            {{ $slot ?? '' }}
        </div>
    </main>

    @livewireScripts

</body>

</html>
