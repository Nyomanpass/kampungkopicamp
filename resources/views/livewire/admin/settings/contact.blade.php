{{-- Contact Information --}}
<div class="space-y-6">
    <form wire:submit.prevent="saveContactInfo" class="space-y-4">
        {{-- WhatsApp --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                WhatsApp Number <span class="text-red-500">*</span>
            </label>
            <input type="text" wire:model="contact_whatsapp"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                @error('contact_whatsapp') border-red-500 @enderror"
                placeholder="628123456789">
            @error('contact_whatsapp')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input type="email" wire:model="contact_email"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                @error('contact_email') border-red-500 @enderror"
                placeholder="info@kampungkopicamp.com">
            @error('contact_email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Phone Number <span class="text-red-500">*</span>
            </label>
            <input type="text" wire:model="contact_phone"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                @error('contact_phone') border-red-500 @enderror"
                placeholder="+62 812-3456-7890">
            @error('contact_phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Address --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Address <span class="text-red-500">*</span>
            </label>
            <textarea wire:model="contact_address" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                @error('contact_address') border-red-500 @enderror"
                placeholder="Jl. Pupuan, Tabanan, Bali"></textarea>
            @error('contact_address')
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
