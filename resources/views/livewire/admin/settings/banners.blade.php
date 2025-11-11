{{-- Banners Management --}}
<div class="space-y-6">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Banner Images</h3>

        {{-- Upload Form --}}
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
            <input type="file" wire:model="newBannerImages" multiple accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary/90">
            @error('newBannerImages.*')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div wire:loading wire:target="newBannerImages" class="mt-2 text-sm text-gray-600">
                <i class="fas fa-spinner fa-spin mr-2"></i>Uploading...
            </div>
        </div>

        @if (count($newBannerImages) > 0)
            <button wire:click="uploadBanners"
                class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                <i class="fas fa-upload mr-2"></i>Upload {{ count($newBannerImages) }} Banner(s)
            </button>
        @endif
    </div>

    {{-- Current Banners --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Banners</h3>

        @if (count($banners) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($banners as $banner)
                    <div class="relative group rounded-lg overflow-hidden shadow-md">
                        <img src="{{ Storage::url($banner['image']) }}" alt="Banner {{ $banner['id'] }}"
                            class="w-full h-48 object-cover">
                        <div
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button wire:click="deleteBanner({{ $banner['id'] }})"
                                wire:confirm="Yakin ingin menghapus banner ini?"
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-images text-4xl mb-3"></i>
                <p>Belum ada banner. Upload banner pertama Anda!</p>
            </div>
        @endif
    </div>
</div>
