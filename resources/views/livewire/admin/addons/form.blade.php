{{-- Header --}}
<div class="bg-white rounded-lg shadow border border-gray-200 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                {{ $viewMode === 'create' ? 'Buat Addon Baru' : 'Edit Addon' }}
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                {{ $viewMode === 'create' ? 'Tambahkan layanan atau item tambahan baru' : 'Perbarui informasi addon' }}
            </p>
        </div>
        <button wire:click="switchToList"
            class="text-gray-600 hover:text-gray-800 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back to List</span>
        </button>
    </div>
</div>

{{-- Form --}}
<form wire:submit.prevent="{{ $viewMode === 'create' ? 'createAddon' : 'updateAddon' }}">
    <div class="space-y-6">
        {{-- Basic Information --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-primary"></i>
                Basic Information
            </h3>

            <div class="space-y-4">
                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Addon Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="e.g., BBQ Equipment, Fishing Rod, Meal Package">
                    @error('name')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea wire:model="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="Describe what this addon includes..."></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Addon Image
                    </label>

                    @if ($existingImage && !$image)
                        <div class="mb-3">
                            <img src="{{ $existingImage }}" alt="Current Image"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    @if ($image)
                        <div class="mb-3">
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" wire:model="image" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">Recommended: 500x500px, Max 2MB</p>
                    @error('image')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>




            </div>



        </div>

        {{-- Pricing --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-dollar-sign text-primary"></i>
                Pricing
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Pricing Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pricing Type <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="pricing_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        <option value="per_booking">Per Booking (Fixed)</option>
                        <option value="per_unit_per_night">Per Unit/Night</option>
                        <option value="per_person">Per Person</option>
                        <option value="per_hour">Per Hour</option>
                        <option value="per_slot">Per Slot</option>
                    </select>
                    @error('pricing_type')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror

                    {{-- Pricing Example --}}
                    <div class="mt-2 text-xs text-gray-600 bg-blue-50 border border-blue-200 rounded p-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        @if ($pricing_type === 'per_booking')
                            <strong>Example:</strong> Shuttle service costs Rp 50,000 per booking
                        @elseif($pricing_type === 'per_unit_per_night')
                            <strong>Example:</strong> Extra tent Rp 20,000 × 2 tents × 3 nights = Rp 120,000
                        @elseif($pricing_type === 'per_person')
                            <strong>Example:</strong> Meal package Rp 30,000 × 5 people = Rp 150,000
                        @elseif($pricing_type === 'per_hour')
                            <strong>Example:</strong> Photography Rp 100,000 × 2 hours = Rp 200,000
                        @elseif($pricing_type === 'per_slot')
                            <strong>Example:</strong> Morning fishing session Rp 75,000 per slot
                        @endif
                    </div>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Base Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" wire:model="price"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                            placeholder="0" min="0" step="1000">
                    </div>
                    @error('price')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Inventory Management --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-warehouse text-primary"></i>
                    Inventory Management
                </h3>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="has_inventory"
                        class="w-5 h-5 text-primary focus:ring-primary border-gray-300 rounded">
                    <span class="text-sm font-medium text-gray-700">Track inventory</span>
                </label>
            </div>

            @if ($has_inventory)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Stock Quantity --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="stock_quantity"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                            placeholder="0" min="0">
                        <p class="text-xs text-gray-500 mt-1">Available units in stock</p>
                        @error('stock_quantity')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Low Stock Threshold --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Low Stock Alert <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="low_stock_threshold"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                            placeholder="5" min="0">
                        <p class="text-xs text-gray-500 mt-1">Alert when stock reaches this level</p>
                        @error('low_stock_threshold')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-infinity text-4xl mb-2"></i>
                    <p class="text-sm">This addon has unlimited availability</p>
                </div>
            @endif
        </div>

        {{-- Quantity Limits --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-sliders-h text-primary"></i>
                Quantity Limits
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Min Quantity --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Minimum Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" wire:model="min_quantity"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="1" min="1">
                    <p class="text-xs text-gray-500 mt-1">Minimum units per booking</p>
                    @error('min_quantity')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Max Quantity --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Maximum Quantity
                    </label>
                    <input type="number" wire:model="max_quantity"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="Leave empty for unlimited" min="1">
                    <p class="text-xs text-gray-500 mt-1">Maximum units per booking (optional)</p>
                    @error('max_quantity')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-toggle-on text-primary"></i>
                Status
            </h3>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" wire:model="is_active"
                    class="w-5 h-5 text-primary focus:ring-primary border-gray-300 rounded accent-primary">
                <div>
                    <span class="text-sm font-medium text-gray-700">Active</span>
                    <p class="text-xs text-gray-500">Addon is available for booking</p>
                </div>
            </label>
        </div>

        {{-- Form Actions --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <div class="flex items-center justify-end gap-3">
                <button type="button" wire:click="switchToList"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit"
                    class="bg-primary hover:bg-light-primary text-white px-6 py-2 rounded-lg font-semibold transition-all flex items-center gap-2">
                    <span wire:loading.remove
                        wire:target="{{ $viewMode === 'create' ? 'createAddon' : 'updateAddon' }}">
                        <i class="fas fa-save"></i>
                        {{ $viewMode === 'create' ? 'Create Addon' : 'Update Addon' }}
                    </span>
                    <span wire:loading wire:target="{{ $viewMode === 'create' ? 'createAddon' : 'updateAddon' }}">
                        <i class="fas fa-spinner fa-spin"></i>
                        Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
