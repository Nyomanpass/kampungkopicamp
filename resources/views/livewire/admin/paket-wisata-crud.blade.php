<div class="p-6 max-w-6xl mx-auto mt-10">

    {{-- Notifikasi --}}
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if ($viewMode === 'list')
    <div class="flex justify-end mb-4">
        <button 
            wire:click="create" 
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            + Tambah Paket
        </button>
    </div>
    @endif


    {{-- === MODE FORM === --}}
    @if ($viewMode === 'form')
     <button wire:click="$set('viewMode','list')" type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Batal</button>
        <div class="bg-white shadow rounded p-5" wire:key="form_{{ $uploadKey }}">
            <h2 class="text-xl font-semibold mb-4">
                {{ $paket_id ? 'Edit Paket Wisata' : 'Tambah Paket Wisata' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm">Judul</label>
                    <input type="text" wire:model="title" class="w-full border rounded px-3 py-2">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm">Harga</label>
                    <input type="number" wire:model="price" class="w-full border rounded px-3 py-2">
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm">Maksimal Orang</label>
                    <input type="number" wire:model="max_person" class="w-full border rounded px-3 py-2">
                    @error('max_person') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm">Lokasi</label>
                    <input type="text" wire:model="location" class="w-full border rounded px-3 py-2">
                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm">Durasi</label>
                    <input type="text" wire:model="duration" class="w-full border rounded px-3 py-2">
                    @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm">Kategori</label>
                    <input type="text" wire:model="category" class="w-full border rounded px-3 py-2">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm">Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm">Gambar Utama</label>
                    <input type="file" wire:model="main_image" wire:key="main_image_{{ $uploadKey }}" class="w-full border rounded px-3 py-2">
                    @error('main_image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm">Gallery (foto bisa banyak)</label>
                    <input type="file" wire:model="gallery" multiple wire:key="gallery_{{ $uploadKey }}" class="w-full border rounded px-3 py-2">
                    @error('gallery.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm">Fasilitas (pisahkan dengan koma)</label>
                    <input type="text" wire:model="fasilitas" placeholder="wifi,toilet,parkir" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mt-4 flex gap-3">
                @if ($paket_id)
                    <button wire:click="update" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Perbarui</button>
                @else
                    <button wire:click="store" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                @endif
               
                <button wire:click="resetForm" type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">Reset</button>
            </div>
        </div>
    @endif


    {{-- === MODE LIST === --}}
    @if ($viewMode === 'list')
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold">Daftar Paket Wisata</h2>
        </div>

        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Judul</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Lokasi</th>
                    <th class="border p-2">Durasi</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paketList as $paket)
                    <tr>
                        <td class="border p-2">{{ $paket->title }}</td>
                        <td class="border p-2">Rp{{ number_format($paket->price, 0, ',', '.') }}</td>
                        <td class="border p-2">{{ $paket->location }}</td>
                        <td class="border p-2">{{ $paket->duration }}</td>
                        <td class="border p-2 flex gap-2">
                            <button wire:click="detail({{ $paket->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Detail</button>
                            <button wire:click="edit({{ $paket->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
                            <button 
                                onclick="if(confirm('Apakah kamu yakin ingin menghapus data ini?')) { @this.delete({{ $paket->id }}) }" 
                                class="bg-red-500 text-white px-2 py-1 rounded">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-3 text-gray-500">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif


<script>
    Livewire.on('reset-file-inputs', () => {
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.value = '';
        });
    });
</script>


    {{-- === MODE DETAIL === --}}
  @if ($viewMode === 'detail' && $selectedPaket)
    <div class="bg-white shadow rounded p-5">
        <h2 class="text-xl font-semibold mb-4">{{ $selectedPaket->title }}</h2>

        {{-- Gambar utama --}}
        @if ($selectedPaket->main_image)
            <img src="{{ asset('storage/' . $selectedPaket->main_image) }}"
                 class="w-64 h-40 object-cover mb-4 rounded">
        @endif

        <p><strong>Harga:</strong> Rp{{ number_format($selectedPaket->price, 0, ',', '.') }}</p>
        <p><strong>Lokasi:</strong> {{ $selectedPaket->location }}</p>
        <p><strong>Durasi:</strong> {{ $selectedPaket->duration }}</p>
        <p><strong>Deskripsi:</strong> {{ $selectedPaket->description }}</p>
        <p><strong>Fasilitas:</strong> {{ implode(', ', $selectedPaket->fasilitas ?? []) }}</p>

        {{-- 🖼️ Gallery --}}
        @if (!empty($selectedPaket->gallery))
            <div class="mt-5">
                <h3 class="text-lg font-semibold mb-2">Galeri</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach ($selectedPaket->gallery as $img)
                        <img src="{{ asset('storage/' . $img) }}"
                             alt="Gallery image"
                             class="w-full h-32 object-cover rounded shadow">
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-6">
            <button wire:click="$set('viewMode','list')" class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </button>
        </div>
    </div>
@endif

</div>
