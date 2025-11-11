{{-- Social Media Links --}}
<div class="space-y-6">
    <form wire:submit.prevent="saveSocialMedia" class="space-y-4">
        {{-- Facebook --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook
            </label>
            <input type="url" wire:model="social_facebook"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="https://facebook.com/kampungkopicamp">
            @error('social_facebook')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Instagram --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram
            </label>
            <input type="url" wire:model="social_instagram"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="https://instagram.com/kampungkopicamp">
            @error('social_instagram')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- TikTok --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fab fa-tiktok text-gray-800 mr-2"></i>TikTok
            </label>
            <input type="url" wire:model="social_tiktok"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="https://tiktok.com/@kampungkopicamp">
            @error('social_tiktok')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- YouTube --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube
            </label>
            <input type="url" wire:model="social_youtube"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="https://youtube.com/@kampungkopicamp">
            @error('social_youtube')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>
