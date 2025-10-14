<div>
    <nav class="flex-1 px-4 py-6">
    <ul class="space-y-2">
        <li>
            <a class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-house"></i>
                {{ $texts['dashboard'] }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.paket-wisata') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-suitcase-rolling"></i>
                {{ $texts['paket_wisata'] }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.article') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-newspaper"></i>
                {{ $texts['artikel'] }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.category') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-newspaper"></i>
                {{ $texts['category'] }}
            </a>
        </li>
        <li>
            <a class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-envelope"></i>
                {{ $texts['kontak'] }}
            </a>
        </li>
    </ul>
</nav>

<div class="p-6 border-t">
    <button class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
        {{ $texts['logout'] }}
    </button>
</div>

</div>