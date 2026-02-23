@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button wire:click="switchToList" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $viewMode === 'create' ? 'Tambah Artikel Baru' : 'Edit Artikel' }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $viewMode === 'create' ? 'Buat artikel baru untuk website' : 'Perbarui informasi artikel' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
<form 
    wire:submit.prevent="{{ $viewMode === 'create' ? 'createArticle' : 'updateArticle' }}"
    class="space-y-6"
>
    @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Title --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model.blur="title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                        @error('title') border-red-500 @enderror"
                        placeholder="Masukkan judul artikel">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <hr class="my-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Artikel (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model.blur="title_en"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                        @error('title_en') border-red-500 @enderror"
                        placeholder="Enter article title in English">
                    @error('title_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Auto-generated Slug --}}
                    @if ($slug)
                        <div class="mt-2 p-2 bg-gray-50 rounded text-sm text-gray-600">
                            <span class="font-medium">Slug:</span> {{ $slug }}
                        </div>
                    @endif
                </div>

                {{-- Excerpt --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ringkasan <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="excerpt" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                        @error('excerpt') border-red-500 @enderror"
                        placeholder="Tulis ringkasan singkat artikel..."></textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <hr class="my-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ringkasan (English)
                    </label>
                    <textarea wire:model="excerpt_en" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                        @error('excerpt_en') border-red-500 @enderror"
                        placeholder="Write English summary..."></textarea>
                    @error('excerpt_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content with Trix Editor --}}
<div class="bg-white rounded-lg shadow-sm p-6 space-y-8">
    {{-- Editor Indonesia --}}
    <div wire:ignore wire:key="trix-indo-{{ $articleId ?? 'new' }}">
        <label class="block text-sm font-medium text-gray-700 mb-2">Konten Artikel (ID)</label>
        <div 
            x-data="{ value: @bypass_entangle }" {{-- Kita gunakan cara manual --}}
            x-init="
                $refs.editorIndo.editor.loadHTML($wire.get('content'));
            "
            @trix-change.stop="$wire.set('content', $event.target.value)"
        >
            <input id="input_indo_{{ $articleId ?? 'new' }}" type="hidden">
            <trix-editor input="input_indo_{{ $articleId ?? 'new' }}" x-ref="editorIndo" class="prose max-w-none border-gray-300 rounded-lg min-h-[300px]"></trix-editor>
        </div>
    </div>

    <hr>

    {{-- Editor English --}}
    <div wire:ignore wire:key="trix-eng-{{ $articleId ?? 'new' }}">
        <label class="block text-sm font-medium text-gray-700 mb-2">Konten Artikel (EN)</label>
        <div 
            x-data="{ valueEn: @bypass_entangle }"
            x-init="
                $refs.editorEng.editor.loadHTML($wire.get('content_en'));
            "
            @trix-change.stop="$wire.set('content_en', $event.target.value)"
        >
            <input id="input_eng_{{ $articleId ?? 'new' }}" type="hidden">
            <trix-editor input="input_eng_{{ $articleId ?? 'new' }}" x-ref="editorEng" class="prose max-w-none border-gray-300 rounded-lg min-h-[300px]"></trix-editor>
        </div>
    </div>
</div>

                {{-- Meta Description --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Description (SEO)
                    </label>
                    <textarea wire:model="meta_description" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Deskripsi untuk SEO (maksimal 160 karakter)" maxlength="160"></textarea>
                    <p class="mt-1 text-xs text-gray-500">{{ strlen($meta_description ?? '') }}/160 karakter</p>

                    <hr class="my-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Description (English)
                    </label>
                    <textarea wire:model="meta_description_en" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="SEO description in English" maxlength="160"></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        {{ strlen($meta_description_en ?? '') }}/160 karakter
                    </p>
                </div>
                
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Featured Image --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Utama
                    </label>

                    {{-- Current Image Preview (for edit mode) --}}
                    @if ($viewMode === 'edit' && $featured_image && !$new_featured_image)
                        <div class="mb-4">
                            <img src="{{ Storage::url($featured_image) }}" alt="Current Image"
                                class="w-full h-48 object-cover rounded-lg">
                            <p class="mt-2 text-xs text-gray-500">Gambar saat ini</p>
                        </div>
                    @endif

                    {{-- New Image Preview --}}
                    @if ($new_featured_image)
                        <div class="mb-4">
                            <img src="{{ $new_featured_image->temporaryUrl() }}" alt="Preview"
                                class="w-full h-48 object-cover rounded-lg">
                            <button type="button" wire:click="$set('new_featured_image', null)"
                                class="mt-2 text-sm text-red-600 hover:text-red-800">
                                <i class="fas fa-times mr-1"></i> Hapus gambar baru
                            </button>
                        </div>
                    @endif

                    {{-- File Upload --}}
                    <input type="file" wire:model="new_featured_image" accept="image/*" class="w-full">
                    @error('new_featured_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Upload Progress --}}
                    <div wire:loading wire:target="new_featured_image" class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full animate-pulse" style="width: 45%"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Uploading...</p>
                    </div>
                </div>

                {{-- Category --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="category"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent
                        @error('category') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="tips">Tips</option>
                        <option value="destinasi">Destinasi</option>
                        <option value="kuliner">Kuliner</option>
                        <option value="budaya">Budaya</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>

                {{-- Publish Date --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Publikasi
                    </label>
                    <input type="datetime-local" wire:model="published_at"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Kosongkan untuk publikasi sekarang</p>
                </div>

                {{-- Flags --}}
                <div class="bg-white rounded-lg shadow-sm p-6 space-y-4">
                    {{-- Featured --}}
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="sr-only peer">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                        <span class="ms-3 text-sm font-medium text-gray-700">Featured</span>
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-white rounded-lg shadow-sm p-6 space-y-3">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition">
                        <i class="fas fa-save mr-2"></i>
                        {{ $viewMode === 'create' ? 'Simpan Artikel' : 'Update Artikel' }}
                    </button>
                    <button type="button" wire:click="switchToList"
                        class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>


