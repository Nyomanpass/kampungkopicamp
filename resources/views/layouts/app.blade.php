<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Livewire Frontend</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="text-gray-800">

    <!-- Navbar -->
     <livewire:layout.navbar :key="session('locale')" />

   
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
            section.scrollIntoView({ behavior: 'smooth' });
        }
    });
});
</script>




</body>
</html>
