<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}"> <!-- PERBAIKAN: Membuat atribut lang dinamis -->

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-white flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside x-data="{ collapsed: false }" :class="collapsed ? 'md:w-20' : 'md:w-64'"
        class="bg-gradient-to-b from-primary to-[#485934] shadow-lg hidden md:flex flex-col transition-all duration-300 h-full">
        <div class="flex justify-between items-center pb-3 ">
            <h1 x-show="!collapsed" x-transition class="text-white text-xl font-semibold p-4">Kampung Kopi</h1>
            <button @click="collapsed = !collapsed" class="text-white size-16">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
        <div class="scroll-y-auto">
            <!-- Sidebar content goes here -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-chart-column "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Dashboard</span>
            </a>
            <a href="{{ route('admin.bookings') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.bookings') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-calendar-days "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Bookings</span>
            </a>
            <a href="{{ route('admin.products') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.products') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-boxes-stacked "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Products</span>
            </a>
            <a href="{{ route('admin.addons') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.addons') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-puzzle-piece "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Addons</span>
            </a>
            <a href="{{ route('admin.payments') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.payments') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-file-invoice-dollar "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Payments</span>
            </a>
            <a href="{{ route('admin.vouchers') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.vouchers') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-ticket-simple "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Voucher</span>
            </a>
            <a href="{{ route('admin.articles') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.articles') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-newspaper "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Blog & Articles</span>
            </a>
            <a href="{{ route('admin.users') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.users') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-user "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Users</span>
            </a>
            <a href="{{ route('admin.reports') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.reports') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Reports</span>
            </a>
            <a href="{{ route('admin.dashboard') }}"
                class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('home') ? 'bg-[#3f4e2e]' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-gear "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Settings</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
        {{-- navigation bar --}}
        <div class="p-5 border-b border-gray-300 flex justify-between items-center">
            <div x-data="{ openSideBar: false }" class="relative md:hidden" x-cloak>
                <button @click="openSideBar = !openSideBar" class="">
                    <i class="fa-solid fa-bars text-xl text-light-primary"></i>
                </button>

                <div x-show="openSideBar" @click="openSideBar = false" x-transition.opacity
                    class="fixed inset-0 bg-gray-500/70 z-40"></div>

                <aside x-show="openSideBar" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="-translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    class="fixed top-0 left-0 h-full w-80 z-50 bg-gradient-to-b from-primary to-[#485934] shadow-lg flex flex-col transition-all duration-300">

                    <div class="flex justify-between items-center sticky">
                        <h1 class="text-white text-xl font-semibold p-4">Kampung Kopi
                        </h1>
                        <button @click="openSideBar = false" class="text-white size-16">
                            <i class="fa-solid fa-x"></i>
                        </button>
                    </div>
                    <div class="overflow-y-auto pb-14">
                        <!-- Sidebar content goes here -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-chart-column "></i>
                            </div>
                            <span class=>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.bookings') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.bookings') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-calendar-days "></i>
                            </div>
                            <span class=>Bookings</span>
                        </a>
                        <a href="{{ route('admin.products') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.products') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-boxes-stacked "></i>
                            </div>
                            <span class=>Products</span>
                        </a>
                        <a href="{{ route('admin.addons') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.addons') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-puzzle-piece "></i>
                            </div>
                            <span class=>Addons</span>
                        </a>
                        <a href="{{ route('admin.payments') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.payments') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-file-invoice-dollar "></i>
                            </div>
                            <span class=>Payments</span>
                        </a>
                        <a href="{{ route('admin.vouchers') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.vouchers') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-ticket-simple "></i>
                            </div>
                            <span class=>Voucher</span>
                        </a>
                        <a href="{{ route('admin.articles') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.articles') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-newspaper "></i>
                            </div>
                            <span class=>Blog & Articles</span>
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.users') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-user "></i>
                            </div>
                            <span class=>Users</span>
                        </a>
                        <a href="{{ route('admin.reports') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('admin.reports') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <span class=>Reports</span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-[#3f4e2e] transition-all {{ request()->routeIs('home') ? 'bg-[#3f4e2e]' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-gear "></i>
                            </div>
                            <span class=>Settings</span>
                        </a>
                    </div>
                </aside>
            </div>
            <h2 class="text-lg font-semibold text-gray-800">
                {{ $title ?? 'Dashboard Admin' }}
            </h2>
            <div class="flex items-center">
                <div x-data="{ open: false }" class="relative" x-cloak>
                    <button @click="open = !open"
                        class="size-10 flex justify-center items-center rounded-lg hover:bg-gray-100 transition-all">
                        <i class="fa-solid fa-bell text-xl text-light-primary"></i>
                    </button>

                    <!-- Overlay -->
                    <div x-show="open" @click="open = false" x-transition.opacity
                        class="fixed inset-0 bg-gray-500/70 z-40"></div>

                    <!-- Notification Sidebar -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="fixed top-0 right-0 h-full w-80 bg-white shadow-2xl z-50 overflow-y-auto">

                        <!-- Header -->
                        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                            <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>

                        <!-- Notification List -->
                        <div class="p-4 space-y-3">
                            <!-- Sample Notification Item -->
                            <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all cursor-pointer">
                                <p class="text-sm font-medium text-gray-800">Booking Baru</p>
                                <p class="text-xs text-gray-600 mt-1">Ada booking baru dari customer</p>
                                <p class="text-xs text-gray-400 mt-1">2 menit yang lalu</p>
                            </div>

                            <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all cursor-pointer">
                                <p class="text-sm font-medium text-gray-800">Pembayaran Diterima</p>
                                <p class="text-xs text-gray-600 mt-1">Pembayaran untuk booking #1234</p>
                                <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                            </div>

                            <!-- Empty State -->
                            <!-- <div class="text-center py-8">
                                <i class="fa-solid fa-bell-slash text-gray-300 text-4xl mb-2"></i>
                                <p class="text-gray-500 text-sm">Tidak ada notifikasi</p>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="hidden md:block h-6 w-px bg-gray-300 mx-4"></div>
                <div x-data="{ open: false }" class="relative" x-cloak>
                    <button @click="open = !open"
                        class="px-2 lg:px-6 py-2 rounded-lg hover:bg-gray-100 transition-all font-semibold">
                        <span class="hidden md:inline">
                            Halo, {{ auth()->user()->name }}
                            <i class="fa-solid fa-angle-down ml-2"></i>
                        </span>
                        <span class="md:hidden">
                            <i class="fa-solid fa-circle-user text-light-primary text-2xl"></i>

                        </span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">

                        <a href=""
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-all">
                            <i class="fa-solid fa-user mr-3"></i>
                            Profile Settings
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left flex items-center px-4 py-3 text-sm text-red-600 hover:bg-gray-100 transition-all">
                                <i class="fa-solid fa-right-from-bracket mr-3"></i>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="p-6">
            {{ $slot ?? '' }}
        </div>
    </main>

    @livewireScripts
</body>

</html>
