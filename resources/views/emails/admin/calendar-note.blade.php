<x-mail::message>
    # Catatan Ketersediaan Kalender

    Halo Admin,

    Ada catatan baru yang ditambahkan pada ketersediaan produk {{ $productName }}. Berikut adalah detailnya:

    <x-mail::panel>
        **Produk:** {{ $productName }}
        **Tanggal:** {{ $date }}
        **Ditambahkan oleh:** {{ $userName }}
        **Waktu:** {{ now()->format('d M Y H:i') }}
    </x-mail::panel>

    ## Catatan:

    {{ $notes }}

    Silakan klik tombol di bawah ini untuk melihat detail ketersediaan di dashboard admin.

    <x-mail::button :url="route('admin.availabilities')">
        Lihat Kalender Ketersediaan
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
