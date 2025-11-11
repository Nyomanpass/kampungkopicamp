<div class="p-6">

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button @click="show = false" class="text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif


    @if ($viewMode === 'list')
        @include('livewire.admin.articles.list')
    @else
        @include('livewire.admin.articles.form')
    @endif

    {{-- Trix Editor Script --}}
    @script
        <script>
            // Trix editor event listener untuk auto-save ke Livewire
            document.addEventListener('trix-change', function(event) {
                @this.set('content', event.target.value);
            });

            // Prevent file attachments untuk sementara
            document.addEventListener('trix-file-accept', function(event) {
                event.preventDefault();
                alert('Upload file melalui featured image. Untuk gambar dalam konten, gunakan URL gambar.');
            });

            // Load content when form is shown (using Livewire hook)
            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                // Check if trix editor exists and load content
                const editor = document.querySelector('trix-editor');
                if (editor && editor.editor) {
                    const currentContent = editor.editor.getDocument().toString();
                    const newContent = @this.get('content') || '';

                    // Only update if content is different to avoid cursor jump
                    if (currentContent !== newContent) {
                        editor.editor.loadHTML(newContent);
                    }
                }
            });
        </script>
    @endscript
</div>
</div>
