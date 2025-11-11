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
    <form wire:submit.prevent="{{ $viewMode === 'create' ? 'createArticle' : 'updateArticle' }}" x-data="{
        submitForm(event) {
            console.log('Form submit triggered, mode:', '{{ $viewMode }}');
            console.log('Will call method:', '{{ $viewMode === 'create' ? 'createArticle' : 'updateArticle' }}');
    
            // Ensure Trix content is synced before submit
            const trixEditor = document.querySelector('trix-editor');
            const hiddenInput = trixEditor ? document.querySelector('#' + trixEditor.getAttribute('input')) : null;
    
            if (trixEditor && hiddenInput) {
                const content = hiddenInput.value;
                console.log('Form submitting with content length:', content.length);
                @this.set('content', content, false);
            }
    
            console.log('Form data ready to submit');
        }
    }"
        @submit="submitForm($event)" class="space-y-6">
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
                </div>

                {{-- Content with Trix Editor --}}
                <div class="bg-white rounded-lg shadow-sm p-6"
                    wire:key="trix-editor-{{ $viewMode }}-{{ $articleId }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Konten Artikel <span class="text-red-500">*</span>
                    </label>
                    <div wire:ignore.self x-data="{
                        content: @js($content ?? ''),
                        initTrix() {
                            const editor = this.$el.querySelector('trix-editor');
                            const input = this.$el.querySelector('input[type=hidden]');
                    
                            if (editor && input) {
                                const loadContent = () => {
                                    if (editor.editor && this.content) {
                                        input.value = this.content;
                                        editor.editor.loadHTML(this.content);
                                        console.log('Alpine loaded content:', this.content.substring(0, 100));
                                    }
                                };
                    
                                if (editor.editor) {
                                    loadContent();
                                } else {
                                    editor.addEventListener('trix-initialize', loadContent, { once: true });
                                }
                            }
                        }
                    }" x-init="$nextTick(() => initTrix())">
                        <input id="content-{{ $viewMode }}" type="hidden" name="content">
                        <trix-editor input="content-{{ $viewMode }}"
                            class="trix-content @error('content') border-red-500 @enderror"></trix-editor>
                    </div>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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

@push('scripts')
    <script>
        // Use viewMode as key to track when to reinit
        let lastViewMode = '{{ $viewMode }}';
        let currentArticleId = '{{ $articleId ?? '' }}';

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => initializeTrix(), 200);
        });

        // Re-initialize when switching between create/edit
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', ({
                component
            }) => {
                const newViewMode = component.$wire.viewMode;
                const newArticleId = component.$wire.articleId || '';

                // Reinit if viewMode changed OR articleId changed (switching articles)
                if (newViewMode !== lastViewMode || newArticleId !== currentArticleId) {
                    lastViewMode = newViewMode;
                    currentArticleId = newArticleId;

                    console.log('ViewMode changed to:', newViewMode, 'Article:', newArticleId);
                    setTimeout(() => initializeTrix(), 200);
                }
            });
        });

        function initializeTrix() {
            const trixEditor = document.querySelector('trix-editor');
            const hiddenInput = trixEditor ? document.querySelector('#' + trixEditor.getAttribute(
                'input')) : null;

            if (!trixEditor || !hiddenInput) {
                console.log('Trix editor not found, retrying...');
                return;
            }

            // Wait for trix editor to be ready
            if (!trixEditor.editor) {
                console.log('Trix editor not ready, waiting for initialization...');
                trixEditor.addEventListener('trix-initialize', function() {
                    loadTrixContent(trixEditor, hiddenInput);
                }, {
                    once: true
                });
            } else {
                loadTrixContent(trixEditor, hiddenInput);
            }

            // Sync to Livewire property directly (no re-render)
            let syncing = false;
            const syncToLivewire = function(e) {
                if (syncing) return;
                syncing = true;

                const component = window.Livewire?.find('{{ $this->getId() }}');
                if (component) {
                    component.$wire.content = hiddenInput.value;
                }

                setTimeout(() => syncing = false, 50);
            };

            // Remove old listener and add new one
            trixEditor.removeEventListener('trix-change', syncToLivewire);
            trixEditor.addEventListener('trix-change', syncToLivewire);

            // Prevent file uploads in Trix
            trixEditor.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            });
        }

        function loadTrixContent(trixEditor, hiddenInput) {
            // Get content from Livewire component
            const component = window.Livewire?.find('{{ $this->getId() }}');
            let contentToLoad = '';

            if (component && component.$wire.content) {
                contentToLoad = component.$wire.content;
                console.log('Loading content from Livewire:', contentToLoad.substring(0, 100) + '...');
            } else {
                // Fallback to server-side rendered value
                contentToLoad = {!! json_encode($content ?? '') !!};
                if (contentToLoad) {
                    console.log('Loading content from server:', contentToLoad.substring(0, 100) + '...');
                }
            }

            if (contentToLoad && trixEditor.editor) {
                hiddenInput.value = contentToLoad;
                trixEditor.editor.loadHTML(contentToLoad);
                console.log('✅ Trix content loaded successfully');
            } else {
                console.log('⚠️ No content to load or editor not ready');
            }
        }
    </script>
@endpush
