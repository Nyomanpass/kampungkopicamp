<div class="bg-white rounded-lg border border-gray-200 hover:shadow-md transition-all overflow-hidden">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <a href="{{ route('package.detail', $product->slug) }}">
        <div class="bg-gray-100 aspect-[4/3] overflow-hidden">
            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" alt=""
                class=" w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 ">
        </div>
        <div class="h-auto p-4 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                <div class="flex gap-2 text-xs">
                    <div class="flex gap-2 text-xs">
                        {{-- Kapasitas --}}
                        <span class="flex items-center gap-1">
                            <i class="fas fa-users"></i>
                            {{ $product->capacity_per_unit ?? 1 }} 
                            @if($lang === 'en')
                                {{ ($product->capacity_per_unit ?? 1) > 1 ? 'people' : 'person' }}
                            @else
                                orang
                            @endif
                        </span>

                        {{-- Sesi/Durasi --}}
                        <span class="flex items-center gap-1">
                            <i class="fas fa-clock"></i>
                            @if($lang === 'en')
                                {{ $product->duration_type === 'daily' ? 'per day' : 'per session' }}
                            @else
                                {{ $product->duration_type === 'daily' ? 'per hari' : 'per sesi' }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col items-end mb-2 mt-7">
                <p class="text-sm">{{ $lang === 'en' ? 'starting from' : 'mulai dari' }}</p>
                <p class="text-primary text-xl font-bold">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>


        </div>
    </a>
</div>
