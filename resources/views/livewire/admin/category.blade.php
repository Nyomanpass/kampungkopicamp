<div class="p-6 max-w-lg mx-auto">

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 my-2 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" wire:key="form-{{ $categoryId ?? 'new' }}" class="mb-4">
        <input 
    type="text" 
    wire:model="name"
    wire:key="{{ now() }}"
    placeholder="Nama Kategori"
    class="border p-2 w-full">


        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">
            {{ $categoryId ? 'Update' : 'Tambah' }}
        </button>
        @if($categoryId)
            <button type="button" wire:click="resetForm" class="bg-gray-500 text-white px-4 py-2 mt-2 rounded">
                Batal
            </button>
        @endif
    </form>

    <table class="w-full border">
        <thead>
            <tr>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td class="border p-2">{{ $category->name }}</td>
                    <td class="border p-2">
                        <button wire:click="edit({{ $category->id }})" class="text-blue-500">Edit</button>
                        <button wire:click="delete({{ $category->id }})" class="text-red-500 ml-2">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
