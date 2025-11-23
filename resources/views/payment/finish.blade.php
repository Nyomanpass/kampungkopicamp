<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pembayaran - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-14 px-4">
        <div class="max-w-2xl w-full">
            @if ($booking->status === 'paid')
                <!-- Success State -->
                <div class="bg-white rounded-2xl md:shadow-lg md:p-8 text-center">
                    <!-- Success Icon -->
                    <div class="w-20 h-20 bg-success/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-gray-600 mb-8">Booking Anda telah dikonfirmasi</p>

                    <!-- Booking Details Card -->
                    <div class="bg-light-primary text-white rounded-xl p-6 mb-6">
                        <div class="text-sm opacity-90 mb-2">Booking Code</div>
                        <div class="text-3xl font-bold tracking-wider mb-4">
                            <span id="bookingToken">{{ $booking->booking_token }}</span>
                            <button onclick="copyBookingToken()" class="ml-2 hover:opacity-70 transition-opacity"
                                title="Salin kode booking">
                                <i class="text-xl fas fa-copy active:scale-95 transition-all"></i>
                            </button>
                        </div>
                        <div id="copyNotification"
                            class="fixed top-4 right-4 bg-success text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-[400px] transition-transform duration-300 ease-in-out z-50">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-medium">Kode booking berhasil disalin!</span>
                            </div>
                        </div>


                        <div class="border-t border-white/20 pt-4">
                            <div class="grid grid-cols-2 gap-4 text-left">
                                <div>
                                    <div class="text-xs opacity-75 mb-1">Nama Pemesan</div>
                                    <div class="font-semibold">{{ $booking->customer_name }}</div>
                                </div>
                                <div>
                                    <div class="text-xs opacity-75 mb-1">Check-in</div>
                                    <div class="font-semibold">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} - 14.00 WITA
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs opacity-75 mb-1">Email</div>
                                    <div class="font-semibold text-sm">{{ $booking->customer_email }}</div>
                                </div>
                                <div>
                                    <div class="text-xs opacity-75 mb-1">Durasi</div>
                                    <div class="font-semibold">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }}
                                        malam</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Items -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                        <h3 class="font-semibold text-gray-900 mb-4">Detail Booking</h3>

                        @foreach ($booking->bookingItems as $item)
                            <div
                                class="flex justify-between items-start mb-3 pb-3 border-b border-gray-200 last:border-0 last:mb-0 last:pb-0">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $item->name_snapshot }}</div>
                                    <div class="text-sm text-gray-600">
                                        @if ($item->item_type === 'product')
                                            <span class="bg-primary/10 text-primary px-2 py-0.5 rounded text-xs">Produk
                                                Utama</span>
                                        @else
                                            <span
                                                class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded text-xs">Add-on</span>
                                        @endif
                                        <span class="ml-2">{{ $item->qty }}x @ Rp
                                            {{ number_format($item->unit_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="font-semibold text-gray-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4 pt-4 border-t-2 border-gray-300 flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total Dibayar:</span>
                            <span class="text-2xl font-bold text-primary">Rp
                                {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-left text-sm text-blue-900">
                                <p class="font-semibold mb-1">Email konfirmasi telah dikirim!</p>
                                <p>Kami telah mengirim detail booking ke
                                    <strong>{{ $booking->customer_email }}</strong>. Simpan kode booking Anda untuk
                                    check-in.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        @if (auth()->check())
                            <a href="{{ route('user.dashboard') }}"
                                class="flex-1 bg-white border-2 border-primary text-primary py-3 px-6 rounded-lg font-semibold hover:bg-primary/5 transition-colors">
                                Kembali ke Beranda
                            </a>
                        @else
                            <a href="{{ route('home') }}"
                                class="flex-1 bg-white border-2 border-primary text-primary py-3 px-6 rounded-lg font-semibold hover:bg-primary/5 transition-colors">
                                Kembali ke Awal
                            </a>
                        @endif
                        @php
                            $invoice = $booking->invoices()->primary()->first();
                        @endphp

                        @if ($invoice)
                            <a href="{{ route('invoice.download', $invoice->id) }}"
                                class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-light-primary transition-colors">
                                <i class="fas fa-file-invoice mr-2"></i>
                                Download Invoice
                            </a>
                        @endif
                        {{-- <button onclick="window.print()"
                            class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                            Cetak Bukti Booking
                        </button> --}}
                    </div>
                </div>
            @elseif($booking->status === 'pending_payment')
                <!-- Pending State -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <!-- Pending Icon -->
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Menunggu Pembayaran</h1>
                    <p class="text-gray-600 mb-6">Pembayaran Anda sedang diproses</p>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-yellow-800">
                            Booking #<strong>{{ $booking->booking_token }}</strong> sedang menunggu konfirmasi
                            pembayaran.
                            Proses ini biasanya memakan waktu beberapa menit.
                        </p>
                    </div>

                    @php
                        $payment = $booking->payments()->latest()->first();
                        $expiryTime = $payment ? \Carbon\Carbon::parse($payment->expired_at) : null;
                    @endphp

                    @if ($expiryTime && $expiryTime->isFuture())
                        <div class="mb-6">
                            <p class="text-sm text-gray-600 mb-2">Pembayaran akan expire dalam:</p>
                            <div class="text-3xl font-bold text-gray-900" id="countdown">
                                {{ $expiryTime->diffForHumans() }}
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col gap-3">
                        <button onclick="window.location.reload()"
                            class="bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                            Refresh Status
                        </button>
                        @if (auth()->check())
                            <a href="{{ route('user.dashboard') }}"
                                class="text-gray-600 hover:text-gray-900 text-sm  lg:text-base">
                                Kembali ke Beranda
                            </a>
                        @else
                            <a href="{{ route('home') }}"
                                class="text-gray-600 hover:text-gray-900 text-sm lg:text-base">
                                Kembali ke Awal
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <!-- Failed/Expired State -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <!-- Error Icon -->
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        @if ($booking->status === 'expired')
                            Pembayaran Expired
                        @elseif($booking->status === 'cancelled')
                            Booking Dibatalkan
                        @else
                            Pembayaran Gagal
                        @endif
                    </h1>
                    <p class="text-gray-600 mb-6">Booking #{{ $booking->booking_token }}</p>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-red-800">
                            @if ($booking->status === 'expired')
                                Waktu pembayaran telah habis. Silakan buat booking baru untuk melanjutkan.
                            @elseif($booking->status === 'cancelled')
                                Booking Anda telah dibatalkan. Jika ada pertanyaan, silakan hubungi customer service
                                kami.
                            @else
                                Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi atau hubungi customer
                                service.
                            @endif
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('home') }}"
                            class="bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                            Buat Booking Baru
                        </a>
                        @if (auth()->check())
                            <a href="{{ route('user.dashboard') }}"
                                class="text-gray-600 hover:text-gray-900 text-sm  lg:text-base">
                                Kembali ke Beranda
                            </a>
                        @else
                            <a href="{{ route('home') }}"
                                class="text-gray-600 hover:text-gray-900 text-sm lg:text-base">
                                Kembali ke Awal
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    <!-- Prevent Back Navigation -->
    <script>
        // Prevent back button
        (function(window) {
            if (typeof window.history.pushState === 'function') {
                // Push current state to history
                window.history.pushState(null, null, window.location.href);

                // Listen for popstate event (back button)
                window.addEventListener('popstate', function() {
                    // Push state again to prevent going back
                    window.history.pushState(null, null, window.location.href);

                    // Optional: Show alert
                    // alert('Gunakan tombol "Kembali ke Beranda" untuk navigasi.');
                });
            }
        })(window);
    </script>

    <!-- Auto-refresh for pending status -->
    @if ($booking->status === 'pending_payment')
        <script>
            // Auto refresh every 10 seconds
            setTimeout(() => {
                window.location.reload();
            }, 10000);
        </script>
    @endif


    <script>
        function copyBookingToken() {
            const tokenText = document.getElementById('bookingToken').textContent;

            // Check if clipboard API is available
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(tokenText).then(() => {
                    showNotification();
                }).catch(() => {
                    fallbackCopy(tokenText);
                });
            } else {
                fallbackCopy(tokenText);
            }
        }

        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                showNotification();
            } catch (err) {
                showNotification(false);
            }
            document.body.removeChild(textArea);
        }

        function showNotification(success = true) {
            const notification = document.getElementById('copyNotification');

            if (!success) {
                notification.classList.remove('bg-green-500');
                notification.classList.add('bg-red-500');
                notification.querySelector('span').textContent = 'Gagal menyalin kode booking';
            }

            // Show notification
            notification.classList.remove('translate-x-[400px]');
            notification.classList.add('translate-x-0');

            // Hide after 3 seconds
            setTimeout(() => {
                notification.classList.remove('translate-x-0');
                notification.classList.add('translate-x-[400px]');
            }, 3000);
        }
    </script>
</body>

</html>
