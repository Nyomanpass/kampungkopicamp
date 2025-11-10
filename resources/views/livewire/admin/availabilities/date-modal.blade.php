<div class="fixed inset-0 bg-gray-500/75 z-50 flex items-center justify-center p-4 backdrop-blur" wire:key="date-modal">
    <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto"
        @click.away="$wire.set('showDateModal', false)">

        {{-- Modal Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-gray-900">
                    Ketersediaan Untuk {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Kelola stok untuk semua produk pada tanggal ini
                </p>
            </div>
            <button wire:click="$set('showDateModal', false)" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-6">
            @if (empty($dateAvailabilities))
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-600">No availability data for this date.</p>
                    <p class="text-sm text-gray-500 mt-2">Run availability generation to create data.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($dateAvailabilities as $index => $availability)
                        @php
                            $product = $availability['product'];
                            $availId = $availability['id'];
                        @endphp

                        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors">
                            {{-- Product Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $typeIcons = [
                                            'accommodation' => 'fa-bed',
                                            'touring' => 'fa-hiking',
                                            'area_rental' => 'fa-map-marked-alt',
                                        ];
                                        $icon = $typeIcons[$product['type']] ?? 'fa-box';
                                    @endphp
                                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <i class="fas {{ $icon }} text-primary"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $product['name'] }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ ucfirst(str_replace('_', ' ', $product['type'])) }}</p>
                                    </div>
                                </div>

                                {{-- Override Badge --}}
                                @if ($availability['is_overridden'])
                                    <span
                                        class="bg-info/15 text-info text-xs font-semibold px-2 py-1 rounded-full flex items-center gap-1">
                                        <i class="fas fa-edit"></i>
                                        telah Diubah
                                    </span>
                                @endif
                            </div>

                            {{-- Stock Inputs --}}
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                @if ($product['type'] !== 'touring')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Ketersediaan Unit
                                        </label>
                                        <input type="number"
                                            wire:model="editingAvailability.{{ $availId }}.available_unit"
                                            min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    </div>
                                @endif

                                @if ($product['type'] === 'touring')
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Ketersediaan Seat
                                        </label>
                                        <input type="number"
                                            wire:model="editingAvailability.{{ $availId }}.available_seat"
                                            min="0"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                                    </div>
                                @endif
                            </div>

                            {{-- Override Reason --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Alasan Stok Diubah (Optional)
                                </label>
                                <input type="text"
                                    wire:model="editingAvailability.{{ $availId }}.override_reason"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                                    placeholder="e.g., Maintenance, Private Event...">
                            </div>

                            {{-- Override Info --}}
                            @if ($availability['is_overridden'] && $availability['overridden_by_user'])
                                <div class="bg-info/5 border border-info rounded-lg p-3 text-sm">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-info-circle text-info mt-0.5"></i>
                                        <div class="text-info">
                                            <p class="font-semibold">History Perubahan:</p>
                                            <p class="mt-1">
                                                Diubah oleh
                                                <strong>{{ $availability['overridden_by_user']['name'] }}</strong>
                                                pada
                                                {{ \Carbon\Carbon::parse($availability['overridden_at'])->format('M j, Y g:i A') }}
                                            </p>
                                            @if ($availability['override_reason'])
                                                <p class="mt-1">Reason: {{ $availability['override_reason'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Reset Button --}}
                            @if ($availability['is_overridden'])
                                <div class="mt-3">
                                    <button wire:click="resetOverride({{ $availId }})"
                                        wire:confirm="Are you sure you want to reset this override? It will return to default values."
                                        class="text-sm text-danger hover:text-danger/70 font-semibold flex items-center gap-1">
                                        <i class="fas fa-undo"></i>
                                        Reset to Default
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Modal Footer --}}
        @if (!empty($dateAvailabilities))
            <div
                class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex items-center justify-end gap-3">
                <button wire:click="$set('showDateModal', false)"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-semibold transition-all">
                    Cancel
                </button>
                <button wire:click="saveDateChanges"
                    class="bg-primary hover:bg-light-primary text-white px-6 py-2 rounded-lg font-semibold transition-all flex items-center gap-2"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="saveDateChanges">
                        <i class="fas fa-save"></i>
                        Save Changes
                    </span>
                    <span wire:loading wire:target="saveDateChanges">
                        <i class="fas fa-spinner fa-spin"></i>
                        Saving...
                    </span>
                </button>
            </div>
        @endif
    </div>
</div>
