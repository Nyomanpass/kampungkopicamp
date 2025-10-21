<div class="bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all overflow-hidden">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <a href="{{ route('package.detail', $product->slug) }}">
        <div class="h-48 overflow-hidden">
            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 bg-gray-200">
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
            <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>

            <div>
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-2">
                    {{ $product->availability->count() }} Tersedia
                </span>
                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                    Durasi: {{ $product->duration }} Hari
                </span>
            </div>
            <div class="flex items-center justify-between mt-10">
                <span class="text-light-primary font-bold text-lg">Rp
                    {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="text-gray-500 text-sm">/ paket</span>
            </div>
        </div>
    </a>
</div>
