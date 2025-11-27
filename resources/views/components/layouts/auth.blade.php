<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kampung Kopi Camp | #AyoKePupuan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="w-screen h-screen flex justify-center items-center font-jakarta bg-neutral">
    {{ $slot }}
</body>

</html>
