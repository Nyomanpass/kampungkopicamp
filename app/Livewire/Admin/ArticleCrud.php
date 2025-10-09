<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blog;
use App\Models\BlogContent;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

class ArticleCrud extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Field utama blog
    public $title, $description, $main_image, $published_at;
    public $blog_id;
    public $viewMode = 'list';
    public $uploadKey;

    // Field konten tambahan
    public $contents = []; // array berisi isi konten (content + image)

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'main_image' => 'nullable|image|max:10240',
        'published_at' => 'nullable|date',
    ];

    public function mount()
    {
        $this->uploadKey = rand();
    }

    public function create()
    {
        $this->resetForm();
        $this->viewMode = 'form';
    }

    public function store()
    {
        $this->validate();

        $imagePath = $this->main_image
            ? $this->main_image->store('blogs', 'public')
            : null;

        $blog = Blog::create([
            'title' => $this->title,
            'description' => $this->description,
            'main_image' => $imagePath,
            'published_at' => $this->published_at,
        ]);

        // Simpan isi konten tambahan (jika ada)
        foreach ($this->contents as $contentData) {
            $contentPath = isset($contentData['image'])
                ? $contentData['image']->store('blog_contents', 'public')
                : null;

            BlogContent::create([
                'blog_id' => $blog->id,
                'content' => $contentData['content'] ?? '',
                'image' => $contentPath,
            ]);
        }

        session()->flash('message', '✅ Artikel berhasil ditambahkan.');
        $this->resetForm();
        $this->viewMode = 'list';
    }

    public function edit($id)
    {
        $blog = Blog::with('contents')->findOrFail($id);

        $this->blog_id = $blog->id;
        $this->title = $blog->title;
        $this->description = $blog->description;
        $this->published_at = $blog->published_at?->format('Y-m-d');
        $this->contents = $blog->contents->map(fn($item) => [
            'id' => $item->id,
            'content' => $item->content,
            'image' => null, // upload baru jika perlu
        ])->toArray();

        $this->viewMode = 'form';
    }

    public function update()
    {
        $this->validate();

        $blog = Blog::findOrFail($this->blog_id);

        if ($this->main_image) {
            if ($blog->main_image) Storage::disk('public')->delete($blog->main_image);
            $blog->main_image = $this->main_image->store('blogs', 'public');
        }

        $blog->update([
            'title' => $this->title,
            'description' => $this->description,
            'published_at' => $this->published_at,
        ]);

        // Update konten tambahan
        foreach ($this->contents as $data) {
            if (isset($data['id'])) {
                $content = BlogContent::find($data['id']);
                if ($data['image']) {
                    if ($content->image) Storage::disk('public')->delete($content->image);
                    $content->image = $data['image']->store('blog_contents', 'public');
                }
                $content->content = $data['content'];
                $content->save();
            } else {
                BlogContent::create([
                    'blog_id' => $blog->id,
                    'content' => $data['content'] ?? '',
                    'image' => $data['image'] ? $data['image']->store('blog_contents', 'public') : null,
                ]);
            }
        }

        session()->flash('message', '✅ Artikel berhasil diperbarui.');
        $this->resetForm();
        $this->viewMode = 'list';
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->main_image && Storage::disk('public')->exists($blog->main_image)) {
            Storage::disk('public')->delete($blog->main_image);
        }

        $blog->delete();
        session()->flash('message', '🗑️ Artikel berhasil dihapus.');
    }

    public function addContentBlock()
    {
        $this->contents[] = ['content' => '', 'image' => null];
    }

    public function removeContentBlock($index)
    {

        if (isset($this->contents[$index]['id'])) {
            $content = BlogContent::find($this->contents[$index]['id']);

            if ($content) {
                
                if ($content->image && Storage::disk('public')->exists($content->image)) {
                    Storage::disk('public')->delete($content->image);
                }

                
                $content->delete();
            }
        }

       
        unset($this->contents[$index]);

     
        $this->contents = array_values($this->contents);
    }


    public function resetForm()
    {
        $this->reset([
            'title', 'description', 'main_image', 'published_at', 'contents', 'blog_id'
        ]);
        $this->uploadKey = rand();
    }

    public function render()
    {
        return view('livewire.admin.article-crud', [
            'blogs' => Blog::latest()->get()
        ]);
    }
}
