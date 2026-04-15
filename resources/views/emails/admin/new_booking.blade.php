<x-mail::message>
# Booking Baru Telah Dibayar

Halo Admin,

Ada booking baru yang telah dibayar. Berikut adalah rincian transaksinya:

<x-mail::panel>
**Token Booking:** {{ $booking->booking_token }}  
**Nama Pelanggan:** {{ $booking->customer_name }}  
**Tanggal Check-in:** {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}  
**Tanggal Check-out:** {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}  
**Total Pembayaran:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
</x-mail::panel>

Silakan klik tombol di bawah ini untuk melihat detail lebih lanjut di dashboard admin.

<x-mail::button :url="route('admin.bookings') . '?view=detail&id=' . $booking->id">
Lihat Detail Booking
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
