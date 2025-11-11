<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class Articles extends Component
{
    use WithPagination, WithFileUploads;

    // ===== VIEW MODES =====
    public $viewMode = 'list'; // list, create, edit

    public $isEditing = false;

    // ===== FORM FIELDS =====
    public $articleId;
    public $title;
    public $slug;
    public $excerpt;
    public $content;
    public $featured_image;
    public $new_featured_image;
    public $category = 'tips';
    public $status = 'draft';
    public $is_featured = false;
    public $published_at;
    public $meta_description;

    // ===== FILTERS & SEARCH =====
    public $search = '';
    public $filterCategory = '';
    public $filterStatus = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $this->articleId,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'new_featured_image' => 'nullable|image|max:2048',
            'category' => 'required|in:tips,destinasi,kuliner,budaya',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_description' => 'nullable|string|max:160',
        ];
    }

    public function updatedTitle($value)
    {
        if ($this->viewMode === 'create') {
            $this->slug = Str::slug($value);
        }
        $this->skipRender();
    }

    public function updatingContent($value)
    {
        // Prevent re-render when content is being updated
        $this->skipRender();
    }

    public function updatedContent($value)
    {
        // Prevent re-render after content is updated
        $this->skipRender();
    }

    // ===== VIEW SWITCHING =====
    public function switchToList()
    {
        $this->viewMode = 'list';
        $this->resetForm();
        $this->resetPage();
    }

    public function switchToCreate()
    {
        $this->resetForm();
        $this->viewMode = 'create';
    }

    public function switchToEdit($id)
    {
        $this->resetForm();
        $article = Article::findOrFail($id);

        $this->articleId = $article->id;
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->excerpt = $article->excerpt;
        $this->content = $article->content;
        $this->featured_image = $article->featured_image;
        $this->category = $article->category;
        $this->status = $article->status;
        $this->is_featured = $article->is_featured;
        $this->published_at = $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : null;
        $this->meta_description = $article->meta_description;

        $this->viewMode = 'edit';
    }

    private function resetForm()
    {
        $this->reset([
            'articleId',
            'title',
            'slug',
            'excerpt',
            'content',
            'featured_image',
            'new_featured_image',
            'category',
            'status',
            'is_featured',
            'published_at',
            'meta_description',
        ]);
        $this->category = 'tips';
        $this->status = 'draft';
        $this->is_featured = false;
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);

        // Delete featured image
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();
        session()->flash('success', 'Artikel berhasil dihapus!');
    }

    public function toggleFeatured($id)
    {
        $article = Article::findOrFail($id);
        $article->update(['is_featured' => !$article->is_featured]);
        session()->flash('success', 'Status featured berhasil diubah!');
    }

    public function toggleStatus($id)
    {
        $article = Article::findOrFail($id);
        $newStatus = $article->status === 'published' ? 'draft' : 'published';

        $article->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? now() : null
        ]);

        session()->flash('success', 'Status artikel berhasil diubah!');
    }

    // ===== CRUD OPERATIONS =====
    public function createArticle()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'excerpt' => $this->excerpt,
                'content' => $this->content,
                'category' => $this->category,
                'status' => $this->status,
                'is_featured' => $this->is_featured,
                'meta_description' => $this->meta_description,
                'author_id' => auth()->id(),
            ];

            // Handle published_at
            if ($this->status === 'published') {
                $data['published_at'] = $this->published_at ?: now();
            }

            // Handle featured image upload
            if ($this->new_featured_image) {
                $path = $this->new_featured_image->store('articles', 'public');
                $data['featured_image'] = $path;
            }

            Article::create($data);

            DB::commit();

            session()->flash('message', 'Artikel berhasil dibuat!');
            $this->switchToList();
        } catch (\Exception $e) {
            DB::rollBack();

            // If an image was stored before the error, delete it
            if (!empty($data['featured_image'] ?? null)) {
                Storage::disk('public')->delete($data['featured_image']);
            }

            Log::error('Create article failed: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat artikel. Silakan coba lagi.');
        }
    }

    public function updateArticle()
    {
        Log::info('updateArticle method called', [
            'articleId' => $this->articleId,
            'title' => $this->title,
            'content_length' => strlen($this->content ?? '')
        ]);

        $this->validate();

        $data = [];

        try {
            DB::beginTransaction();

            $article = Article::findOrFail($this->articleId);

            // Prepare data array
            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'excerpt' => $this->excerpt,
                'content' => $this->content,
                'category' => $this->category,
                'status' => $this->status,
                'is_featured' => $this->is_featured,
                'meta_description' => $this->meta_description,
            ];

            // Handle published_at
            if ($this->status === 'published') {
                $data['published_at'] = $this->published_at ?: now();
            } else {
                $data['published_at'] = null;
            }

            // Handle featured image upload
            if ($this->new_featured_image) {
                $path = $this->new_featured_image->store('articles', 'public');
                $data['featured_image'] = $path;

                // Delete old image
                if ($article->featured_image) {
                    Storage::disk('public')->delete($article->featured_image);
                }
            }

            Log::info('Updating article with data', $data);

            // Update article
            $article->update($data);

            DB::commit();

            Log::info('Article updated successfully');

            session()->flash('message', 'Artikel berhasil diperbarui!');
            $this->switchToList();
        } catch (\Exception $e) {
            DB::rollBack();

            // If an image was stored before the error, delete it
            if (!empty($data['featured_image'] ?? null)) {
                Storage::disk('public')->delete($data['featured_image']);
            }

            Log::error('Update article failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Terjadi kesalahan saat memperbarui artikel. Silakan coba lagi.');
        }
    }

    #[Layout('layouts.admin')]

    public function render()
    {
        $query = Article::with('author');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $articles = $query->latest()->paginate(10);

        return view('livewire.admin.articles', [
            'articles' => $articles
        ]);
    }
}
