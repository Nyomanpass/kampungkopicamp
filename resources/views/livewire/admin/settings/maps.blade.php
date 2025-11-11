{{-- Google Maps Settings --}}
<div class="space-y-6">
    <form wire:submit.prevent="saveGoogleMaps" class="space-y-4">
        {{-- Embed URL --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Google Maps Embed URL <span class="text-red-500">*</span>
            </label>
            <textarea wire:model="google_maps_embed_url" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent font-mono text-sm
                @error('google_maps_embed_url') border-red-500 @enderror"
                placeholder="https://www.google.com/maps/embed?pb=..."></textarea>
            @error('google_maps_embed_url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                Cara mendapatkan: Buka Google Maps → Pilih lokasi → Share → Embed a map → Copy HTML
            </p>
        </div>

        {{-- Preview --}}
        @if ($google_maps_embed_url)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preview
                </label>
                <div class="rounded-lg overflow-hidden border border-gray-300">
                    <iframe src="{{ $google_maps_embed_url }}" class="w-full h-64" style="border:0;" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        @endif

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>
