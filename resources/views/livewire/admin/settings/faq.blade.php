{{-- FAQ Management --}}
<div class="space-y-6">
    {{-- Add/Edit Form --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            {{ $editingFaq ? 'Edit FAQ' : 'Tambah FAQ Baru' }}
        </h3>

        <form wire:submit.prevent="{{ $editingFaq ? 'updateFaq' : 'addFaq' }}" class="space-y-4">
            {{-- Question --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <input type="text" wire:model="faqForm.question"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                    @error('faqForm.question') border-red-500 @enderror"
                    placeholder="Contoh: Apakah bisa refund?">
                @error('faqForm.question')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Answer --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jawaban <span class="text-red-500">*</span>
                </label>
                <textarea wire:model="faqForm.answer" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                    @error('faqForm.answer') border-red-500 @enderror"
                    placeholder="Masukkan jawaban lengkap..."></textarea>
                @error('faqForm.answer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                    <i class="fas {{ $editingFaq ? 'fa-save' : 'fa-plus' }} mr-2"></i>
                    {{ $editingFaq ? 'Update' : 'Tambah' }} FAQ
                </button>

                @if ($editingFaq)
                    <button type="button" wire:click="resetFaqForm"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- FAQ List --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">FAQ List</h3>

        @if (count($faqs) > 0)
            <div class="space-y-3">
                @foreach ($faqs as $faq)
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 mb-2">{{ $faq['question'] }}</h4>
                                <p class="text-gray-600 text-sm">{{ $faq['answer'] }}</p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <button wire:click="editFaq({{ $faq['id'] }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="deleteFaq({{ $faq['id'] }})"
                                    wire:confirm="Yakin ingin menghapus FAQ ini?"
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
                <i class="fas fa-question-circle text-4xl mb-3"></i>
                <p>Belum ada FAQ. Tambahkan FAQ pertama Anda!</p>
            </div>
        @endif
    </div>
</div>
