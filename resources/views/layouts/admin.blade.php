<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}"> <!-- PERBAIKAN: Membuat atribut lang dinamis -->
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <!-- Tambahkan 'flex-col' dan 'justify-between' agar konten bisa diatur ke atas/bawah -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between"> 
        <div>
            <div class="p-6 text-center border-b">
                <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
            </div>

            <!-- Bagian ini berisi Navigasi dan tombol Logout (sesuai admin-sidebar.blade.php lama Anda) -->
            <livewire:layout.admin-sidebar :key="session('locale')" />
             <!-- Language Switcher diletakkan di bagian paling bawah sidebar -->
        <div class="p-6 border-t">
            <livewire:language-switcher :key="session('locale')" />
        </div>

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
