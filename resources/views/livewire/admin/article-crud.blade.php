<div class="p-6 max-w-6xl mx-auto">
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if ($viewMode === 'list')
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Daftar Blog</h2>
            <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded">+ Tambah</button>
        </div>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Judul</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $b)
                    <tr>
                        <td class="border p-2">{{ $b->title }}</td>
                        <td class="border p-2">{{ $b->published_date ?? '-' }}</td>
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
    @else
        <form wire:submit.prevent="{{ $blog_id ? 'update' : 'store' }}" class="space-y-4">
            <input type="text" wire:model="title" placeholder="Judul" class="w-full border p-2 rounded">
            <textarea wire:model="description" placeholder="Deskripsi singkat" class="w-full border p-2 rounded"></textarea>
            <input type="file" wire:model="main_image" key="{{ $uploadKey }}" class="w-full border p-2 rounded">
            <input type="date" wire:model="published_at" class="w-full border p-2 rounded">

            <div class="border-t pt-4">
                <h3 class="font-semibold mb-2">Konten Tambahan</h3>
                @foreach ($contents as $index => $content)
                    <div class="border p-3 mb-3 rounded">
                        <textarea wire:model="contents.{{ $index }}.content" class="w-full border p-2 rounded mb-2" placeholder="Isi konten..."></textarea>
                        <input type="file" wire:model="contents.{{ $index }}.image" class="w-full border p-2 rounded mb-2">
                        <button 
                            type="button" 
                            onclick="confirm('Apakah kamu yakin ingin menghapus konten ini?') || event.stopImmediatePropagation()" 
                            wire:click="removeContentBlock({{ $index }})" 
                            class="text-red-600 text-sm">
                            Hapus konten
                        </button>
                    </div>
                @endforeach

                <button type="button" wire:click="addContentBlock" class="bg-gray-200 px-3 py-1 rounded">+ Tambah konten</button>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                    {{ $blog_id ? 'Update' : 'Simpan' }}
                </button>
                <button type="button" wire:click="$set('viewMode', 'list')" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            </div>
        </form>
    @endif
</div>
