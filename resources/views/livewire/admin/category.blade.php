<div class="p-6 max-w-2xl mx-auto bg-white shadow-md rounded-lg">

    {{-- Notifikasi --}}
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded border border-green-300">
            {{ session('message') }}
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit.prevent="save" wire:key="form-{{ $categoryId ?? 'new' }}" class="space-y-3 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori (ID)</label>
            <input 
                type="text" 
                wire:model.defer="name.id"
                class="border p-2 w-full rounded focus:ring focus:ring-blue-200"
                placeholder="Contoh: Penginapan">
            @error('name.id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori (EN)</label>
            <input 
                type="text" 
                wire:model.defer="name.en"
                class="border p-2 w-full rounded focus:ring focus:ring-blue-200"
                placeholder="Example: Accommodation">
            @error('name.en') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                {{ $categoryId ? 'Update' : 'Tambah' }}
            </button>

            @if($categoryId)
                <button type="button" wire:click="resetForm" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Batal
                </button>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="overflow-hidden rounded-lg border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left font-medium text-gray-700">Nama</th>
                    <th class="p-3 text-center font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $category->name[$lang] ?? '' }}</td>
                        <td class="p-3 text-center">
                            <button wire:click="edit({{ $category->id }})" class="text-blue-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $category->id }})" class="text-red-600 hover:underline ml-3">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
