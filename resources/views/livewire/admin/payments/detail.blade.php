@if ($selectedPayment)
    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <button wire:click="switchToList"
                    class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </button>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">Payment Details</h2>
                    <p class="text-xs md:text-sm text-gray-600 mt-1">Complete transaction information</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex items-center gap-2">
                @if ($selectedPayment->status === 'settlement' && $selectedPayment->booking)
                    <button wire:click="downloadInvoice({{ $selectedPayment->id }})"
                        class="bg-light-primary hover:bg-light-primary/80 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center gap-2">
                        <i class="fas fa-file-download"></i>
                        <span class="hidden md:inline">Download Invoice</span>
                    </button>
                @endif

                {{-- @if ($selectedPayment->status === 'pending')
                    <button wire:click="markAsPaid({{ $selectedPayment->id }})"
                        onclick="return confirm('Mark this payment as paid?')"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        <span class="hidden md:inline">Mark as Paid</span>
                    </button>
                @endif

                @if (in_array($selectedPayment->status, ['pending', 'initiated']))
                    <button wire:click="cancelPayment({{ $selectedPayment->id }})"
                        onclick="return confirm('Cancel this payment?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center gap-2">
                        <i class="fas fa-ban"></i>
                        <span class="hidden md:inline">Cancel</span>
                    </button>
                @endif

                @if ($selectedPayment->status === 'settlement')
                    <button wire:click="refundPayment({{ $selectedPayment->id }})"
                        onclick="return confirm('Refund this payment?')"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-all flex items-center gap-2">
                        <i class="fas fa-undo"></i>
                        <span class="hidden md:inline">Refund</span>
                    </button>
                @endif --}}
            </div>
        </div>
    </div>

    {{-- Payment Status Card --}}
    <div
        class="bg-gradient-to-br 
        {{ $selectedPayment->status === 'settlement' ? 'from-success to-success/80' : '' }}
        {{ $selectedPayment->status === 'pending' ? 'from-warning to-warning/80' : '' }}
        {{ $selectedPayment->status === 'expire' ? 'from-status-expired to-status-expired/80' : '' }}
        {{ $selectedPayment->status === 'cancel' ? 'from-danger to-danger/80' : '' }}
        {{ $selectedPayment->status === 'refund' ? 'from-status-refunded to-status-refunded/80' : '' }}
        rounded-lg shadow-lg p-6 text-white">

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i
                        class="fas 
                        {{ $selectedPayment->status === 'settlement' ? 'fa-check-circle' : '' }}
                        {{ $selectedPayment->status === 'pending' ? 'fa-clock' : '' }}
                        {{ $selectedPayment->status === 'expire' ? 'fa-times-circle' : '' }}
                        {{ $selectedPayment->status === 'cancel' ? 'fa-ban' : '' }}
                        {{ $selectedPayment->status === 'refund' ? 'fa-undo' : '' }}
                        text-3xl"></i>
                </div>
                <div>
                    <p class="text-sm opacity-90">Payment Status</p>
                    <p class="text-2xl font-bold capitalize">{{ $selectedPayment->status }}</p>
                </div>
            </div>

            <div class="text-right">
                <p class="text-sm opacity-90">Total Amount</p>
                <p class="text-3xl font-bold">Rp {{ number_format($selectedPayment->amount) }}</p>
            </div>
        </div>

        {{-- Expiry Countdown --}}
        @if ($selectedPayment->expired_at && !$selectedPayment->isExpired() && $selectedPayment->status === 'pending')
            <div class="bg-white/20 rounded-lg p-4 backdrop-blur-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-hourglass-half"></i>
                        <span class="font-semibold">Payment expires in:</span>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold">{{ $selectedPayment->expired_at->diffForHumans() }}</p>
                        <p class="text-xs opacity-75">{{ $selectedPayment->expired_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Payment Timeline --}}
        <div class="mt-4 pt-4 border-t border-white/20 grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
            <div>
                <p class="opacity-75 mb-1">Created</p>
                <p class="font-semibold">{{ $selectedPayment->created_at->format('d M Y, H:i') }}</p>
            </div>
            @if ($selectedPayment->paid_at)
                <div>
                    <p class="opacity-75 mb-1">Paid At</p>
                    <p class="font-semibold">{{ $selectedPayment->paid_at->format('d M Y, H:i') }}</p>
                </div>
            @endif
            @if ($selectedPayment->expired_at)
                <div>
                    <p class="opacity-75 mb-1">Expires At</p>
                    <p class="font-semibold">{{ $selectedPayment->expired_at->format('d M Y, H:i') }}</p>
                </div>
            @endif
            <div>
                <p class="opacity-75 mb-1">Provider</p>
                <p class="font-semibold capitalize">{{ $selectedPayment->provider }}</p>
            </div>
        </div>
    </div>

    {{-- Payment & Booking Information --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Payment Information --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-file-invoice text-primary"></i>
                Payment Information
            </h3>


            <div class="space-y-4">
                {{-- Order ID --}}
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Order ID</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $selectedPayment->order_id }}</span>
                </div>

                {{-- Payment ID --}}
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Payment ID</span>
                    <span class="text-sm font-semibold text-gray-900">#{{ $selectedPayment->id }}</span>
                </div>

                {{-- Payment Code/URL --}}
                @if ($selectedPayment->payment_code_or_url)
                    <div class="py-3 border-b border-gray-100">
                        <p class="text-sm text-gray-600 mb-2">Payment Code/URL</p>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-sm font-mono text-gray-900 break-all">
                                {{ $selectedPayment->payment_code_or_url }}</p>
                            @if (filter_var($selectedPayment->payment_code_or_url, FILTER_VALIDATE_URL))
                                <a href="{{ $selectedPayment->payment_code_or_url }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-xs text-blue-600 hover:text-blue-700 mt-2">
                                    <i class="fas fa-external-link-alt"></i>
                                    Open Payment Page
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Amount --}}
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Amount</span>
                    <span class="text-lg font-bold text-primary">Rp
                        {{ number_format($selectedPayment->amount) }}</span>
                </div>

                {{-- Provider --}}
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Provider</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 capitalize">
                        {{ $selectedPayment->provider }}
                    </span>
                </div>

                {{-- Status --}}
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600">Status</span>
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full
                        {{ $selectedPayment->status === 'settlement' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $selectedPayment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $selectedPayment->status === 'expire' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $selectedPayment->status === 'cancel' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $selectedPayment->status === 'refund' ? 'bg-purple-100 text-purple-800' : '' }}">
                        {{ ucfirst($selectedPayment->status) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Booking Information --}}
        @if ($selectedPayment->booking)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-calendar-check text-primary"></i>
                    Booking Information
                </h3>

                <div class="space-y-2">
                    {{-- Customer Info --}}
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $selectedPayment->booking->user->name ?? 'Guest' }}</p>
                                <p class="text-xs text-gray-600">{{ $selectedPayment->booking->customer_email ?? '-' }}
                                </p>
                                @if ($selectedPayment->booking->customer_phone)
                                    <p class="text-xs text-gray-600">{{ $selectedPayment->booking->customer_phone }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Booking Token --}}
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Booking Token</span>
                        <span
                            class="text-sm font-semibold text-gray-900">{{ $selectedPayment->booking->booking_token }}</span>
                    </div>

                    {{-- product Type --}}
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Type</span>
                        <span
                            class="text-sm font-semibold text-gray-900">{{ $selectedPayment->booking->product_type }}</span>
                    </div>

                    {{-- Check-in / Check-out --}}
                    @if ($selectedPayment->booking->start_date && $selectedPayment->booking->end_date)
                        <div class="py-3 border-b border-gray-100 flex justify-between">
                            <p class="text-sm text-gray-600 mb-2">Check-in / Check-out</p>
                            <div class="flex flex-col items-end gap-1 text-sm">
                                <div class="">
                                    <span
                                        class="font-semibold text-gray-900">{{ $selectedPayment->booking->start_date->format('d M Y') }}</span>
                                    <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                    <span
                                        class="font-semibold text-gray-900">{{ $selectedPayment->booking->end_date->format('d M Y') }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $selectedPayment->booking->start_date->diffInDays($selectedPayment->booking->end_date) }}
                                    night(s)
                                </p>
                            </div>

                        </div>
                    @endif

                    {{-- Guests --}}
                    @if ($selectedPayment->booking->people_count)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Guests</span>
                            <span
                                class="text-sm font-semibold text-gray-900">{{ $selectedPayment->booking->people_count }}
                                person(s)</span>
                        </div>
                    @endif

                    {{-- Booking Status --}}
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm text-gray-600">Booking Status</span>
                        <span
                            class="px-3 py-1 text-xs font-semibold rounded-full capitalize
                            {{ $selectedPayment->booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $selectedPayment->booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $selectedPayment->booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $selectedPayment->booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ $selectedPayment->booking->status }}
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Webhook Payload (for debugging) --}}
    @if ($selectedPayment->raw_payload)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-code text-primary"></i>
                    Webhook Payload
                </h3>
                <button onclick="copyPayload()"
                    class="text-sm text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2">
                    <i class="fas fa-copy"></i>
                    Copy JSON
                </button>
            </div>

            <div class="bg-gray-900 rounded-lg p-4 overflow-auto max-h-96">
                <pre id="payloadContent" class="text-xs text-green-400 font-mono">{{ json_encode($selectedPayment->raw_payload, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>

        @push('scripts')
            <script>
                function copyPayload() {
                    const content = document.getElementById('payloadContent').textContent;
                    navigator.clipboard.writeText(content).then(() => {
                        alert('Payload copied to clipboard!');
                    });
                }
            </script>
        @endpush
    @endif

    {{-- Activity Log (if you have one) --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-history text-primary"></i>
            Activity Timeline
        </h3>

        <div class="space-y-4">
            {{-- Payment Created --}}
            <div class="flex gap-4">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-plus text-blue-600"></i>
                    </div>
                    <div class="flex-1 w-0.5 bg-gray-200 my-2"></div>
                </div>
                <div class="flex-1 pb-8">
                    <p class="font-semibold text-gray-900 text-sm">Payment Created</p>
                    <p class="text-xs text-gray-600">{{ $selectedPayment->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Payment initiated with {{ $selectedPayment->provider }}</p>
                </div>
            </div>

            {{-- Payment Status Changes --}}
            @if ($selectedPayment->paid_at)
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        @if ($selectedPayment->status === 'refund')
                            <div class="flex-1 w-0.5 bg-gray-200 my-2"></div>
                        @endif
                    </div>
                    <div class="flex-1 {{ $selectedPayment->status === 'refund' ? 'pb-8' : '' }}">
                        <p class="font-semibold text-gray-900 text-sm">Payment Confirmed</p>
                        <p class="text-xs text-gray-600">{{ $selectedPayment->paid_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Payment successfully processed</p>
                    </div>
                </div>
            @endif

            {{-- Refund --}}
            @if ($selectedPayment->status === 'refund')
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-undo text-purple-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">Payment Refunded</p>
                        <p class="text-xs text-gray-600">{{ $selectedPayment->updated_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Amount refunded to customer</p>
                    </div>
                </div>
            @endif

            {{-- Cancelled --}}
            @if ($selectedPayment->status === 'cancel')
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-ban text-red-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">Payment Cancelled</p>
                        <p class="text-xs text-gray-600">{{ $selectedPayment->updated_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Payment was cancelled</p>
                    </div>
                </div>
            @endif

            {{-- Expired --}}
            @if ($selectedPayment->status === 'expire')
                <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-times-circle text-gray-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">Payment Expired</p>
                        <p class="text-xs text-gray-600">
                            {{ $selectedPayment->expired_at?->format('d M Y, H:i') ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Payment link has expired</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif
