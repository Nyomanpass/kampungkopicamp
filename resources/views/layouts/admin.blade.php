@php
    $routeTitles = [
        'admin.dashboard' => 'Dashboard',
        'admin.bookings' => 'Manajemen Booking',
        'admin.products' => 'Manajemen Produk',
        'admin.availability' => 'Manajemen Ketersediaan Produk',
        'admin.addons' => 'Manajemen Addon',
        'admin.payments' => 'Manajemen Pembayaran',
        'admin.vouchers' => 'Manajemen Voucher',
        'admin.articles' => 'Blog & Artikel',
        'admin.users' => 'Manajemen Pengguna',
        'admin.profile' => 'Profile Settings',
        'admin.reports.revenue' => 'Laporan & Analisa Pendapatan',
        'admin.reports.bookings' => 'Laporan & Analisa Booking',
        'admin.reports.customers' => 'Laporan & Analisa Customer',
        'admin.reports.financial' => 'Laporan & Analisa Keuangan',
        'admin.settings' => 'Settings',
    ];

    $currentRoute = Route::currentRouteName();
    $pageTitle = $routeTitles[$currentRoute] ?? ($title ?? 'Dashboard Admin');
@endphp

<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}"> <!-- PERBAIKAN: Membuat atribut lang dinamis -->

<head>
    <meta charset="UTF-8">
    <title>KKC - Dashboard Admin</title>
    <link rel="icon" type="image/png" href="/images/simpleLogo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    @livewireStyles

    {{-- Trix Editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        /* Trix Editor Custom Styling */
        trix-toolbar .trix-button-row {
            flex-wrap: wrap;
        }

        trix-toolbar .trix-button-group {
            margin-bottom: 5px;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
        }

        trix-toolbar .trix-button {
            border-bottom: none;
        }

        trix-toolbar .trix-button--icon {
            width: 2.5rem;
            height: 2.5rem;
        }

        trix-editor {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 1rem;
            min-height: 400px;
            max-height: 600px;
            overflow-y: auto;
        }

        trix-editor:focus {
            outline: 2px solid #5b7042;
            outline-offset: 2px;
        }

        trix-editor h1 {
            font-size: 2em;
            line-height: 1.2;
            margin: 0.67em 0;
        }

        trix-editor a {
            color: #5b7042;
            text-decoration: underline;
        }

        trix-editor ul,
        trix-editor ol {
            padding-left: 2em;
            margin: 1em 0;
        }
    </style>

    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</head>

<body class="bg-white flex h-screen overflow-hidden font-jakarta">

    <!-- Sidebar -->
    <aside x-data="{ collapsed: false }" :class="collapsed ? 'md:w-20' : 'md:w-64'"
        class="bg-gradient-to-b from-secondary to-light-primary shadow-lg hidden md:flex flex-col transition-all duration-300 h-full">
        <div class="flex justify-between items-center pb-3 ">
            <h1 x-show="!collapsed" x-transition class="text-white text-xl font-semibold p-4">Kampung Kopi</h1>
            <button @click="collapsed = !collapsed" class="text-white size-16">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto">
            <!-- Sidebar content goes here -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-chart-column "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Dashboard</span>
            </a>
            <a href="{{ route('admin.bookings') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.bookings') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-calendar-days "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Booking</span>
            </a>
            <a href="{{ route('admin.products') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.products') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-boxes-stacked "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Produk</span>
            </a>
            <a href="{{ route('admin.availability') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.availability') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-boxes-stacked "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Ketersediaan Produk</span>
            </a>
            <a href="{{ route('admin.addons') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.addons') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-puzzle-piece "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Addons</span>
            </a>
            <a href="{{ route('admin.payments') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.payments') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-file-invoice-dollar "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Payments</span>
            </a>
            <a href="{{ route('admin.vouchers') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.vouchers') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-ticket-simple "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Voucher</span>
            </a>
            <a href="{{ route('admin.articles') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.articles') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-newspaper "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Blog & Articles</span>
            </a>
            <a href="{{ route('admin.users') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.users') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-user "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Users</span>
            </a>
            <div x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                {{-- Parent Menu --}}
                <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-3 p-5  transition-all
            {{ request()->routeIs('admin.reports.*') ? 'bg-dark-secondary text-white' : 'text-white hover:bg-dark-secondary' }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-chart-bar"></i>
                        <span x-show="!collapsed" x-transition class="" class="font-medium">Laporan</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200 mr-4"
                        :class="{ 'rotate-180': open }" x-show="!collapsed" x-transition></i>
                </button>

                {{-- Sub-menus --}}
                <div x-show="open" x-collapse class="">


                    {{-- Revenue Reports --}}
                    <a href="{{ route('admin.reports.revenue') }}"
                        class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.revenue') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                        {{-- <i class="fas fa-dollar-sign text-base"></i> --}}
                        <span x-show="!collapsed" x-transition>Pendapatan</span>
                    </a>

                    {{-- Booking Reports --}}
                    <a href="{{ route('admin.reports.bookings') }}"
                        class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.bookings') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                        {{-- <i class="fas fa-calendar-alt text-base"></i> --}}
                        <span x-show="!collapsed" x-transition>Booking</span>
                    </a>

                    {{-- Customer Reports --}}
                    <a href="{{ route('admin.reports.customers') }}"
                        class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.customers') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                        {{-- <i class="fas fa-users text-base"></i> --}}
                        <span x-show="!collapsed" x-transition>Customer</span>
                    </a>

                    {{-- Financial Reports --}}
                    <a href="{{ route('admin.reports.financial') }}"
                        class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.financial') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                        {{-- <i class="fas fa-file-invoice-dollar text-base"></i> --}}
                        <span x-show="!collapsed" x-transition>Keuangan</span>
                    </a>
                </div>
            </div>
            <a href="{{ route('admin.settings') }}"
                class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.settings') ? 'bg-dark-secondary' : '' }}">
                <div class="p-5">
                    <i class="fa-solid fa-gear "></i>
                </div>
                <span x-show="!collapsed" x-transition class="">Settings</span>
            </a>
        </div>
        <div class="flex items-center justify-center mb-2">
            <p class="text-xs text-gray-200">Version 1.0.0</p>
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
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-chart-column "></i>
                            </div>
                            <span class=>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.bookings') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.bookings') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-calendar-days "></i>
                            </div>
                            <span class=>Booking</span>
                        </a>
                        <a href="{{ route('admin.products') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.products') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-boxes-stacked "></i>
                            </div>
                            <span class=>Produk</span>
                        </a>
                        <a href="{{ route('admin.availability') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.availability') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-boxes-stacked "></i>
                            </div>
                            <span class=>Ketersediaan Produk</span>
                        </a>
                        <a href="{{ route('admin.addons') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.addons') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-puzzle-piece "></i>
                            </div>
                            <span class=>Addons</span>
                        </a>
                        <a href="{{ route('admin.payments') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.payments') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-file-invoice-dollar "></i>
                            </div>
                            <span class=>Payments</span>
                        </a>
                        <a href="{{ route('admin.vouchers') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.vouchers') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-ticket-simple "></i>
                            </div>
                            <span class=>Voucher</span>
                        </a>
                        <a href="{{ route('admin.articles') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.articles') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-newspaper "></i>
                            </div>
                            <span class=>Blog & Articles</span>
                        </a>
                        <a href="{{ route('admin.users') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.users') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-user "></i>
                            </div>
                            <span class=>Users</span>
                        </a>
                        <div x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                            {{-- Parent Menu --}}
                            <button @click="open = !open"
                                class="w-full flex items-center justify-between gap-3 p-5  transition-all
            {{ request()->routeIs('admin.reports.*') ? 'bg-dark-secondary text-white' : 'text-white hover:bg-dark-secondary' }}">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-chart-bar"></i>
                                    <span class="" class="font-medium">Laporan</span>
                                </div>
                                <i class="fas fa-chevron-down text-sm transition-transform duration-200 mr-4"
                                    :class="{ 'rotate-180': open }"></i>
                            </button>

                            {{-- Sub-menus --}}
                            <div x-show="open" x-collapse class="">


                                {{-- Revenue Reports --}}
                                <a href="{{ route('admin.reports.revenue') }}"
                                    class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.revenue') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                                    {{-- <i class="fas fa-dollar-sign text-base"></i> --}}
                                    <span>Pendapatan</span>
                                </a>

                                {{-- Booking Reports --}}
                                <a href="{{ route('admin.reports.bookings') }}"
                                    class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.bookings') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                                    {{-- <i class="fas fa-calendar-alt text-base"></i> --}}
                                    <span>Booking</span>
                                </a>

                                {{-- Customer Reports --}}
                                <a href="{{ route('admin.reports.customers') }}"
                                    class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.customers') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                                    {{-- <i class="fas fa-users text-base"></i> --}}
                                    <span>Customer</span>
                                </a>

                                {{-- Financial Reports --}}
                                <a href="{{ route('admin.reports.financial') }}"
                                    class="flex items-center gap-3 pl-15 py-5 transition-all text-sm
                {{ request()->routeIs('admin.reports.financial') ? 'bg-dark-secondary text-white font-semibold' : 'text-white hover:bg-dark-secondary' }}">
                                    {{-- <i class="fas fa-file-invoice-dollar text-base"></i> --}}
                                    <span>Keuangan</span>
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('admin.settings') }}"
                            class="flex text-white justify-start items-center w-full hover:bg-dark-secondary transition-all {{ request()->routeIs('admin.settings') ? 'bg-dark-secondary' : '' }}">
                            <div class="p-5">
                                <i class="fa-solid fa-gear "></i>
                            </div>
                            <span class=>Settings</span>
                        </a>
                    </div>
                </aside>
            </div>
            <h2 class="text-lg font-semibold text-gray-800">
                {{ $pageTitle ?? 'Dashboard Admin' }}
            </h2>
            <div class="flex items-center">
                @livewire('admin.notifications')
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

                        <a href="{{ route('admin.profile') }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-all">
                            <i class="fa-solid fa-user mr-3"></i>
                            Profile Settings
                        </a>
                        <a href="/"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-all">
                            <i class="fa-solid fa-globe mr-3"></i>
                            Ke Website
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="{{ route('logout') }}"
                            class="w-full text-left flex items-center px-4 py-3 text-sm text-red-600 hover:bg-gray-100 transition-al">
                            <i class="fa-solid fa-right-from-bracket mr-3""></i>
                            Sign Out
                        </a>

                    </div>
                </div>
            </div>

        </div>

        <div class="p-6 bg-gray-100">
            {{ $slot ?? '' }}
        </div>
    </main>

    @livewireScripts

</body>

</html>
