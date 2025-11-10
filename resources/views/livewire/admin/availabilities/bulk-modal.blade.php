<div class="fixed inset-0 bg-gray-500/75 z-50 flex items-center justify-center p-4" wire:key="bulk-modal">
    <div class="bg-white rounded-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto"
        @click.away="$wire.set('showBulkModal', false)">

        {{-- Modal Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Bulk Availability Override</h3>
                <p class="text-sm text-gray-600 mt-1">Apply changes to multiple dates at once</p>
            </div>
            <button wire:click="$set('showBulkModal', false)" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <form wire:submit.prevent="applyBulkOverride">
            <div class="p-6 space-y-6">

                {{-- Step 1: Select Product --}}
                <div class="bg-light-primary/10 border border-light-primary/50 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold">1</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 mb-2">Pilih Produk</h4>
                            <select wire:model.live="bulkProductId"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary bg-white">
                                <option value="">-- pilih --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                        <span
                                            class="text-gray-500">({{ ucfirst(str_replace('_', ' ', $product->type)) }})</span>
                                    </option>
                                @endforeach
                            </select>
                            @error('bulkProductId')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror

                            @if ($bulkProductId)
                                @php
                                    $selectedProduct = $products->find($bulkProductId);
                                @endphp
                                <div class="mt-2 flex items-center gap-2 text-sm text-green-700">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Selected: <strong>{{ $selectedProduct->name }}</strong></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Step 2: Select Date Range --}}
                <div class="bg-light-primary/10 border border-light-primary/50 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold">2</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 mb-3">Pilih Range Tanggal</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" wire:model.live="bulkStartDate"
                                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary bg-white">
                                    @error('bulkStartDate')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        End Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" wire:model.live="bulkEndDate"
                                        min="{{ $bulkStartDate ?? \Carbon\Carbon::today()->format('Y-m-d') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary bg-white">
                                    @error('bulkEndDate')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            @if ($bulkStartDate && $bulkEndDate)
                                @php
                                    $totalDays =
                                        \Carbon\Carbon::parse($bulkStartDate)->diffInDays(
                                            \Carbon\Carbon::parse($bulkEndDate),
                                        ) + 1;
                                @endphp
                                <div class="mt-2 flex items-center gap-2 text-sm text-green-700">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>Will affect <strong>{{ $totalDays }} days</strong></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Step 3: Choose Action --}}
                <div class="bg-light-primary/10 border border-light-primary/50 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold">3</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 mb-3">Pilih Action</h4>
                            <div class="grid grid-cols-5 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="bulkAction" value="set"
                                        class="sr-only peer">
                                    <div
                                        class="p-3 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                        <i
                                            class="fas fa-edit text-2xl mb-1 text-gray-400 peer-checked:text-primary"></i>
                                        <p class="text-xs font-semibold text-gray-700">Set</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="bulkAction" value="increase"
                                        class="sr-only peer">
                                    <div
                                        class="p-3 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                        <i
                                            class="fas fa-plus text-2xl mb-1 text-gray-400 peer-checked:text-primary"></i>
                                        <p class="text-xs font-semibold text-gray-700">Increase</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="bulkAction" value="decrease"
                                        class="sr-only peer">
                                    <div
                                        class="p-3 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                        <i
                                            class="fas fa-minus text-2xl mb-1 text-gray-400 peer-checked:text-primary"></i>
                                        <p class="text-xs font-semibold text-gray-700">Decrease</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="bulkAction" value="block"
                                        class="sr-only peer">
                                    <div
                                        class="p-3 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                        <i class="fas fa-ban text-2xl mb-1 text-gray-400 peer-checked:text-primary"></i>
                                        <p class="text-xs font-semibold text-gray-700">Block</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model.live="bulkAction" value="unblock"
                                        class="sr-only peer">
                                    <div
                                        class="p-3 border-2 border-gray-300 rounded-lg text-center transition-all peer-checked:border-primary peer-checked:bg-primary/10 hover:border-primary/50">
                                        <i
                                            class="fas fa-unlock text-2xl mb-1 text-gray-400 peer-checked:text-primary"></i>
                                        <p class="text-xs font-semibold text-gray-700">Unblock</p>
                                    </div>
                                </label>
                            </div>

                            {{-- Action Description --}}
                            @if ($bulkAction)
                                <div class="mt-3 text-sm text-gray-700 bg-white p-3 rounded-lg border border-gray-200">
                                    @if ($bulkAction === 'set')
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                        <strong>Set:</strong> Ganti nilai awal ke nilai baru
                                    @elseif($bulkAction === 'increase')
                                        <i class="fas fa-arrow-up text-green-500"></i>
                                        <strong>Increase:</strong> Penambahan berdasarkan nilai yang ada
                                    @elseif($bulkAction === 'decrease')
                                        <i class="fas fa-arrow-down text-orange-500"></i>
                                        <strong>Decrease:</strong> Pengurangan berdsarakan nilai yang ada
                                    @elseif($bulkAction === 'block')
                                        <i class="fas fa-ban text-red-500"></i>
                                        <strong>Block:</strong> Set semua ke 0 (maintenance mode)
                                    @elseif($bulkAction === 'unblock')
                                        <i class="fas fa-unlock text-green-500"></i>
                                        <strong>Unblock:</strong> Reset to default values
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Step 4: Enter Values (only for set/increase/decrease) --}}
                @if (in_array($bulkAction, ['set', 'increase', 'decrease']))
                    <div class="bg-light-primary/10 border border-light-primary/50 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold">4</span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-3">Enter Values</h4>

                                @if ($bulkProductId)
                                    @php
                                        $selectedProduct = $products->find($bulkProductId);
                                    @endphp

                                    @if ($selectedProduct->type === 'touring')
                                        {{-- Touring: Only Seats --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Number of Seats <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" wire:model="bulkSeats" min="0"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary bg-white"
                                                placeholder="Enter number of seats">
                                            <p class="text-xs text-gray-500 mt-1">
                                                @if ($bulkAction === 'set')
                                                    This will set available seats to this value
                                                @elseif($bulkAction === 'increase')
                                                    This will add to current available seats
                                                @elseif($bulkAction === 'decrease')
                                                    This will subtract from current available seats
                                                @endif
                                            </p>
                                            @error('bulkSeats')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @else
                                        {{-- Accommodation/Area Rental: Only Units --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Number of Units <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" wire:model="bulkUnits" min="0"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary bg-white"
                                                placeholder="Enter number of units">
                                            <p class="text-xs text-gray-500 mt-1">
                                                @if ($bulkAction === 'set')
                                                    This will set available units to this value
                                                @elseif($bulkAction === 'increase')
                                                    This will add to current available units
                                                @elseif($bulkAction === 'decrease')
                                                    This will subtract from current available units
                                                @endif
                                            </p>
                                            @error('bulkUnits')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-4 text-gray-500">
                                        <i class="fas fa-arrow-up text-2xl mb-2"></i>
                                        <p>Please select a product first</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Optional: Reason --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Reason (Optional)
                    </label>
                    <textarea wire:model="bulkReason" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                        placeholder="e.g., Holiday preparation, Maintenance schedule, Special event..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">This helps track why changes were made</p>
                </div>

                {{-- Summary Preview --}}
                @if ($bulkProductId && $bulkStartDate && $bulkEndDate && $bulkAction)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-semibold mb-2">Summary:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li><strong>Product:</strong> {{ $products->find($bulkProductId)->name }}</li>
                                    <li><strong>Date Range:</strong>
                                        {{ \Carbon\Carbon::parse($bulkStartDate)->format('M j, Y') }} to
                                        {{ \Carbon\Carbon::parse($bulkEndDate)->format('M j, Y') }}</li>
                                    <li><strong>Total Days:</strong>
                                        {{ \Carbon\Carbon::parse($bulkStartDate)->diffInDays(\Carbon\Carbon::parse($bulkEndDate)) + 1 }}
                                        days</li>
                                    <li><strong>Action:</strong> {{ ucfirst($bulkAction) }}</li>
                                    @if (in_array($bulkAction, ['set', 'increase', 'decrease']))
                                        @if ($bulkUnits)
                                            <li><strong>Units:</strong> {{ $bulkUnits }}</li>
                                        @endif
                                        @if ($bulkSeats)
                                            <li><strong>Seats:</strong> {{ $bulkSeats }}</li>
                                        @endif
                                    @endif
                                </ul>
                                <p class="mt-2 text-red-600 font-semibold">⚠️ This action cannot be undone easily!</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Modal Footer --}}
            <div
                class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex items-center justify-end gap-3">
                <button type="button" wire:click="$set('showBulkModal', false)"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-primary hover:bg-light-primary text-white px-6 py-2 rounded-lg font-semibold transition-all flex items-center gap-2"
                    wire:loading.attr="disabled" @if (!$bulkProductId || !$bulkStartDate || !$bulkEndDate || !$bulkAction) disabled @endif>
                    <span wire:loading.remove wire:target="applyBulkOverride">
                        Apply
                    </span>
                    <span wire:loading wire:target="applyBulkOverride">
                        <i class="fas fa-spinner fa-spin"></i>
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
