<div class="fixed inset-0 bg-gray-500/75 z-50 flex items-center justify-center p-4 backdrop-blur">
    <div class="bg-white rounded-lg max-w-md w-full" @click.away="$wire.set('showStockModal', false)">
        {{-- Modal Header --}}
        <div class="border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-warehouse text-primary"></i>
                    Adjust Stock
                </h3>
                <button wire:click="$set('showStockModal', false)" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <form wire:submit.prevent="adjustStock">
            <div class="p-6 space-y-4">
                {{-- Adjustment Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Type</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="stockAdjustmentType" value="add"
                                class="sr-only peer">
                            <div
                                class="p-4 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-green-500 peer-checked:bg-green-50">
                                <i
                                    class="fas fa-plus-circle text-3xl text-gray-400 peer-checked:text-green-500 mb-2"></i>
                                <p class="font-semibold text-gray-700">Add Stock</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="stockAdjustmentType" value="reduce"
                                class="sr-only peer">
                            <div
                                class="p-4 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-red-500 peer-checked:bg-red-50">
                                <i
                                    class="fas fa-minus-circle text-3xl text-gray-400 peer-checked:text-red-500 mb-2"></i>
                                <p class="font-semibold text-gray-700">Reduce Stock</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Quantity --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" wire:model="stockAdjustmentQuantity"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="Enter quantity" min="1" required>
                    @error('stockAdjustmentQuantity')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Reason --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Reason (Optional)
                    </label>
                    <textarea wire:model="stockAdjustmentReason" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="e.g., Restocking, Damaged items, Loss..."></textarea>
                    @error('stockAdjustmentReason')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="border-t border-gray-200 px-6 py-4 flex items-center justify-end gap-3">
                <button type="button" wire:click="$set('showStockModal', false)"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2 rounded-lg font-semibold transition-all flex items-center gap-2
                    {{ $stockAdjustmentType === 'add' ? 'bg-primary hover:bg-primary/70 text-white' : 'bg-danger hover:bg-danger/70 text-white' }}"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="adjustStock">
                        <i class="fas {{ $stockAdjustmentType === 'add' ? 'fa-plus' : 'fa-minus' }}"></i>
                        {{ $stockAdjustmentType === 'add' ? 'Add Stock' : 'Reduce Stock' }}
                    </span>
                    <span wire:loading wire:target="adjustStock">
                        <i class="fas fa-spinner fa-spin"></i>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
