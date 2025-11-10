<div class="">
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Create Manual Booking (Walk-in Guest)</h2>

        <form wire:submit.prevent="createBooking">
            {{-- Customer Information --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-primary"></i>
                    Customer Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="customerName"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="John Doe">
                        @error('customerName')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="customerPhone"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="081234567890">
                        @error('customerPhone')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email (Optional)
                        </label>
                        <input type="email" wire:model="customerEmail"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="email@example.com">
                        @error('customerEmail')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Booking Details --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-primary"></i>
                    Booking Details
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Product Type --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Product Type <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ $productType === 'accommodation' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                <input type="radio" wire:model.live="productType" value="accommodation"
                                    class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-bed text-2xl mb-2 {{ $productType === 'accommodation' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <p
                                        class="font-semibold {{ $productType === 'accommodation' ? 'text-primary' : 'text-gray-700' }}">
                                        Accommodation</p>
                                </div>
                            </label>

                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ $productType === 'touring' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                <input type="radio" wire:model.live="productType" value="touring" class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-hiking text-2xl mb-2 {{ $productType === 'touring' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <p
                                        class="font-semibold {{ $productType === 'touring' ? 'text-primary' : 'text-gray-700' }}">
                                        Touring</p>
                                </div>
                            </label>

                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all {{ $productType === 'area_rental' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                <input type="radio" wire:model.live="productType" value="area_rental" class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-map-marked-alt text-2xl mb-2 {{ $productType === 'area_rental' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <p
                                        class="font-semibold {{ $productType === 'area_rental' ? 'text-primary' : 'text-gray-700' }}">
                                        Area Rental</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Product Selection --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Product <span class="text-red-500">*</span>
                        </label>
                        <select wire:model.live="productId"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} - Rp
                                    {{ number_format($product->price, 0, ',', '.') }}/{{ $product->pricing_type }}
                                </option>
                            @endforeach
                        </select>
                        @error('productId')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Check-in Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Check-in Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model.live="checkInDate" min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('checkInDate')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Check-out Date --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Check-out Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model.live="checkOutDate" min="{{ $checkInDate ?: date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        @error('checkOutDate')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Duration (Auto-calculated) --}}
                    @if ($nightCount > 0)
                        <div class="md:col-span-2">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <p class="text-sm text-blue-800">
                                    <i class="fas fa-moon mr-2"></i>
                                    Duration: <span class="font-semibold">{{ $nightCount }}
                                        {{ $productType === 'touring' ? 'day(s)' : 'night(s)' }}</span>
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- People Count --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            People Count <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            {{-- <button type="button" wire:click="$set('peopleCount', {{ max(1, $peopleCount - 1) }})"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-10 h-10 rounded-lg font-bold transition-colors">
                                -
                            </button> --}}
                            <input type="number" wire:model.live="peopleCount" min="1"
                                class="flex-1 text-center px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            {{-- <button type="button" wire:click="$set('peopleCount', {{ $peopleCount + 1 }})"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-10 h-10 rounded-lg font-bold transition-colors">
                                +
                            </button> --}}
                        </div>
                        @error('peopleCount')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Units (Auto-calculated) --}}
                    @if ($unitCount > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Required Units
                            </label>
                            <input type="number" value="{{ $unitCount }}" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                        </div>
                    @endif


                    {{-- Stock Check --}}
                    @if ($stockMessage)
                        <div class="md:col-span-2">
                            <div
                                class="border rounded-lg p-3 {{ $stockAvailable ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                <p
                                    class="text-sm {{ $stockAvailable ? 'text-green-800' : 'text-red-800' }} flex items-center gap-2">
                                    <i class="fas {{ $stockAvailable ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $stockMessage }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Add-ons --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-primary"></i>
                    Add-ons (Optional)
                </h3>

                @if (count($addons) > 0)
                    <div class="space-y-3">
                        @foreach ($addons as $addon)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $addon->name }}</h4>
                                        <p class="text-sm text-gray-600">Rp
                                            {{ number_format($addon->price, 0, ',', '.') }}/{{ $addon->pricing_type }}
                                        </p>
                                    </div>

                                    @if (isset($selectedAddons[$addon->id]))
                                        <button type="button" wire:click="removeAddon({{ $addon->id }})"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            <i class="fas fa-times mr-1"></i>Remove
                                        </button>
                                    @else
                                        <button type="button" wire:click="addAddon({{ $addon->id }})"
                                            class="bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            <i class="fas fa-plus mr-1"></i>Add
                                        </button>
                                    @endif
                                </div>

                                @if (isset($selectedAddons[$addon->id]))
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-1">
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                                                <div class="flex items-center gap-2">
                                                    <button type="button"
                                                        wire:click="updateAddonQty({{ $addon->id }}, 'decrement')"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded font-bold">
                                                        -
                                                    </button>
                                                    <input type="number"
                                                        wire:model.live="selectedAddons.{{ $addon->id }}.qty"
                                                        min="1"
                                                        class="flex-1 text-center px-2 py-1 border border-gray-300 rounded">
                                                    <button type="button"
                                                        wire:click="updateAddonQty({{ $addon->id }}, 'increment')"
                                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded font-bold">
                                                        +
                                                    </button>
                                                </div>
                                            </div>

                                            @if ($addon->pricing_type === 'per_hour')
                                                <div class="flex-1">
                                                    <label
                                                        class="block text-xs font-medium text-gray-700 mb-1">Hours</label>
                                                    <input type="number"
                                                        wire:model.live="selectedAddons.{{ $addon->id }}.hours"
                                                        min="0"
                                                        class="w-full px-2 py-1 border border-gray-300 rounded">
                                                </div>
                                            @endif

                                            @if ($addon->pricing_type === 'per_slot')
                                                <div class="flex-1">
                                                    <label
                                                        class="block text-xs font-medium text-gray-700 mb-1">Slots</label>
                                                    <input type="number"
                                                        wire:model.live="selectedAddons.{{ $addon->id }}.slots"
                                                        min="0"
                                                        class="w-full px-2 py-1 border border-gray-300 rounded">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No add-ons available</p>
                @endif
            </div>

            {{-- Pricing Summary --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-calculator text-primary"></i>
                    Pricing
                </h3>

                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Product Total:</span>
                        <span class="font-semibold">Rp {{ number_format($productPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Add-ons Total:</span>
                        <span class="font-semibold">Rp {{ number_format($addonsTotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm pt-2 border-t border-gray-300">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    {{-- Voucher --}}
                    <div class="pt-2 border-t border-gray-300">
                        <div class="flex gap-2 mb-2">
                            <input type="text" wire:model="voucherCode" placeholder="Enter voucher code"
                                class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <button type="button" wire:click="applyVoucher"
                                class="bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Apply
                            </button>
                        </div>
                        @if ($appliedVoucher)
                            <div class="bg-green-50 border border-green-200 rounded p-2 text-xs text-green-800">
                                ✓ Voucher <strong>{{ $appliedVoucher->code }}</strong> applied
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Discount:</span>
                        <span class="font-semibold text-green-600">- Rp
                            {{ number_format($discountAmount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-lg font-bold pt-2 border-t-2 border-gray-400">
                        <span>TOTAL:</span>
                        <span class="text-primary">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-credit-card text-primary"></i>
                    Payment
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Payment Method <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
            {{ $paymentMethod === 'cash' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                <input type="radio" wire:model.live="paymentMethod" value="cash"
                                    class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-money-bill-wave text-3xl mb-2 {{ $paymentMethod === 'cash' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <p
                                        class="font-semibold {{ $paymentMethod === 'cash' ? 'text-primary' : 'text-gray-700' }}">
                                        Cash</p>
                                    <p class="text-xs text-gray-500">Tunai</p>
                                </div>
                                @if ($paymentMethod === 'cash')
                                    <div
                                        class="absolute top-2 right-2 w-6 h-6 bg-primary rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                @endif
                            </label>

                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
            {{ $paymentMethod === 'qris' ? 'border-primary bg-primary/5' : 'border-gray-300 hover:border-primary/50' }}">
                                <input type="radio" wire:model.live="paymentMethod" value="qris"
                                    class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-qrcode text-3xl mb-2 {{ $paymentMethod === 'qris' ? 'text-primary' : 'text-gray-400' }}"></i>
                                    <p
                                        class="font-semibold {{ $paymentMethod === 'qris' ? 'text-primary' : 'text-gray-700' }}">
                                        QRIS</p>
                                    <p class="text-xs text-gray-500">Scan QR</p>
                                </div>
                                @if ($paymentMethod === 'qris')
                                    <div
                                        class="absolute top-2 right-2 w-6 h-6 bg-primary rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                @endif
                            </label>
                        </div>
                        @error('paymentMethod')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                        <select wire:model.live="paymentStatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <option value="paid">Paid</option>
                            <option value="pending_payment">Pending</option>
                        </select>
                    </div>

                    @if ($paymentStatus === 'paid')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amount Received</label>
                            <input type="number" wire:model.live="amountReceived"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            @error('amountReceived')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date</label>
                            <input type="date" wire:model="paymentDate"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                        </div>
                    @endif

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Notes (Optional)</label>
                        <textarea wire:model="paymentNotes" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                            placeholder="Additional payment information..."></textarea>
                    </div>
                </div>
            </div>

            {{-- Special Requests --}}
            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-sticky-note text-primary"></i>
                    Special Requests (Optional)
                </h3>

                <textarea wire:model="specialRequests" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                    placeholder="Any special requests from the customer..."></textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <button type="button" wire:click="switchToList"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-semibold transition-all">
                    Cancel
                </button>
                <button type="submit" :disabled="!{{ $stockAvailable ? 'true' : 'false' }}"
                    class="bg-primary hover:bg-light-primary text-white px-6 py-2.5 rounded-lg font-semibold transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Create Booking
                </button>
            </div>
        </form>
    </div>
</div>
