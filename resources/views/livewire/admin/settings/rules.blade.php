{{-- House Rules Management --}}
<div class="space-y-6">
    {{-- Add/Edit Form --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            {{ $editingRule ? 'Edit Peraturan' : 'Tambah Peraturan Baru' }}
        </h3>

        <form wire:submit.prevent="{{ $editingRule ? 'updateRule' : 'addRule' }}" class="space-y-4">
            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" wire:model="ruleForm.title"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                    @error('ruleForm.title') border-red-500 @enderror"
                    placeholder="Contoh: Prosedur Check-in">
                @error('ruleForm.title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Isi Peraturan <span class="text-red-500">*</span>
                </label>
                <textarea wire:model="ruleForm.content" rows="6"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                    @error('ruleForm.content') border-red-500 @enderror"
                    placeholder="Masukkan detail peraturan..."></textarea>
                @error('ruleForm.content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                    <i class="fas {{ $editingRule ? 'fa-save' : 'fa-plus' }} mr-2"></i>
                    {{ $editingRule ? 'Update' : 'Tambah' }} Peraturan
                </button>

                @if ($editingRule)
                    <button type="button" wire:click="resetRuleForm"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- Rules List --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Peraturan</h3>

        @if (count($houseRules) > 0)
            <div class="space-y-3">
                @foreach ($houseRules as $rule)
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 mb-2">{{ $rule['title'] }}</h4>
                                <p class="text-gray-600 text-sm whitespace-pre-line">{{ $rule['content'] }}</p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <button wire:click="editRule({{ $rule['id'] }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteRule({{ $rule['id'] }})"
                                    wire:confirm="Yakin ingin menghapus peraturan ini?"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg">
                <i class="fas fa-clipboard-list text-4xl mb-3"></i>
                <p>Belum ada peraturan. Tambahkan peraturan pertama Anda!</p>
            </div>
        @endif
    </div>
</div>
