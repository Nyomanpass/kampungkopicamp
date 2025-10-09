<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col">
        <div class="p-6 text-center border-b">
            <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
        </div>

        <nav class="flex-1 px-4 py-6">
            <ul class="space-y-2">
                <li>
                    <a 
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.paket-wisata') }}"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                        <i class="fa-solid fa-suitcase-rolling"></i>
                        Paket Wisata
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.article') }}"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                        <i class="fa-solid fa-newspaper"></i>
                        Artikel / Blog
                    </a>
                </li>
                <li>
                    <a  
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                        <i class="fa-solid fa-envelope"></i>
                        Kontak
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-6 border-t">
            <button class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
                Logout
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto p-6">
        <div class="max-w-7xl mx-auto">
            {{ $slot ?? '' }}
        </div>
    </main>

    @livewireScripts
</body>
</html>
