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

        <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200" wire:key="form_{{ $uploadKey }}">

        <h2 class="text-xl font-semibold mb-6 flex items-center justify-between">
            {{ $paket_id ? 'Edit Paket Wisata' : 'Tambah Paket Wisata' }}
            <button wire:click="$set('viewMode','list')" type="button"
                class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded">
                ✕ Batal
            </button>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Judul --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Judul</label>
                <input type="text" wire:model="title.id" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Judul (ID)">
                <input type="text" wire:model="title.en" class="mt-2 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Title (EN)">
                @error('title.id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @error('title.en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Harga --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Harga</label>
                <input type="number" wire:model="price" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Maksimal Orang --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Maksimal Orang</label>
                <input type="number" wire:model="max_person" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                @error('max_person') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" wire:model="location" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Durasi --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Durasi</label>
                <input type="text" wire:model="duration" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Kategori</label>
                <select wire:model="category_id" wire:key="category-select-{{ $uploadKey }}" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">
                            {{ is_array($cat->name) ? $cat->name['id'] ?? '' : $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea wire:model="description.id" class="mt-1 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Deskripsi (ID)"></textarea>
                <textarea wire:model="description.en" class="mt-2 w-full border rounded px-3 py-2 focus:ring focus:ring-blue-200" placeholder="Description (EN)"></textarea>
            </div>

            {{-- Gambar Utama --}}
            <div class="md:col-span-2">
                <label class="block font-semibold">Gambar Utama</label>
                <input type="file" wire:model="main_image" wire:key="main_image_{{ $uploadKey }}" class="w-full border p-2 rounded mt-1">
                
                @if ($main_image)
                    <p class="text-sm text-gray-600 mt-1">Preview gambar baru:</p>
                    <img src="{{ $main_image->temporaryUrl() }}" class="h-32 mt-2 rounded shadow">
                @elseif ($paket_id && $selectedPaket?->main_image)
                    <p class="text-sm text-gray-600 mt-1">Gambar tersimpan:</p>
                    <img src="{{ asset('storage/' . $selectedPaket->main_image) }}" class="h-32 mt-2 rounded shadow">
                @endif
            </div>

            {{-- Gallery --}}
           <div class="md:col-span-2">
                <label class="block font-semibold">Gallery (foto bisa banyak)</label>
                <input type="file" wire:model="gallery" multiple wire:key="gallery_{{ $uploadKey }}" class="w-full border p-2 rounded mt-1">

                {{-- Preview Gambar Baru --}}
                @if(!empty($gallery))
                    <p class="text-sm text-gray-600 mt-1">Preview gambar baru:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($gallery as $img)
                            <img src="{{ $img->temporaryUrl() }}" class="h-24 rounded shadow">
                        @endforeach
                    </div>

                {{-- Tampilkan Gallery Lama Jika Belum Pilih File Baru --}}
                @elseif($paket_id && !empty($selectedPaket?->gallery))
                    <p class="text-sm text-gray-600 mt-2">Gallery tersimpan:</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($selectedPaket->gallery as $img)
                            <img src="{{ asset('storage/' . $img) }}" class="h-24 rounded shadow">
                        @endforeach
                    </div>
                @endif
            </div>



            {{-- Fasilitas --}}
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">Fasilitas (pisahkan dengan koma)</label>
                <input type="text" wire:model="fasilitas.id" class="mt-1 w-full border rounded px-3 py-2" placeholder="wifi,toilet,parkir">
                <input type="text" wire:model="fasilitas.en" class="mt-2 w-full border rounded px-3 py-2" placeholder="wifi,toilet,parking">
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex gap-3">
            @if ($paket_id)
                <button type="button" wire:click="update" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Perbarui</button>
            @else
                <button type="button" wire:click="store" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
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

        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden text-sm shadow">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Harga</th>
                    <th class="px-4 py-3 text-left">Lokasi</th>
                    <th class="px-4 py-3 text-left">Durasi</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($paketList as $paket)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 font-medium text-gray-800">
                            {{ is_array($paket->title) ? ($paket->title['id'] ?? '') : $paket->title }}
                        </td>
                        <td class="px-4 py-2 text-gray-600">Rp{{ number_format($paket->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $paket->location }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $paket->duration }}</td>
                        <td class="px-4 py-2 flex justify-center gap-2">

                            <button wire:click="detail({{ $paket->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                Detail
                            </button>

                            <button wire:click="edit({{ $paket->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                Edit
                            </button>

                            <button 
                                onclick="if(confirm('Apakah kamu yakin ingin menghapus data ini?')) { @this.delete({{ $paket->id }}) }"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Hapus
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data.</td>
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
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto">
        <!-- Judul -->
        <h2 class="text-2xl font-bold mb-4 text-gray-800">
            {{ $selectedPaket->title['id'] ?? '' }}
        </h2>

        <!-- Gambar Utama -->
        @if ($selectedPaket->main_image)
            <img src="{{ asset('storage/' . $selectedPaket->main_image) }}" 
                 class="w-full h-64 md:h-80 object-cover mb-6 rounded-lg shadow" 
                 alt="Main Image">
        @endif

        <!-- Info Paket -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <p><strong>Harga:</strong> <span class="text-green-600 font-semibold">Rp{{ number_format($selectedPaket->price, 0, ',', '.') }}</span></p>
            <p><strong>Lokasi:</strong> {{ $selectedPaket->location }}</p>
            <p><strong>Durasi:</strong> {{ $selectedPaket->duration }}</p>
            <p><strong>Fasilitas (ID):</strong> {{ isset($selectedPaket->fasilitas['id']) ? implode(', ', $selectedPaket->fasilitas['id']) : '-' }}</p>
            <p><strong>Fasilitas (EN):</strong> {{ isset($selectedPaket->fasilitas['en']) ? implode(', ', $selectedPaket->fasilitas['en']) : '-' }}</p>
        </div>

        <!-- Deskripsi -->
        <div class="mb-6">
            <h3 class="font-semibold mb-2">Deskripsi (ID)</h3>
            <p class="text-gray-700">{{ $selectedPaket->description['id'] ?? '-' }}</p>

            <h3 class="font-semibold mt-4 mb-2">Deskripsi (EN)</h3>
            <p class="text-gray-700">{{ $selectedPaket->description['en'] ?? '-' }}</p>
        </div>

        <!-- Galeri -->
        @if (!empty($selectedPaket->gallery))
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">Galeri</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach ($selectedPaket->gallery as $img)
                        <img src="{{ asset('storage/' . $img) }}" 
                             alt="Gallery image" 
                             class="w-full h-32 object-cover rounded shadow-sm hover:scale-105 transition">
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tombol Kembali -->
        <div class="text-right">
            <button wire:click="$set('viewMode','list')" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded transition">
                Kembali
            </button>
        </div>
    </div>
@endif


</div>
