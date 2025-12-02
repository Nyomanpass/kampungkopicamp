<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="/images/logoicon.png">
    <title>Kampung Kopi Camp | #AyoKePupuan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="w-screen h-screen flex justify-center items-center font-jakarta bg-neutral">
    {{ $slot }}
</body>

</html>
