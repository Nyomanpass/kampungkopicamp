<div class="px-4 w-full relative">
    <div class="fixed top-4 right-4 z-80 w-96 max-w-[calc(100vw-2rem)] space-y-3">
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

    <header class="py-5 border-b border-gray-300 mb-5">
        <p class="font-semibold text-lg">My booking</p>
    </header>

    {{-- filters --}}
    <div class="mb-5 flex gap-3 flex-wrap">
        <select wire:model.live="statusFilter"
            class="rounded-lg px-5 py-2 text-sm border-gray-300 shadow-sm focus:ring-light-primary focus:border-light-primary">
            <option value="">All Status</option>
            @foreach ($statusOptions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        <select wire:model.live="typeFilter"
            class="rounded-lg px-5 py-2 text-sm border-gray-300 shadow-sm focus:ring-light-primary focus:border-light-primary">
            <option value="">All Type</option>
            @foreach ($typeOptions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>

        @if ($statusFilter || $typeFilter)
            <button wire:click="resetFilters" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 underline">
                Reset Filters
            </button>
        @endif
    </div>

    {{-- history booking list --}}
    <div class="space-y-5 pb-20 lg:pb-0">
        @forelse($bookings as $booking)
            @php
                // Get main product item
                $productItem = $booking->items->where('item_type', 'product')->first();
                $product = $productItem?->product;
            @endphp
            {{-- {{ dd($booking) }} --}}
            <div x-data="{ open: false }" class="relative w-full" x-cloak>
                {{-- cards (if clicked will go to detail) --}}
                <button @click="open = !open; $event.stopPropagation();"
                    class="px-5 py-5 bg-white w-full rounded-xl border border-gray-300 shadow-sm hover:shadow-md transition">
                    <div class="flex gap-3 justify-between border-b border-gray-300 pb-4 mb-4">
                        <div class="flex gap-3 items-center">
                            <div class="size-10 bg-secondary flex items-center justify-center text-white rounded-lg">
                                <i
                                    class="fas {{ $booking->items->where('item_type', 'product')->first() ? $this->getProductIcon($booking->product_type) : 'fa-box' }} text-xl"></i>
                            </div>
                            <div class="text-left">
                                <p class="font-medium text-sm mb-1">
                                    {{ $booking->product_type }}
                                </p>
                                <p class="text-xs">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <p
                            class="text-xs py-1 px-3 rounded-full {{ $this->getStatusColor($booking->status) }}  flex items-center justify-center font-medium">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </p>

                    </div>
                    <div class="flex gap-5 items-center border-b border-gray-300 pb-4">
                        @if (!empty($product->images) && isset($product->images[0]))
                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                class="size-12 rounded-lg object-cover">
                        @else
                            <div class="size-12 bg-gray-300 rounded-lg"></div>
                        @endif
                        <div class="flex flex-col items-start">
                            <p class="font-semibold mb-1">

                                {{ $booking->items->where('item_type', 'product')->first()?->name_snapshot ?? 'N/A' }}
                            </p>
                            <p class="text-xs mb-1">
                                @if ($product->type === 'touring')
                                    {{ $booking->people_count }} Seats -
                                    {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                    Day{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) > 1 ? 's' : '' }}
                                @else
                                    {{ $booking->people_count }} People - {{ $booking->unit_count }} Unit -
                                    {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                    Day{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) > 1 ? 's' : '' }}
                                @endif
                            </p>
                            @php
                                $addonCount = $booking->bookingItems()->whereNotNull('addon_id')->count();
                            @endphp
                            @if ($addonCount > 0)
                                <p class="text-xs font-medium">
                                    + {{ $addonCount }} {{ $addonCount > 1 ? 'Addons' : 'Addon' }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mt-4">
                            <p class="font-medium">Total Paid</p>
                            <p class="font-bold text-primary">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </button>

                {{-- detail booking sidebar --}}
                <div>


                    <div x-show="open" x-cloak x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        @click="showEditProfile = false" class="fixed inset-0 z-40 bg-gray-500/50"
                        style="display: none;"></div>


                    <div x-show="open" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="fixed top-0 right-0 h-full w-full lg:max-w-4xl  bg-gray-100 shadow-2xl z-50 overflow-y-auto ">

                        {{-- header detail booking --}}
                        <div
                            class="flex justify-between items-center border-b border-gray-300 pb-4 mb-4 py-5 px-4 bg-white ">
                            <button @click="open = false">
                                <i class="fa fa-angle-left text-lg"></i>
                            </button>
                            <h3 class="font-semibold text-lg">Detail Booking</h3>
                            <div class="text-white">
                                <i class="fa fa-angle-left text-lg"></i>
                            </div>
                        </div>

                        {{-- content detail booking --}}
                        <div class="space-y-4 ">
                            <div class="bg-white px-4 py-5">
                                <div class="flex justify-between items-center px-3">
                                    <div>
                                        <p class="font-medium">Booking Token</p>
                                        <p class="text-sm mb-4">{{ $booking->booking_token }}</p>
                                    </div>
                                    <button
                                        @click="
                                const code = '{{ $booking->booking_token }}';
                                        if (navigator.clipboard && navigator.clipboard.writeText) {
                                            navigator.clipboard.writeText(code).then(() => {
                                                $dispatch('copied');
                                                console.log('text berhasil dicopy');
                                            }).catch(err => {
                                                console.error('Failed to copy:', err);
                                            });
                                        } else {
                                            // Fallback method for older browsers or non-secure contexts
                                            const textarea = document.createElement('textarea');
                                            textarea.value = code;
                                            textarea.style.position = 'fixed';
                                            textarea.style.opacity = '0';
                                            document.body.appendChild(textarea);
                                            textarea.select();
                                            try {
                                                document.execCommand('copy');
                                                $dispatch('copied');
                                                console.log('text berhasil dicopy');
                                            } catch (err) {
                                                console.error('Fallback copy failed:', err);
                                                alert('Gagal menyalin kode voucher');
                                            }
                                            document.body.removeChild(textarea);
                                        }
                                "
                                        class="size-8 rounded-lg bg-light-primary text-white">
                                        <i class="fa fa-copy text-xs"></i>
                                    </button>
                                </div>
                                <div
                                    class="px-4 py-3 border border-gray-300 rounded-lg flex justify-between items-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <div
                                            class="size-10 bg-light-primary/70 flex items-center justify-center text-white rounded-lg">
                                            <i
                                                class="fas {{ $booking ? $this->getProductIcon($booking->product_type) : 'fa-box' }} text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm">
                                                {{ $booking ? ucfirst(str_replace('_', ' ', $booking->product_type)) : 'N/A' }}
                                            </p>
                                            <p class="text-xs">
                                                {{ \Carbon\Carbon::parse($booking->checkin_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div
                                        class="px-3 py-2 text-xs rounded-full {{ $this->getStatusColor($booking->status) }} font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </div>
                                </div>
                            </div>

                            {{-- Booking details --}}
                            <div class="bg-white px-5 py-5">


                                <div class="mb-5 border-b border-gray-300 pb-5">
                                    <p class="font-semibold mb-4">Detail Pemesanan</p>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex gap-3">
                                            @if (!empty($product->images) && isset($product->images[0]))
                                                <img src="{{ $product->images[0] }}" alt="{{ $product->name }}"
                                                    class="size-12 rounded-lg object-cover">
                                            @else
                                                <div class="size-12 bg-gray-300 rounded-lg"></div>
                                            @endif
                                            <div>
                                                <p class="font-medium">
                                                    {{ $product ? $product->name : 'Product N/A' }}</p>
                                                <p class="text-xs text-gray-500">Max
                                                    @if ($product->type === 'touring')
                                                        {{ $product ? $product->max_participant : 'N/A' }}
                                                    @else
                                                        {{ $product ? $product->capacity_per_unit : 'N/A' }}
                                                    @endif
                                                    People
                                                </p>

                                            </div>
                                        </div>
                                        <div class="flex justify-between">
                                            <p class="font-medium">Jumlah Orang</p>
                                            <p class="font-medium">{{ $booking->people_count }} Orang</p>
                                        </div>
                                        @if (!$product->type == 'touring')
                                            <div class="flex justify-between">
                                                <p class="font-medium">Unit</p>
                                                <p class="font-medium">{{ $booking->unit_count }} Unit</p>
                                            </div>
                                        @endif
                                        <div class="flex justify-between">
                                            <p class="font-medium">Hari</p>
                                            <p class="font-medium">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                                Day{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) > 1 ? 's' : '' }}
                                            </p>
                                        </div>

                                        <div class="flex justify-between">
                                            <p class="font-medium">Check-in</p>
                                            <p class="font-medium">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="flex justify-between">
                                            <p class="font-medium">Check-out</p>
                                            <p class="font-medium">
                                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                            </p>
                                        </div>

                                        @if ($booking->notes)
                                            <div class="col-span-2">
                                                <p class="text-xs text-gray-500">Catatan</p>
                                                <p class="text-sm text-gray-600">{{ $booking->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="pb-4">
                                    <p class="font-semibold mb-4">Special Requests</p>
                                    @if ($booking->special_requests)
                                        <p class="text-sm text-gray-700">{{ $booking->special_requests }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">Tidak ada special requests</p>
                                    @endif
                                </div>

                                {{-- Addons --}}
                                <div class="pb-5">
                                    <p class="font-semibold mb-4">Addon</p>
                                    @php
                                        $addonItems = $booking
                                            ->bookingItems()
                                            ->whereNotNull('addon_id')
                                            ->with('addon')
                                            ->get();
                                    @endphp
                                    @if ($addonItems->count() > 0)
                                        <div class="space-y-2 text-sm text-gray-700">
                                            @foreach ($addonItems as $item)
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="font-medium">
                                                            {{ $item->addon ? $item->addon->name : 'Addon N/A' }}</p>
                                                        <p class="text-xs text-gray-500">{{ $item->quantity }}
                                                            {{ $item->addon ? strtolower($item->addon->unit) : 'pcs' }}
                                                        </p>
                                                    </div>
                                                    <p class="font-medium">Rp
                                                        {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500">Tidak ada addon</p>
                                    @endif
                                </div>


                            </div>

                            {{-- Order summary --}}
                            <div class="px-4 py-5 border border-gray-200 rounded-lg bg-gray-50 mb-5">
                                <p class="font-medium mb-3">Ringkasan Pembayaran</p>
                                @php
                                    $mainInvoice = $booking->invoices()->where('type', '!=', 'addon_onsite')->first();
                                    $addonTotal = $booking->bookingItems()->whereNotNull('addon_id')->sum('subtotal');
                                    $productTotal = $booking->subtotal - $addonTotal;
                                @endphp
                                <div class="space-y-2 text-sm text-gray-700">
                                    <div class="flex justify-between">
                                        <span>Harga Sewa</span>
                                        <span>Rp {{ number_format($productTotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Addon</span>
                                        <span>Rp {{ number_format($addonTotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Diskon</span>
                                        <span class="text-success">- Rp
                                            {{ number_format($booking->discount_amount ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                                        <span class="font-medium">Total Dibayar</span>
                                        <span class="font-bold text-primary">Rp
                                            {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                    </div>
                                    @if ($mainInvoice && $mainInvoice->payment)
                                        <div class="pt-2 text-xs text-gray-500">
                                            <p>Metode Pembayaran: <span
                                                    class="font-medium">{{ $mainInvoice->payment->payment_method ?? 'N/A' }}</span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-3 sticky bottom-0 left-0 right-0 bg-white px-4 py-3 z-80">
                                @php
                                    $latestPayment = $booking->payments()->latest()->first();
                                    $canContinuePayment =
                                        $booking->status === 'pending_payment' &&
                                        $latestPayment &&
                                        in_array($latestPayment->status, ['initiated', 'pending']) &&
                                        $latestPayment->expired_at &&
                                        \Carbon\Carbon::parse($latestPayment->expired_at)->isFuture();
                                @endphp

                                @if ($canContinuePayment)
                                    {{-- Continue Payment Button --}}
                                    <a href="{{ route('payment.show', ['token' => $booking->booking_token, 'snap_token' => $latestPayment->payment_code_or_url]) }}"
                                        class="flex-1 px-4 py-2.5 lg:py-3 rounded-full bg-warning text-white text-sm font-medium text-center hover:bg-warning/90 flex items-center justify-center gap-2">
                                        <i class="fas fa-credit-card"></i>
                                        Lanjutkan Pembayaran
                                    </a>
                                @elseif(in_array($booking->status, ['paid', 'confirmed', 'checked_in', 'completed']))
                                    {{-- Download Invoice Button --}}
                                    <button wire:click="downloadInvoice({{ $booking->id }})"
                                        class="flex-1 px-4 py-2.5 lg:py-3 rounded-full border border-gray-300 bg-white text-sm font-medium hover:bg-gray-50">
                                        Download Invoice
                                    </button>
                                @endif

                                @if (!in_array($booking->status, ['pending_payment']) || !$canContinuePayment)
                                    {{-- Book Again Button --}}
                                    <a href="{{ route('package.detail', $product->slug) }}"
                                        class="flex-1 px-4 py-2.5 lg:py-3 rounded-full bg-light-primary text-white text-sm font-medium text-center hover:bg-light-primary/90">
                                        Booking Lagi
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl px-6 py-12 text-center border border-gray-200">
                <div class="flex flex-col items-center gap-3">
                    <i class="fas fa-calendar-xmark text-gray-300 text-5xl"></i>
                    <p class="font-semibold text-gray-600">Belum ada booking</p>
                    <p class="text-sm text-gray-500">Yuk mulai petualangan dengan booking paket liburan!</p>
                    <a href="{{ route('user.dashboard') }}"
                        class="mt-4 px-6 py-2.5 rounded-full bg-light-primary text-white text-sm font-medium hover:bg-light-primary/90">
                        Lihat Paket
                    </a>
                </div>
            </div>
        @endforelse
    </div>

</div>
