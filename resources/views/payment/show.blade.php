<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('SB-Mid-client-8l77DxYcxNCYM9f8') }}"></script>
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
            </div>

            <button id="pay-button"
                class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition-colors">
                Bayar Sekarang
            </button>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
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
                    alert('Anda menutup popup pembayaran');
                }
            });
        };
    </script>
</body>

</html>
