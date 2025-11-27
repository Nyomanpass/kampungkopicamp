<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/images/simpleLogo.png">
    <title>Detail Package | Kampung Kopi Camp </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    @if (request()->routeIs('package.detail'))
        <div class="absolute z-10 top-6 left-0 right-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="@if (auth()->check()) {{ route('user.dashboard') }}
            @else
                {{ route('home') }} @endif"
                class="absolute z-10 bg-white px-1.5 py-2 rounded-full hover:bg-neutral flex items-center justify-center">
                <i class="fas fa-angle-left text-xl lg:text-2xl text-dark"></i>
            </a>
        </div>
    @endif


    {{ $slot }}
</body>

</html>
