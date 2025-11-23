<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran</h1>
                <p class="text-gray-600">Booking #{{ $booking->booking_token }}</p>
            </div>

            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total Pembayaran:</span>
                    <span class="font-bold text-2xl text-primary">Rp
                        {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <p class="text-sm text-gray-500">Pembayaran akan expire dalam 2 jam</p>
                <p class="text-xs text-blue-600 mt-2">
                    <i class="fas fa-info-circle"></i>
                    Popup pembayaran akan muncul otomatis. Jika tidak muncul, klik tombol di bawah.
                </p>
            </div>

            <button id="pay-button"
                class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors flex items-center justify-center gap-2">
                Pilih Metode Pembayaran
            </button>
        </div>
    </div>

    <script type="text/javascript">
        // Function to open Midtrans payment popup
        function openPayment() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route('booking.finish', $booking->booking_token) }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route('booking.finish', $booking->booking_token) }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                },
                onClose: function() {
                    // User closed the popup, they can click button again to reopen
                    console.log('Payment popup closed by user');
                }
            });
        }

        // Attach to button click
        document.getElementById('pay-button').onclick = openPayment;

        // Auto-trigger payment popup after page loads
        window.addEventListener('load', function() {
            setTimeout(function() {
                openPayment();
            }, 1000); // Delay 1 second for better UX
        });
    </script>
</body>

</html>
