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

    public $main_image, $published_at;
    public $title = ['id' => '', 'en' => ''];
    public $description = ['id' => '', 'en' => ''];

    public $blog_id;
    public $viewMode = 'list';
    public $uploadKey;

    public $contents = [];

    protected $rules = [
        'title.id' => 'required|string|max:255',
        'title.en' => 'required|string|max:255',
        'description.id' => 'nullable|string',
        'description.en' => 'nullable|string',
        'main_image' => 'nullable|image|max:10240',
        'published_at' => 'nullable|date',

        'contents.*.content.id' => 'nullable|string',
        'contents.*.content.en' => 'nullable|string',
        'contents.*.image' => 'nullable|image|max:10240', // Maks 10MB

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

        foreach ($this->contents as $contentData) {
        $contentPath = $contentData['image'] 
            ? $contentData['image']->store('blog_contents', 'public') 
            : null;

        BlogContent::create([
            'blog_id' => $blog->id,
            'content' => $contentData['content'], // simpan array langsung jika kolom DB json
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
        $this->title = $blog->title ?? ['id' => '', 'en' => ''];
        $this->description = $blog->description ?? ['id' => '', 'en' => ''];
        $this->published_at = $blog->published_at?->format('Y-m-d');
       $this->contents = $blog->contents->map(fn($item) => [
            'id' => $item->id,
            'content' => is_array($item->content) 
                ? $item->content 
                : ['id' => $item->content, 'en' => ''],
            'image' => null, // file baru masih null
            'old_image' => $item->image, // gambar lama untuk preview
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

        foreach ($this->contents as $data) {
            if (isset($data['id'])) {
                $content = BlogContent::find($data['id']);

                if ($data['image']) {
                    // hapus gambar lama jika ada
                    if ($content->image) Storage::disk('public')->delete($content->image);
                    $content->image = $data['image']->store('blog_contents', 'public');
                }

                $content->content = $data['content'];
                $content->save();
            } else {
                // konten baru ditambahkan
                $path = $data['image'] ? $data['image']->store('blog_contents', 'public') : null;
                BlogContent::create([
                    'blog_id' => $blog->id,
                    'content' => $data['content'],
                    'image' => $path,
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
        $this->contents[] = [
            'content' => ['id' => '', 'en' => ''], // konten multi bahasa
            'image' => null, // file baru yang akan diupload
            'old_image' => null, // untuk preview gambar lama kalau edit
            'key' => time().rand(0, 999), 
        ];
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
        $this->title = ['id' => '', 'en' => ''];
        $this->description = ['id' => '', 'en' => ''];
        $this->main_image = null;
        $this->published_at = null;
        $this->contents = [];
        $this->blog_id = null;
        $this->uploadKey = rand();
    }

    public function render()
    {
        return view('livewire.admin.article-crud', [
            'blogs' => Blog::latest()->get()
        ]);
    }
}
