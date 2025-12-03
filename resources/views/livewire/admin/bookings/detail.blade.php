<div class="max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $selectedBooking->booking_token }}</h2>
                    @php
                        $statusConfig = [
                            'draft' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-file'],
                            'pending_payment' => [
                                'bg' => 'bg-yellow-100',
                                'text' => 'text-yellow-700',
                                'icon' => 'fa-clock',
                            ],
                            'paid' => [
                                'bg' => 'bg-green-100',
                                'text' => 'text-green-700',
                                'icon' => 'fa-check-circle',
                            ],
                            'checked_in' => [
                                'bg' => 'bg-blue-100',
                                'text' => 'text-blue-700',
                                'icon' => 'fa-sign-in-alt',
                            ],
                            'completed' => [
                                'bg' => 'bg-purple-100',
                                'text' => 'text-purple-700',
                                'icon' => 'fa-flag-checkered',
                            ],
                            'cancelled' => [
                                'bg' => 'bg-red-100',
                                'text' => 'text-red-700',
                                'icon' => 'fa-times-circle',
                            ],
                            'expired' => [
                                'bg' => 'bg-gray-100',
                                'text' => 'text-gray-700',
                                'icon' => 'fa-hourglass-end',
                            ],
                            'refunded' => [
                                'bg' => 'bg-orange-100',
                                'text' => 'text-orange-700',
                                'icon' => 'fa-undo',
                            ],
                        ];
                        $status = $statusConfig[$selectedBooking->status] ?? $statusConfig['draft'];
                    @endphp
                    <span
                        class="{{ $status['bg'] }} {{ $status['text'] }} px-3 py-1 rounded-full text-sm font-semibold inline-flex items-center gap-1">
                        <i class="fas {{ $status['icon'] }}"></i>
                        {{ strtoupper(str_replace('_', ' ', $selectedBooking->status)) }}
                    </span>

                    @if ($selectedBooking->booking_source === 'walk-in')
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-walking mr-1"></i>WALK-IN
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-600">
                    Created: {{ $selectedBooking->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <button wire:click="openStatusModal"
                    class="bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Change Status
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Customer Information --}}
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-primary"></i>
                    Customer Information
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Name</p>
                        <p class="font-semibold text-gray-900">{{ $selectedBooking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="font-semibold text-gray-900">{{ $selectedBooking->customer_phone }}</p>
                    </div>
                    @if ($selectedBooking->customer_email)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <p class="font-semibold text-gray-900">{{ $selectedBooking->customer_email }}</p>
                        </div>
                    @endif
                    @if ($selectedBooking->user)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600 mb-1">Linked Account</p>
                            <div class="flex items-center gap-2">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-user-check mr-1"></i>{{ $selectedBooking->user->name }}
                                </span>
                                <span class="text-xs text-gray-500">({{ $selectedBooking->user->email }})</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Booking Details --}}
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-primary"></i>
                    Booking Details
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Check-in</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($selectedBooking->start_date)->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Check-out</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($selectedBooking->end_date)->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Duration</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($selectedBooking->start_date)->diffInDays($selectedBooking->end_date) }}
                                {{ $selectedBooking->product_type === 'touring' ? 'day(s)' : 'night(s)' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">People</p>
                            <p class="font-semibold text-gray-900">{{ $selectedBooking->people_count }} person(s)</p>
                        </div>
                    </div>

                    @if ($selectedBooking->special_requests)
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-1">Special Requests</p>
                            <p class="text-gray-900">{{ $selectedBooking->special_requests }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Booking Items --}}
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        Booking Items
                    </h3>
                    @if ($selectedBooking->status === 'checked_in')
                        <button wire:click="openAddonsModal"
                            class="text-primary hover:text-light-primary text-sm font-semibold flex items-center gap-1">
                            <i class="fas fa-plus-circle"></i>
                            Add/Edit Items
                        </button>
                    @endif
                </div>

                <div class="space-y-3">
                    @foreach ($selectedBooking->items as $item)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if ($item->item_type === 'product')
                                            <span
                                                class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded">PRODUCT</span>
                                        @else
                                            <span
                                                class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded">ADD-ON</span>
                                        @endif
                                        <h4 class="font-semibold text-gray-900">{{ $item->name_snapshot }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        {{ ucfirst(str_replace('_', ' ', $item->pricing_type_snapshot)) }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">{{ $item->qty }} x Rp
                                        {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                                    <p class="font-bold text-gray-900">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            @if ($item->notes)
                                <div class="mt-2 pt-2 border-t border-gray-200">
                                    <p class="text-xs text-gray-500">
                                        @php
                                            $notes = is_string($item->notes)
                                                ? json_decode($item->notes, true)
                                                : $item->notes;
                                        @endphp
                                        @if (is_array($notes))
                                            @foreach ($notes as $key => $value)
                                                <span class="mr-3">{{ ucfirst($key) }}: {{ $value }}</span>
                                            @endforeach
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>


            {{-- Payment History --}}
            @if ($selectedBooking->payments && $selectedBooking->payments->count() > 0)
                <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-receipt text-primary"></i>
                        Payment History
                    </h3>

                    <div class="space-y-3">
                        @foreach ($selectedBooking->payments as $payment)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">Rp
                                            {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                        <p class="text-sm text-gray-600">{{ $payment->provider }}</p>
                                    </div>
                                    <span
                                        class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </div>
                                @if ($payment->notes)
                                    <p class="text-sm text-gray-600 mt-2">{{ $payment->notes }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Pricing Summary --}}
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-calculator text-primary"></i>
                    Pricing Summary
                </h3>

                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">Rp
                            {{ number_format($selectedBooking->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if ($selectedBooking->discount_total > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Discount:</span>
                            <span class="font-semibold text-green-600">- Rp
                                {{ number_format($selectedBooking->discount_total, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    @if ($selectedBooking->voucher)
                        <div class="bg-green-50 border border-green-200 rounded p-2">
                            <p class="text-xs text-green-800">
                                <i class="fas fa-ticket-alt mr-1"></i>
                                Voucher: <strong>{{ $selectedBooking->voucher->code }}</strong>
                            </p>
                        </div>
                    @endif

                    <div class="flex justify-between text-lg font-bold pt-3 border-t-2 border-gray-300">
                        <span>TOTAL:</span>
                        <span class="text-primary">Rp
                            {{ number_format($selectedBooking->total_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Status</span>
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $payment->status === 'settlement' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $payment->status === 'cancel' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>
            </div>



            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>

                <div class="space-y-2">

                    {{-- Check-in --}}
                    @if ($selectedBooking->status === 'paid')
                        <button wire:click="checkIn" @if (\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($selectedBooking->start_date))) disabled @endif
                            class="w-full bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 disabled:bg-gray-300 disabled:cursor-not-allowed disabled:hover:bg-gray-300">
                            <i class="fas fa-sign-in-alt"></i>
                            Check-in
                        </button>
                    @endif


                    {{-- Complete --}}
                    @if ($selectedBooking->status === 'checked_in')
                        <div>
                            <button wire:click="complete" wire:loading.attr="disabled" wire:target="complete"
                                class="w-full bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                {{-- Normal label --}}
                                <span wire:loading.remove wire:target="complete" class="flex items-center gap-2">
                                    <i class="fas fa-flag-checkered"></i>
                                    Complete
                                </span>

                                {{-- Loading state --}}
                                <span wire:loading wire:target="complete" class="flex items-center gap-2">

                                    Processing...
                                </span>
                            </button>
                        </div>
                    @endif

                    {{-- No-Show --}}
                    @if ($selectedBooking->status === 'paid' && now()->isAfter($selectedBooking->end_date))
                        <button wire:click="openNoShowModal"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-user-slash"></i>
                            Mark as No-Show
                        </button>
                    @endif

                    {{-- pay now --}}
                    @if (
                        $selectedBooking->booking_source === 'walk-in' &&
                            $selectedBooking->status === 'pending_payment' &&
                            $selectedBooking->payments()->where('status', 'pending')->exists())
                        <button wire:click="openPayNowModal"
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-money-bill-wave"></i>
                            Bayar Sekarang
                        </button>
                    @endif

                    {{-- pay addon --}}
                    @php
                        $hasPendingAddon = $selectedBooking
                            ->payments()
                            ->where('order_id', 'like', 'ORD-ADDON%')
                            ->where('status', 'pending')
                            ->exists();
                    @endphp
                    @if ($selectedBooking->status === 'checked_in' && $hasPendingAddon)
                        <button wire:click="openPayAddonModal"
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-coins"></i>
                            Bayar Sisa (Add-ons)
                        </button>
                    @endif

                    {{-- ✅ CANCEL (only for draft/pending_payment) --}}
                    @if (in_array($selectedBooking->status, ['draft', 'pending_payment']))
                        <button wire:click="openCancelModal"
                            class="w-full bg-danger hover:bg-danger/70 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-times-circle"></i>
                            Cancel Booking
                        </button>
                    @endif

                    {{-- ✅ REFUND (only for paid/checked_in/completed) --}}
                    @if (in_array($selectedBooking->status, ['paid', 'checked_in', 'completed']))
                        <button wire:click="openRefundModal"
                            class="w-full bg-info-2-dark hover:bg-info-2-dark/70 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-undo"></i>
                            Process Refund
                        </button>
                    @endif


                    {{-- Redeem Bonus --}}
                    @if ($selectedBooking->user_id && $selectedBooking->user->bonus_points >= 100)
                        <button wire:click="redeemBonus"
                            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-gift"></i>
                            Redeem Bonus ({{ $selectedBooking->user->bonus_points }} pts)
                        </button>
                    @endif


                </div>

            </div>
        </div>
    </div>


    {{-- ✅ PAY NOW MODAL --}}
    @if ($showPayNowModal)
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-data
            x-init="$el.focus()" tabindex="0" @keydown.escape.window="$wire.set('showPayNowModal', false)">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden"
                @click.away="$wire.set('showPayNowModal', false)">

                {{-- Header --}}
                <div class="bg-green-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-money-bill-wave"></i>
                        Bayar Sekarang
                    </h3>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4">
                    {{-- Booking Info --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600">Booking Token:</p>
                                <p class="font-semibold text-gray-900">{{ $selectedBooking->booking_token }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Customer:</p>
                                <p class="font-semibold text-gray-900">{{ $selectedBooking->customer_name }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-600">Total Amount:</p>
                                <p class="font-bold text-gray-900 text-2xl">Rp {{ number_format($payNowAmount) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Payment Method <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-2">
                            <label
                                class="relative flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-all
                            {{ $payNowMethod === 'cash' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-green-600' }}">
                                <input type="radio" wire:model.live="payNowMethod" value="cash" class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-money-bill-wave text-xl mb-1 {{ $payNowMethod === 'cash' ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-xs font-semibold {{ $payNowMethod === 'cash' ? 'text-green-600' : 'text-gray-700' }}">
                                        Cash</p>
                                </div>
                            </label>

                            <label
                                class="relative flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-all
                            {{ $payNowMethod === 'qris' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-green-600' }}">
                                <input type="radio" wire:model.live="payNowMethod" value="qris" class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-qrcode text-xl mb-1 {{ $payNowMethod === 'qris' ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-xs font-semibold {{ $payNowMethod === 'qris' ? 'text-green-600' : 'text-gray-700' }}">
                                        QRIS</p>
                                </div>
                            </label>

                            <label
                                class="relative flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-all
                            {{ $payNowMethod === 'transfer' ? 'border-green-600 bg-green-50' : 'border-gray-300 hover:border-green-600' }}">
                                <input type="radio" wire:model.live="payNowMethod" value="transfer"
                                    class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-university text-xl mb-1 {{ $payNowMethod === 'transfer' ? 'text-green-600' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-xs font-semibold {{ $payNowMethod === 'transfer' ? 'text-green-600' : 'text-gray-700' }}">
                                        Transfer</p>
                                </div>
                            </label>
                        </div>
                        @error('payNowMethod')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount Received --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Amount Received <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                            <input type="number" wire:model.live="payNowAmount"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-green-600"
                                placeholder="0">
                        </div>
                        @error('payNowAmount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        @if ($payNowAmount > 0 && $payNowAmount >= $selectedBooking->total_price)
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>
                                Change: Rp {{ number_format($payNowAmount - $selectedBooking->total_price) }}
                            </p>
                        @endif
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea wire:model="payNowNotes" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                            placeholder="Add payment notes..."></textarea>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                    <button wire:click="$set('showPayNowModal', false)"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-all">
                        Cancel
                    </button>
                    <button wire:click="processPayNow"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Process Payment
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ✅ PAY ADDON MODAL --}}
    @if ($showPayAddonModal)
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-data
            x-init="$el.focus()" tabindex="0" @keydown.escape.window="$wire.set('showPayAddonModal', false)">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden"
                @click.away="$wire.set('showPayAddonModal', false)">

                {{-- Header --}}
                <div class="bg-orange-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-coins"></i>
                        Bayar Sisa Add-ons
                    </h3>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4">
                    {{-- Info --}}
                    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                        <p class="text-sm text-orange-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pembayaran tambahan untuk add-ons yang ditambahkan saat checked-in.
                        </p>
                    </div>

                    {{-- Booking Info --}}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-gray-600">Booking Token:</p>
                                <p class="font-semibold text-gray-900">{{ $selectedBooking->booking_token }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Customer:</p>
                                <p class="font-semibold text-gray-900">{{ $selectedBooking->customer_name }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-600">Add-ons Amount:</p>
                                <p class="font-bold text-orange-600 text-2xl">Rp {{ number_format($payAddonAmount) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Payment Method <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            <label
                                class="relative flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-all
                            {{ $payAddonMethod === 'cash' ? 'border-orange-600 bg-orange-50' : 'border-gray-300 hover:border-orange-600' }}">
                                <input type="radio" wire:model.live="payAddonMethod" value="cash"
                                    class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-money-bill-wave text-xl mb-1 {{ $payAddonMethod === 'cash' ? 'text-orange-600' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-xs font-semibold {{ $payAddonMethod === 'cash' ? 'text-orange-600' : 'text-gray-700' }}">
                                        Cash</p>
                                </div>
                            </label>

                            <label
                                class="relative flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-all
                            {{ $payAddonMethod === 'qris' ? 'border-orange-600 bg-orange-50' : 'border-gray-300 hover:border-orange-600' }}">
                                <input type="radio" wire:model.live="payAddonMethod" value="qris"
                                    class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-qrcode text-xl mb-1 {{ $payAddonMethod === 'qris' ? 'text-orange-600' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-xs font-semibold {{ $payAddonMethod === 'qris' ? 'text-orange-600' : 'text-gray-700' }}">
                                        QRIS</p>
                                </div>
                            </label>
                        </div>
                        @error('payAddonMethod')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount Received --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Amount Received <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                            <input type="number" wire:model.live="payAddonAmount"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600"
                                placeholder="0">
                        </div>
                        @error('payAddonAmount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        @php
                            $pendingAddonPayment = $selectedBooking
                                ->payments()
                                ->where('status', 'pending')
                                ->whereJsonContains('raw_payload->type', 'addon_onsite')
                                ->first();
                            $requiredAmount = $pendingAddonPayment ? $pendingAddonPayment->amount : 0;
                        @endphp

                        @if ($payAddonAmount > 0 && $payAddonAmount >= $requiredAmount)
                            <p class="text-sm text-green-600 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>
                                Change: Rp {{ number_format($payAddonAmount - $requiredAmount) }}
                            </p>
                        @endif
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea wire:model="payAddonNotes" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-600 focus:border-orange-600 text-sm"
                            placeholder="Add payment notes..."></textarea>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                    <button wire:click="$set('showPayAddonModal', false)"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-all">
                        Cancel
                    </button>
                    <button wire:click="processPayAddon"
                        class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg font-semibold transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Process Payment
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Status Change Modal --}}
    @if ($showStatusModal)
        <div class="fixed inset-0 bg-gray-500/70 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Change Booking Status</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Status</label>
                        <select wire:model="newStatus"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary">
                            <option value="">Select Status</option>
                            <option value="pending_payment">Pending Payment</option>
                            <option value="paid">Paid</option>
                            <option value="checked_in">Checked-in</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="refunded">Refunded</option>
                            <option value="no_show">No-Show</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                        <textarea wire:model="statusNotes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary"
                            placeholder="Add notes about this status change..."></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <button wire:click="$set('showStatusModal', false)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold transition-all">
                        Cancel
                    </button>
                    <button wire:click="updateStatus"
                        class="bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg font-semibold transition-all">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showAddonsModal)
        <div class="fixed inset-0 bg-gray-500/70 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white rounded-lg max-w-3xl w-full my-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">Manage Add-ons</h3>
                </div>

                <div class="p-6 max-h-[60vh] overflow-y-auto">
                    {{-- Current Addons --}}
                    @if (count($editableAddons) > 0)
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-900 mb-3">Current Add-ons</h4>
                            <div class="space-y-3">
                                @foreach ($editableAddons as $itemId => $addon)
                                    <div
                                        class="border rounded-lg p-4 {{ $addon['action'] === 'delete' ? 'bg-red-50 border-red-200' : 'border-gray-200' }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h5
                                                    class="font-semibold text-gray-900 {{ $addon['action'] === 'delete' ? 'line-through' : '' }}">
                                                    {{ $addon['name'] }}
                                                </h5>
                                                <p class="text-sm text-gray-600">
                                                    Rp {{ number_format($addon['unit_price'], 0, ',', '.') }}
                                                </p>
                                            </div>

                                            @if ($addon['action'] !== 'delete')
                                                <div class="flex items-center gap-3">
                                                    <div class="flex items-center gap-2">
                                                        <button type="button"
                                                            wire:click="updateAddonQtyInEdit({{ $itemId }}, 'decrement')"
                                                            class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded font-bold">-</button>
                                                        <span
                                                            class="w-12 text-center font-semibold">{{ $addon['qty'] }}</span>
                                                        <button type="button"
                                                            wire:click="updateAddonQtyInEdit({{ $itemId }}, 'increment')"
                                                            class="bg-gray-200 hover:bg-gray-300 w-8 h-8 rounded font-bold">+</button>
                                                    </div>
                                                    <button wire:click="markAddonForDeletion({{ $itemId }})"
                                                        class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <button wire:click="restoreAddon({{ $itemId }})"
                                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    <i class="fas fa-undo mr-1"></i>Restore
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Add New Addons --}}
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Add New Add-ons</h4>

                        {{-- Available Addons --}}
                        <div class="mb-4 space-y-2">
                            @foreach ($addons as $addon)
                                @if (!isset($newAddons[$addon->id]))
                                    <button wire:click="addNewAddon({{ $addon->id }})"
                                        class="w-full text-left border border-gray-200 rounded-lg p-3 hover:border-primary hover:bg-primary/5 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $addon->name }}</p>
                                                <p class="text-sm text-gray-600">
                                                    Rp
                                                    {{ number_format($addon->price, 0, ',', '.') }}/{{ $addon->pricing_type }}
                                                </p>
                                            </div>
                                            <i class="fas fa-plus text-primary"></i>
                                        </div>
                                    </button>
                                @endif
                            @endforeach
                        </div>

                        {{-- Selected New Addons --}}
                        @if (count($newAddons) > 0)
                            <div class="border-t pt-4 space-y-3">
                                @foreach ($newAddons as $addonId => $addon)
                                    <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-gray-900">{{ $addon['name'] }}</h5>
                                                <p class="text-sm text-gray-600">
                                                    Rp {{ number_format($addon['unit_price'], 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <button wire:click="removeNewAddon({{ $addonId }})"
                                                class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-3 gap-2">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                                                <div class="flex items-center gap-1">
                                                    <button type="button"
                                                        wire:click="updateNewAddonQty({{ $addonId }}, 'decrement')"
                                                        class="bg-gray-200 hover:bg-gray-300 w-7 h-7 rounded text-sm font-bold">-</button>
                                                    <input type="number"
                                                        wire:model.live="newAddons.{{ $addonId }}.qty"
                                                        class="flex-1 text-center px-2 py-1 border border-gray-300 rounded text-sm">
                                                    <button type="button"
                                                        wire:click="updateNewAddonQty({{ $addonId }}, 'increment')"
                                                        class="bg-gray-200 hover:bg-gray-300 w-7 h-7 rounded text-sm font-bold">+</button>
                                                </div>
                                            </div>

                                            @if ($addon['pricing_type'] === 'per_hour')
                                                <div>
                                                    <label
                                                        class="block text-xs font-medium text-gray-700 mb-1">Hours</label>
                                                    <input type="number"
                                                        wire:model.live="newAddons.{{ $addonId }}.hours"
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                                </div>
                                            @endif

                                            @if ($addon['pricing_type'] === 'per_slot')
                                                <div>
                                                    <label
                                                        class="block text-xs font-medium text-gray-700 mb-1">Slots</label>
                                                    <input type="number"
                                                        wire:model.live="newAddons.{{ $addonId }}.slots"
                                                        class="w-full px-2 py-1 border border-gray-300 rounded text-sm">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Notes --}}
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                        <textarea wire:model="addonNotes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"
                            placeholder="Additional notes about add-ons changes..."></textarea>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 flex items-center justify-end gap-3">
                    <button wire:click="$set('showAddonsModal', false)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold transition-all">
                        Cancel
                    </button>
                    <button wire:click="saveAddons"
                        class="bg-primary hover:bg-light-primary text-white px-4 py-2 rounded-lg font-semibold transition-all">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showCancelModal)
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-data
            x-init="$el.focus()" tabindex="0" @keydown.escape.window="$wire.set('showCancelModal', false)">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden"
                @click.away="$wire.set('showCancelModal', false)">

                {{-- Header --}}
                <div class="bg-danger px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Cancel Booking
                    </h3>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4">
                    <div class="bg-danger/10 border border-danger rounded-lg p-4">
                        <p class="text-sm text-danger">
                            <i class="fas fa-info-circle mr-1"></i>
                            Yang akan terjadi:
                        </p>
                        <ul class="mt-2 space-y-1 text-sm text-danger/70 ml-5 list-disc">
                            <li>Booking status → <strong>Cancelled</strong></li>
                            <li>Payment status → <strong>Cancel</strong></li>
                            <li>Mengembalikan ketersediaan</li>
                            <li>Mengubah invoice menjadi void</li>
                        </ul>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alasan Pembatalan <span class="text-danger">*</span>
                        </label>
                        <textarea wire:model="cancelReason" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-danger focus:border-danger text-sm"
                            placeholder="Explain why this booking is being cancelled (minimum 10 characters)..."></textarea>
                        @error('cancelReason')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                    <button wire:click="$set('showCancelModal', false)"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-all">
                        Keep
                    </button>
                    <button wire:click="cancelBooking"
                        class="px-4 py-2 bg-danger hover:bg-danger/70 text-white rounded-lg font-semibold transition-all flex items-center gap-2">
                        <i class="fas fa-times-circle"></i>
                        Cancel Booking
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showNoShowModal)
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-data
            x-init="$el.focus()" tabindex="0" @keydown.escape.window="$wire.set('showNoShowModal', false)">
            <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden"
                @click.away="$wire.set('showNoShowModal', false)">

                {{-- Header --}}
                <div class="bg-gray-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-user-slash"></i>
                        Mark as No-Show
                    </h3>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4">
                    {{-- Warning Notice --}}
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800 font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Customer Did Not Show Up
                        </p>
                        <p class="text-xs text-yellow-700 mb-3">
                            This action indicates that the customer paid but did not check-in by the checkout date.
                        </p>
                        <ul class="mt-2 space-y-1 text-xs text-yellow-700 ml-5 list-disc">
                            <li>Booking status → <strong>No-Show</strong></li>
                            <li>Payment remains <strong>Settled</strong> (no refund)</li>
                            <li>Invoice remains <strong>Paid</strong></li>
                            <li>Availability will be <strong>Released</strong></li>
                        </ul>
                    </div>

                    {{-- Booking Info --}}
                    <div class="bg-gray-50 rounded-lg p-3 text-sm">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <p class="text-gray-600">Booking Token:</p>
                                <p class="font-semibold text-gray-900">{{ $selectedBooking->booking_token }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Customer:</p>
                                <p class="font-semibold text-gray-900">{{ $selectedBooking->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Check-in Date:</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedBooking->start_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Check-out Date:</p>
                                <p class="font-semibold text-red-600">
                                    {{ \Carbon\Carbon::parse($selectedBooking->end_date)->format('d M Y') }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-600">Amount Paid:</p>
                                <p class="font-bold text-gray-900 text-lg">Rp
                                    {{ number_format($selectedBooking->total_price) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Notes Input --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Notes <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="noShowNotes" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-gray-500 text-sm"
                            placeholder="Document the no-show incident (e.g., contacted customer, no response, etc.)"></textarea>
                        @error('noShowNotes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Policy Notice --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>No-Show Policy:</strong>
                        </p>
                        <ul class="mt-1 space-y-0.5 text-xs text-blue-700 ml-5 list-disc">
                            <li>Customer will NOT receive a refund</li>
                            <li>Payment is considered final</li>
                            <li>Reserved inventory will be released back to availability</li>
                            <li>Customer may be contacted for future bookings policy</li>
                        </ul>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                    <button wire:click="$set('showNoShowModal', false)"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-all">
                        Cancel
                    </button>
                    <button wire:click="markAsNoShow"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Confirm No-Show
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ✅ REFUND MODAL --}}
    @if ($showRefundModal)
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-data
            x-init="$el.focus()" tabindex="0" @keydown.escape.window="$wire.set('showRefundModal', false)">
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full overflow-hidden"
                @click.away="$wire.set('showRefundModal', false)">

                {{-- Header --}}
                <div class="bg-info-2-dark px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-undo"></i>
                        Process Refund
                    </h3>
                </div>

                {{-- Body --}}
                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                    {{-- Refund Info --}}
                    <div class="bg-info-2-dark/20 border border-info-2-dark rounded-lg p-4">
                        @php
                            $totalPaid = $selectedBooking->payments()->where('status', 'settlement')->sum('amount');
                            $totalRefunded = $selectedBooking->invoices()->where('type', 'credit_note')->sum('amount');
                            $maxRefundable = $totalPaid - $totalRefunded;
                        @endphp
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-info-2 font-semibold">Total Paid:</p>
                                <p class="text-info-2-dark font-bold">Rp {{ number_format($totalPaid) }}</p>
                            </div>
                            <div>
                                <p class="text-info-2-dark font-semibold">Already Refunded:</p>
                                <p class="text-info-2-dark font-bold">Rp {{ number_format($totalRefunded) }}</p>
                            </div>
                            <div class="col-span-2 pt-2 border-t border-info-2-dark">
                                <p class="text-info-2-dark font-semibold">Max Refundable:</p>
                                <p class="text-info-2-dark font-bold text-lg">Rp {{ number_format($maxRefundable) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Refund Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Refund Type</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                            {{ $refundType === 'full' ? 'border-info-2-dark bg-info-2-dark/20' : 'border-gray-300 hover:border-info-2-dark' }}">
                                <input type="radio" wire:model.live="refundType" value="full" class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-rotate-left text-2xl mb-1 {{ $refundType === 'full' ? 'text-info-2-dark' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-sm font-semibold {{ $refundType === 'full' ? 'text-info-2-dark' : 'text-gray-700' }}">
                                        Full Refund</p>
                                </div>
                            </label>

                            <label
                                class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all
                            {{ $refundType === 'partial' ? 'border-info-2-dark bg-info-2-dark/20' : 'border-gray-300 hover:border-info-2-dark' }}">
                                <input type="radio" wire:model.live="refundType" value="partial" class="sr-only">
                                <div class="text-center">
                                    <i
                                        class="fas fa-percent text-2xl mb-1 {{ $refundType === 'partial' ? 'text-info-2-dark' : 'text-gray-400' }}"></i>
                                    <p
                                        class="text-sm font-semibold {{ $refundType === 'partial' ? 'text-info-2-dark' : 'text-gray-700' }}">
                                        Partial Refund</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Refund Amount --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Refund Amount <span class="text-danger">*</span>
                        </label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                            <input type="number" wire:model.live="refundAmount"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-info-2-dark focus:border-info-2-dark"
                                placeholder="0" max="{{ $maxRefundable }}"
                                {{ $refundType === 'full' ? 'readonly' : '' }}>
                        </div>
                        @error('refundAmount')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Refund Reason --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Refund Reason <span class="text-danger">*</span>
                        </label>
                        <textarea wire:model="refundReason" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-info-2-dark focus:border-info-2-dark text-sm"
                            placeholder="Explain the reason for this refund (minimum 10 characters)..."></textarea>
                        @error('refundReason')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Impact Notice --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>What will happen:</strong>
                        </p>
                        <ul class="mt-1 space-y-0.5 text-xs text-blue-700 ml-5 list-disc">
                            @if ($refundType === 'full')
                                <li>Booking status → <strong>Refunded</strong></li>
                                <li>Payment status → <strong>Refund</strong></li>
                                <li>Availability will be released</li>
                            @else
                                <li>Payment status → <strong>Partial Refund</strong></li>
                                <li>Booking status remains <strong>{{ ucfirst($selectedBooking->status) }}</strong>
                                </li>
                            @endif
                            <li>Credit Note invoice will be created</li>
                        </ul>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                    <button wire:click="$set('showRefundModal', false)"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-semibold transition-all">
                        Cancel
                    </button>
                    <button wire:click="processRefund"
                        class="px-4 py-2 bg-info-2-dark hover:bg-info-2-dark/70 text-white rounded-lg font-semibold transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Process Refund
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($selectedBooking->user_id && $selectedBooking->user->bonus_points >= 100)
        <button wire:click="redeemBonus"
            class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
            <i class="fas fa-gift"></i>
            Redeem Bonus ({{ $selectedBooking->user->bonus_points }} pts)
        </button>
    @endif
</div>
