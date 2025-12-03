{{-- Header --}}
<div class="bg-white rounded-lg shadow border border-gray-200 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                {{ $viewMode === 'create' ? 'Buat Voucher Baru' : 'Edit Voucher' }}
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                {{ $viewMode === 'create' ? 'Buat voucher promosi code baru' : 'Update informasi voucher' }}
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
<form wire:submit.prevent="{{ $viewMode === 'create' ? 'createVoucher' : 'updateVoucher' }}">
    <div class="space-y-6">
        {{-- Basic Information --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-primary"></i>
                Basic Information
            </h3>

            <div class="space-y-4">
                {{-- Voucher Code --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Voucher Code <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" wire:model.blur="code" required
                            class="flex-1 px-4 py-2 border @error('code') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-primary uppercase"
                            placeholder="e.g., PROMO20, WELCOME50" {{ $viewMode === 'edit' ? 'readonly' : '' }}>
                        @if ($viewMode === 'create')
                            <button type="button" wire:click="generateCode"
                                class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg font-semibold transition-all">
                                <i class="fas fa-random"></i> Generate
                            </button>
                        @endif
                    </div>
                    @error('code')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Unique code that customers will use at checkout</p>
                </div>

                {{-- Voucher Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Voucher Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model.blur="name" required
                        class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="e.g., Summer Sale 2024, Welcome Discount">
                    @error('name')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description
                    </label>
                    <textarea wire:model="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="Internal notes about this voucher..."></textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Discount Settings --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-percentage text-primary"></i>
                Discount Settings
            </h3>

            <div class="space-y-4">
                {{-- Voucher Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Voucher Type <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        {{-- Percentage --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="type" value="percentage" class="sr-only peer">
                            <div
                                class="p-4 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/5">
                                <i class="fas fa-percent text-3xl text-gray-400 peer-checked:text-primary mb-2"></i>
                                <p class="font-semibold text-gray-700">Percentage</p>
                                <p class="text-xs text-gray-500 mt-1">% discount</p>
                            </div>
                        </label>

                        {{-- Fixed Amount --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="type" value="fixed" class="sr-only peer">
                            <div
                                class="p-4 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/5">
                                <i class="fas fa-dollar-sign text-3xl text-gray-400 peer-checked:text-primary mb-2"></i>
                                <p class="font-semibold text-gray-700">Fixed Amount</p>
                                <p class="text-xs text-gray-500 mt-1">Rp discount</p>
                            </div>
                        </label>

                        {{-- Bonus Item --}}
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="type" value="bonus" class="sr-only peer">
                            <div
                                class="p-4 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/5">
                                <i class="fas fa-gift text-3xl text-gray-400 peer-checked:text-primary mb-2"></i>
                                <p class="font-semibold text-gray-700">Bonus Item</p>
                                <p class="text-xs text-gray-500 mt-1">Free addon</p>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Discount Value --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            @if ($type === 'percentage')
                                Discount Percentage <span class="text-red-500">*</span>
                            @elseif($type === 'fixed')
                                Discount Amount <span class="text-red-500">*</span>
                            @else
                                Bonus Quantity <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <div class="relative">
                            @if ($type === 'percentage')
                                <input type="number" wire:model="value"
                                    class="w-full pr-10 pl-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="0" min="1" max="100" step="1">
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">%</span>
                            @elseif($type === 'fixed')
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" wire:model="value"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="0" min="0" step="1000">
                            @else
                                <input type="number" wire:model="value"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="0" min="1" step="1">
                            @endif
                        </div>
                        @error('value')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Min Order --}}
                    @if ($type !== 'bonus')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Minimum Order
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" wire:model="min_order"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="0" min="0" step="1000">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimum order to use this voucher (0 = no minimum)
                            </p>
                            @error('min_order')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                </div>

                {{-- Max Discount (only for percentage) --}}
                @if ($type === 'percentage')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Maximum Discount Cap
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" wire:model="max_discount"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                placeholder="Leave empty for no cap" min="0" step="1000">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Maximum discount amount (leave empty for unlimited)</p>
                        @error('max_discount')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                {{-- Example Calculation --}}
                <div class="bg-info-light border border-info/80 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-calculator text-info text-xl mt-1"></i>
                        <div>
                            <p class="font-semibold text-info-dark mb-2">Example Calculation:</p>
                            @if ($type === 'percentage')
                                <p class="text-sm text-info">
                                    Order: Rp 500,000 → Discount: {{ $value }}% = Rp
                                    {{ number_format(500000 * ($value / 100), 0, ',', '.') }}
                                    @if ($max_discount)
                                        (capped at Rp {{ number_format($max_discount, 0, ',', '.') }})
                                    @endif
                                </p>
                            @elseif($type === 'fixed')
                                <p class="text-sm text-info">
                                    Order: Rp 500,000 → Discount: Rp {{ number_format($value, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="text-sm text-info">
                                    Customer gets {{ $value }} free addon item(s)
                                </p>
                            @endif
                            @if ($min_order > 0 && $type !== 'bonus')
                                <p class="text-xs text-info mt-1">
                                    * Minimum order: Rp {{ number_format($min_order, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Usage Limits --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-users text-primary"></i>
                Usage Limits
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Total Usage Limit --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Total Usage Limit
                    </label>
                    <input type="number" wire:model="usage_limit"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="Leave empty for unlimited" min="1">
                    <p class="text-xs text-gray-500 mt-1">Maximum redemptions across all users</p>
                    @error('usage_limit')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Per User Usage Limit --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Per User Limit
                    </label>
                    <input type="number" wire:model="user_usage_limit"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="Leave empty for unlimited" min="1">
                    <p class="text-xs text-gray-500 mt-1">Maximum uses per customer</p>
                    @error('user_usage_limit')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Validity Period --}}
        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-alt text-primary"></i>
                Validity Period
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Start Date <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" wire:model.blur="start_date" required
                        class="w-full px-4 py-2 border @error('start_date') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">When the voucher becomes active</p>
                    @error('start_date')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        End Date <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" wire:model.blur="end_date" required
                        class="w-full px-4 py-2 border @error('end_date') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-primary">
                    <p class="text-xs text-gray-500 mt-1">When the voucher expires</p>
                    @error('end_date')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        <p class="text-xs text-gray-500">Voucher is available for customers to use</p>
                    </div>
                </label>
            </div>

            {{-- Display On Dashboard --}}
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-eye text-primary"></i>
                    Display On Dashboard
                </h3>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" wire:model="show_in_dashboard"
                        class="w-5 h-5 text-primary focus:ring-primary border-gray-300 rounded accent-primary">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Show</span>
                        <p class="text-xs text-gray-500">Voucher is displayed on the dashboard</p>
                    </div>
                </label>
            </div>
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
                        wire:target="{{ $viewMode === 'create' ? 'createVoucher' : 'updateVoucher' }}">
                        <i class="fas fa-save"></i>
                        {{ $viewMode === 'create' ? 'Create Voucher' : 'Update Voucher' }}
                    </span>
                    <span wire:loading wire:target="{{ $viewMode === 'create' ? 'createVoucher' : 'updateVoucher' }}">
                        <i class="fas fa-spinner fa-spin"></i>
                        Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>
