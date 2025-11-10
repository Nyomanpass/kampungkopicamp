<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button wire:click="switchToList" class="text-gray-600 hover:text-gray-900 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $productId ? 'Edit Produk' : 'Buat Produk Baru' }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $productId ? 'Update pengaturan dan informasi produk.' : 'Isi data yang diperlukan untuk membuat produk baru' }}
                </p>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="{{ $productId ? 'updateProduct' : 'createProduct' }}">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Main Info --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Basic Information --}}
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary"></i>
                        Basic Information
                    </h3>

                    <div class="space-y-4">
                        {{-- Product Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Enter product name...">
                            @error('name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Product Type --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Product Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <label
                                    class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'accommodation' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                    <input type="radio" wire:model.live="type" value="accommodation" class="sr-only">
                                    <i
                                        class="fas fa-bed text-3xl mb-2 {{ $type === 'accommodation' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <span
                                        class="font-semibold text-sm {{ $type === 'accommodation' ? 'text-primary' : 'text-gray-700' }}">Accommodation</span>
                                </label>

                                <label
                                    class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'touring' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                    <input type="radio" wire:model.live="type" value="touring" class="sr-only">
                                    <i
                                        class="fas fa-hiking text-3xl mb-2 {{ $type === 'touring' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <span
                                        class="font-semibold text-sm {{ $type === 'touring' ? 'text-primary' : 'text-gray-700' }}">Touring</span>
                                </label>

                                <label
                                    class="relative flex flex-col items-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'area_rental' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                    <input type="radio" wire:model.live="type" value="area_rental" class="sr-only">
                                    <i
                                        class="fas fa-map-marked-alt text-3xl mb-2 {{ $type === 'area_rental' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <span
                                        class="font-semibold text-sm {{ $type === 'area_rental' ? 'text-primary' : 'text-gray-700' }}">Area
                                        Rental</span>
                                </label>
                            </div>
                            @error('type')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Enter product description..."></textarea>
                            @error('description')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Pricing & Capacity --}}
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-dollar-sign text-primary"></i>
                        Pricing & Capacity
                    </h3>

                    <div class="space-y-4">
                        {{-- Price & Duration Type --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Base Price <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" wire:model="price"
                                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                        placeholder="0" min="0">
                                </div>
                                @error('price')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Duration Type <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="duration_type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    <option value="daily">Per Day</option>
                                    <option value="hourly">Per Hour</option>
                                    <option value="multi_day">Multi Day</option>
                                </select>
                                @error('duration_type')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- ✅ Conditional Fields Based on Type --}}
                        @if ($type === 'touring')
                            {{-- Max Participant (for touring only) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Max Participant <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="max_participant"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="10" min="1">
                                <p class="text-xs text-gray-500 mt-1">Maks orang per sesi</p>
                                @error('max_participant')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            {{-- Capacity Per Unit (for accommodation/area_rental only) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Capacity Per Unit <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="capacity_per_unit"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="2" min="1">
                                <p class="text-xs text-gray-500 mt-1">Maks orang per unit</p>
                                @error('capacity_per_unit')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Image Gallery --}}
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-images text-primary"></i>
                        Image Gallery
                    </h3>

                    {{-- Existing Images --}}
                    @if (!empty($existingImages))
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Images (First image is cover)</p>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach ($existingImages as $index => $imageUrl)
                                    <div class="relative group">
                                        <img src="{{ $imageUrl }}" alt="Product Image"
                                            class="w-full h-32 object-cover rounded-lg border-2 {{ $index === 0 ? 'border-primary' : 'border-gray-300' }}">

                                        {{-- Main Badge --}}
                                        @if ($index === 0)
                                            <span
                                                class="absolute top-1 left-1 bg-primary text-white text-xs font-semibold px-2 py-0.5 rounded">
                                                COVER
                                            </span>
                                        @endif

                                        {{-- Actions --}}
                                        <div
                                            class="absolute inset-0 bg-black/50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                            @if ($index !== 0)
                                                <button type="button"
                                                    wire:click="setMainImage('{{ $imageUrl }}')"
                                                    class="bg-white text-gray-700 px-2 py-1 rounded text-xs font-semibold hover:bg-gray-100"
                                                    title="Set as cover">
                                                    <i class="fas fa-star"></i>
                                                </button>
                                            @endif
                                            <button type="button"
                                                wire:click="markImageForDeletion('{{ $imageUrl }}')"
                                                class="bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold hover:bg-red-700"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Upload New Images --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Gambar Baru
                        </label>
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                            <input type="file" wire:model="images" multiple accept="image/*" class="hidden"
                                id="imageUpload">
                            <label for="imageUpload" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600 mb-1">
                                    Click to upload or drag and drop
                                </p>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, JPEG up to 2MB (Multiple files allowed)
                                </p>
                            </label>
                        </div>

                        {{-- Image Preview --}}
                        @if (!empty($images))
                            <div class="mt-3 grid grid-cols-4 gap-3">
                                @foreach ($images as $image)
                                    <div class="relative">
                                        <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                        <span
                                            class="absolute top-1 right-1 bg-green-500 text-white text-xs font-semibold px-2 py-0.5 rounded">
                                            NEW
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @error('images.*')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror

                        <div wire:loading wire:target="images" class="mt-2 text-sm text-primary">
                            <i class="fas fa-spinner fa-spin"></i> Uploading...
                        </div>
                    </div>


                </div>

                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-check-circle text-primary"></i>
                        Facilities & Amenities
                    </h3>

                    {{-- Available Facilities (Checkboxes) --}}
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700 mb-3">Select Facilities:</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach ($availableFacilities as $facility)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" wire:click="addFacility('{{ $facility }}')"
                                        {{ in_array($facility, $facilities) ? 'checked' : '' }}
                                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                                    <span class="text-sm text-gray-700 group-hover:text-primary transition-colors">
                                        {{ $facility }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Custom Facility Input --}}
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Add Custom Facility:</p>
                        <div class="flex gap-2">
                            <input type="text" wire:model="facilityInput"
                                wire:keydown.enter.prevent="addCustomFacility"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Type and press Enter or click Add...">
                            <button type="button" wire:click="addCustomFacility"
                                class="bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg font-semibold transition-all">
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
                    </div>

                    {{-- Selected Facilities Tags --}}
                    @if (!empty($facilities))
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-3">Selected Facilities:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($facilities as $index => $facility)
                                    <span
                                        class="inline-flex items-center gap-2 bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle"></i>
                                        {{ $facility }}
                                        <button type="button" wire:click="removeFacility({{ $index }})"
                                            class="hover:text-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Settings --}}
            <div class="space-y-6">
                {{-- Default Stock Settings --}}
                @if (!$productId)
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-warehouse text-primary"></i>
                            Default Stock
                        </h3>

                        <p class="text-xs text-gray-600 mb-4">
                            <i class="fas fa-info-circle"></i>
                            Data ini akan digunakan sebagai stok awal saat membuat produk baru untuk 2 bulan kedepan.
                            Stok
                            ini dapat diubah per
                            hari nantinya.
                        </p>

                        <div class="space-y-4">
                            @if ($type !== 'touring')
                                {{-- Default Units --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Default Units
                                    </label>
                                    <input type="number" wire:model="default_units"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                        placeholder="10" min="0">
                                    <p class="text-xs text-gray-500 mt-1">Available units per day</p>
                                    @error('default_units')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            @else
                                {{-- Default Seats (for touring) --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Default Seats
                                    </label>
                                    <input type="number" wire:model="default_seats"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                        placeholder="20" min="0">
                                    <p class="text-xs text-gray-500 mt-1">Available seats per day</p>
                                    @error('default_seats')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Status --}}
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-primary"></i>
                        Status
                    </h3>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" wire:model="is_active"
                            class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary accent-primary">
                        <div>
                            <p class="font-semibold text-gray-900">Active Product</p>
                            <p class="text-xs text-gray-600">Produk akan ditampilkan dan dapat dipesan</p>
                        </div>
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <div class="space-y-3">
                        <button type="submit"
                            class="w-full bg-primary hover:bg-light-primary text-white px-6 py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove
                                wire:target="{{ $productId ? 'updateProduct' : 'createProduct' }}">
                                <i class="fas {{ $productId ? 'fa-save' : 'fa-plus-circle' }}"></i>
                                {{ $productId ? 'Update Produk' : 'Buat Produk' }}
                            </span>
                            <span wire:loading wire:target="{{ $productId ? 'updateProduct' : 'createProduct' }}">
                                <i class="fas fa-spinner fa-spin"></i>
                                Processing...
                            </span>
                        </button>

                        @if ($productId)
                            {{-- <button type="button" wire:click="openQuickOverride({{ $productId }})"
                                class="w-full bg-primary hover:bg-primary/70 text-white px-3 py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-1">
                                <i class="fas fa-calendar-alt"></i> Quick Override Stock
                            </button> --}}
                            <button type="button" wire:click="confirmDelete({{ $productId }})"
                                class="w-full bg-danger hover:bg-danger/70 text-white px-6 py-3 rounded-lg font-semibold transition-all">
                                <i class="fas fa-trash"></i>
                                Hapus Produk
                            </button>
                        @endif
                        <button type="button" wire:click="switchToList"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-all">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
