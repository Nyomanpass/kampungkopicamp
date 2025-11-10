<div class="space-y-6 md:p-6 bg-white rounded-lg">
    {{-- Flash Messages (reuse toast component) --}}
    <div class="fixed top-4 right-4 z-50 w-96 max-w-[calc(100vw-2rem)] space-y-3">
        @if (session()->has('success'))
            <div wire:key="success-{{ md5(session('success') . microtime()) }}" x-data="{
                show: false,
                progress: 100,
                duration: 4000,
                init() {
                    this.$nextTick(() => { this.show = true; });
                    const step = 100 / (this.duration / 50);
                    const interval = setInterval(() => {
                        this.progress = Math.max(0, this.progress - step);
                        if (this.progress <= 0) {
                            clearInterval(interval);
                            this.close();
                        }
                    }, 50);
                },
                close() {
                    this.show = false;
                    setTimeout(() => this.$el.remove(), 300);
                }
            }" x-show="show"
                x-cloak x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="relative rounded-xl border border-green-200 bg-gradient-to-br from-green-50 to-white text-green-800 shadow-lg ring-1 ring-green-100">
                <div class="flex items-start gap-3 p-4">
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                    <div class="flex-1">
                        <p class="font-medium">Success</p>
                        <p class="text-sm opacity-90">{{ session('success') }}</p>
                    </div>
                    <button @click="close()" class="p-1.5 rounded-md text-green-700 hover:bg-green-100/60">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="absolute left-0 bottom-0 h-1 bg-green-200/60 w-full overflow-hidden rounded-b-xl">
                    <div class="h-full bg-green-500 transition-all ease-linear" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div wire:key="error-{{ md5(session('error') . microtime()) }}" x-data="{
                show: false,
                progress: 100,
                duration: 5000,
                init() {
                    this.$nextTick(() => { this.show = true; });
                    const step = 100 / (this.duration / 50);
                    const interval = setInterval(() => {
                        this.progress = Math.max(0, this.progress - step);
                        if (this.progress <= 0) {
                            clearInterval(interval);
                            this.close();
                        }
                    }, 50);
                },
                close() {
                    this.show = false;
                    setTimeout(() => this.$el.remove(), 300);
                }
            }" x-show="show"
                x-cloak x-transition:enter="transform ease-out duration-300"
                x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="relative rounded-xl border border-red-200 bg-gradient-to-br from-red-50 to-white text-red-800 shadow-lg ring-1 ring-red-100">
                <div class="flex items-start gap-3 p-4">
                    <i class="fas fa-exclamation-circle text-2xl text-red-500"></i>
                    <div class="flex-1">
                        <p class="font-medium">Error</p>
                        <p class="text-sm opacity-90">{{ session('error') }}</p>
                    </div>
                    <button @click="close()" class="p-1.5 rounded-md text-red-700 hover:bg-red-100/60">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="absolute left-0 bottom-0 h-1 bg-red-200/60 w-full overflow-hidden rounded-b-xl">
                    <div class="h-full bg-red-500 transition-all ease-linear" :style="`width: ${progress}%`"></div>
                </div>
            </div>
        @endif
    </div>

    {{-- Switch Views Based on Mode --}}
    @if ($viewMode === 'list')
        @include('livewire.admin.products.list')
    @elseif($viewMode === 'create')
        @include('livewire.admin.products.form')
    @elseif($viewMode === 'edit')
        @include('livewire.admin.products.form')
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-gray-500/75 z-50 flex items-center justify-center p-4" x-data="{ show: false }"
            x-init="$nextTick(() => show = true)" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-show="show">
            <div class="bg-white rounded-lg max-w-md w-full p-6"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4" x-show="show"
                @click.away="$wire.set('showDeleteModal', false)">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-danger/20 mb-4">
                        <i class="fas fa-trash text-danger text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Produk</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Apakah anda yakin ingin menghapus produk
                        <strong>{{ $productToDelete->name ?? '' }}</strong>?<br>
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="flex items-center justify-center gap-3">
                        <button wire:click="$set('showDeleteModal', false)"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all">
                            Batal
                        </button>
                        <button wire:click="deleteProduct"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition-all">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($showQuickOverrideModal)
        <div class="fixed inset-0 bg-gray-500/75 z-50 flex items-center justify-center p-4" x-data="{ show: false }"
            x-init="$nextTick(() => show = true)" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="bg-white rounded-lg max-w-2xl w-full p-6" x-show="show"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                @click.away="$wire.set('showQuickOverrideModal', false)">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Quick Availability Override</h3>
                    <button wire:click="$set('showQuickOverrideModal', false)"
                        class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form wire:submit.prevent="applyQuickOverride">
                    <div class="space-y-4 max-h-[40vh] overflow-y-auto">
                        {{-- Date Range --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="overrideStartDate"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                @error('overrideStartDate')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="overrideEndDate"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                @error('overrideEndDate')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Stock Values --}}
                        <div class="grid grid-cols-2 gap-4">
                            @if ($type === 'accommodation')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Available Units
                                    </label>
                                    <input type="number" wire:model="overrideUnits" min="0"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                        placeholder="Leave empty to keep current">
                                    <p class="text-xs text-gray-500 mt-1">For accommodation/area rental</p>
                                    @error('overrideUnits')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            @elseif ($type === 'touring')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Available Seats
                                    </label>
                                    <input type="number" wire:model="overrideSeats" min="0"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                        placeholder="Leave empty to keep current">
                                    <p class="text-xs text-gray-500 mt-1">For touring products</p>
                                    @error('overrideSeats')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        {{-- Override Reason --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Alasan (Optional)
                            </label>
                            <textarea wire:model="overrideReason" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                placeholder="e.g., Maintenance, Private Event, Holiday Rush..."></textarea>
                            @error('overrideReason')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Info Alert --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <div class="text-sm text-blue-700">
                                    <p class="font-semibold mb-1">Catatan Penting:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Ini akan mengubah seluruh ketersediaan untuk semua tanggal yang dipilih</li>
                                        <li>Booking yang sudah ada tidak akan terpengaruh</li>

                                        <li>Biarkan unit/kursi kosong untuk mempertahankan nilai saat ini</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                        <button type="button" wire:click="$set('showQuickOverrideModal', false)"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-primary hover:bg-light-primary text-white px-6 py-2 rounded-lg font-semibold transition-all flex items-center gap-2"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="applyQuickOverride">
                                <i class="fas fa-check"></i>
                                Apply Override
                            </span>
                            <span wire:loading wire:target="applyQuickOverride">
                                <i class="fas fa-spinner fa-spin"></i>
                                Applying...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
