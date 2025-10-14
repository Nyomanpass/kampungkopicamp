<div class="p-6 max-w-6xl mx-auto">
    {{-- ✅ Pesan sukses --}}
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- ✅ Mode Daftar --}}
    @if ($viewMode === 'list')
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Daftar Artikel</h2>
            <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah</button>
        </div>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Judul (ID)</th>
                    <th class="border p-2">Judul (EN)</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $b)
                    <tr>
                        <td class="border p-2">{{ $b->title['id'] ?? '-' }}</td>
                        <td class="border p-2">{{ $b->title['en'] ?? '-' }}</td>
                        <td class="border p-2">{{ $b->published_at?->format('Y-m-d') ?? '-' }}</td>
                        <td class="border p-2">
                            <button wire:click="edit({{ $b->id }})" class="text-blue-600">Edit</button>
                            <button 
                                type="button"
                                onclick="confirm('Apakah kamu yakin ingin menghapus blog ini?') || event.stopImmediatePropagation()" 
                                wire:click="delete({{ $b->id }})" 
                                class="text-red-600 ml-2">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    {{-- ✅ Mode Form --}}
    @else
        <form wire:submit.prevent="{{ $blog_id ? 'update' : 'store' }}" class="space-y-4">

            {{-- ===== JUDUL ===== --}}
            <div>
                <label class="block font-semibold">Judul (Indonesia)</label>
                <input type="text" wire:model="title.id" placeholder="Judul dalam Bahasa Indonesia"
                    class="w-full border p-2 rounded">
                @error('title.id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-semibold">Judul (English)</label>
                <input type="text" wire:model="title.en" placeholder="Title in English"
                    class="w-full border p-2 rounded">
                @error('title.en') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- ===== DESKRIPSI ===== --}}
            <div>
                <label class="block font-semibold">Deskripsi (Indonesia)</label>
                <textarea wire:model="description.id" placeholder="Deskripsi singkat Bahasa Indonesia"
                    class="w-full border p-2 rounded"></textarea>
                @error('description.id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-semibold">Deskripsi (English)</label>
                <textarea wire:model="description.en" placeholder="Short description in English"
                    class="w-full border p-2 rounded"></textarea>
                @error('description.en') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- ===== GAMBAR UTAMA & TANGGAL ===== --}}
            <div>
                <label class="block font-semibold">Gambar Utama</label>
                <input type="file" wire:model="main_image" key="{{ $uploadKey }}" class="w-full border p-2 rounded">
                @if ($main_image)
                    <p class="text-sm text-gray-600 mt-1">Preview gambar baru:</p>
                    <img src="{{ $main_image->temporaryUrl() }}" class="h-32 mt-2 rounded">
                @elseif ($blog_id && $blogs->find($blog_id)?->main_image)
                    <p class="text-sm text-gray-600 mt-1">Gambar tersimpan:</p>
                    <img src="{{ asset('storage/' . $blogs->find($blog_id)->main_image) }}" class="h-32 mt-2 rounded">
                @endif
            </div>

            <div>
                <label class="block font-semibold">Tanggal Publikasi</label>
                <input type="date" wire:model="published_at" class="w-full border p-2 rounded">
            </div>

            {{-- ===== KONTEN TAMBAHAN ===== --}}
            <div class="border-t pt-4">
                <h3 class="font-semibold mb-2">Konten Tambahan</h3>
              @foreach ($contents as $index => $content)
    {{-- ✅ PERBAIKAN 1: Tambahkan wire:key di container div --}}
    <div class="border p-3 mb-3 rounded bg-gray-50" wire:key="content-block-{{ $content['key'] ?? $index }}">

        {{-- Konten ID --}}
        <textarea wire:model="contents.{{ $index }}.content.id"
                  placeholder="Isi konten (Indonesia)"
                  class="w-full border p-2 rounded mb-2"></textarea>

        {{-- Konten EN --}}
        <textarea wire:model="contents.{{ $index }}.content.en"
                  placeholder="Content (English)"
                  class="w-full border p-2 rounded mb-2"></textarea>

     {{-- Input Gambar --}}
           <input type="file"
               wire:model="contents.{{ $index }}.image"
               {{-- ✅ PERBAIKAN 2 (Opsional tapi disarankan): Ganti wire:key input file --}}
               wire:key="{{ $content['key'] ?? $index }}-input-image" 
               class="w-full border p-2 rounded mb-2">

       {{-- Preview Gambar: Disederhanakan --}}
        @if (!empty($contents[$index]['image']))
            <p class="text-sm text-gray-600 mt-1">Preview gambar baru:</p>
            <img src="{{ $contents[$index]['image']->temporaryUrl() }}" 
                 wire:key="temp-image-{{ $index }}-{{ now()->timestamp }}" 
                 class="h-32 mt-2 rounded">
        @elseif (!empty($contents[$index]['old_image']))
            <p class="text-sm text-gray-600 mt-1">Gambar tersimpan:</p>
            <img src="{{ asset('storage/' . $contents[$index]['old_image']) }}" class="h-32 mt-2 rounded">
        @endif


        {{-- Hapus Blok --}}
        <button type="button"
                wire:click="removeContentBlock({{ $index }})"
                class="text-red-600 text-sm">
            Hapus konten
        </button>
    </div>
@endforeach


                <button type="button" wire:click="addContentBlock" class="bg-gray-200 px-3 py-1 rounded">
                    + Tambah konten
                </button>
            </div>
  

            {{-- ===== TOMBOL AKSI ===== --}}
            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                    {{ $blog_id ? 'Update' : 'Simpan' }}
                </button>
                <button type="button" wire:click="$set('viewMode', 'list')" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Batal
                </button>
            </div>
        </form>
    @endif
</div>
