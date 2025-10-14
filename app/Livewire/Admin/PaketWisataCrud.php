<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PaketWisata;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;


class PaketWisataCrud extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Form fields
    public $price, $max_person, $location, $duration, $category_id, $categories;
    public $main_image;
    public $gallery = [];
    public $title = ['id'=>'','en'=>''];
    public $description = ['id'=>'','en'=>''];
    public $fasilitas = ['id'=>'','en'=>''];



    public $uploadKey;
    public $paket_id; // untuk edit
    public $viewMode = 'list'; // 'list', 'form', 'detail'
    public $selectedCategory = null;


    protected $rules = [
        'title.id' => 'required|string|max:255',
        'title.en' => 'required|string|max:255',
        'description.id' => 'required|string',
        'description.en' => 'required|string',
        'price' => 'required|numeric|min:0',
        'max_person' => 'required|integer|min:1',
        'location' => 'required|string',
        'duration' => 'required|string',
        'category_id' => 'nullable',
        'main_image' => 'nullable|image|max:10240',
        'gallery.*' => 'nullable|image|max:10240',
        'fasilitas.id' => 'nullable', // ✅ string comma-separated
        'fasilitas.en' => 'nullable', // ✅ string comma-separated
    ];


    public function mount()
    {
        $this->uploadKey = rand();
        $this->categories = \App\Models\Category::all(); // ✅ tambahkan ini
    }
    
    public function getFilteredProductsProperty()
    {
        return PaketWisata::when($this->selectedCategory, function($query) {
            $query->where('category_id', $this->selectedCategory);
        })->get();
    }


    public function create()
    {
        $this->resetForm(); // kosongkan field
        $this->viewMode = 'form'; // tampilkan form
    }


    // === CREATE ===


public function store()
{
    $this->validate();

    $mainImagePath = $this->main_image
        ? $this->main_image->store('paket_wisata/main', 'public')
        : null;

    $galleryPaths = [];
    if (!empty($this->gallery)) {
        foreach ($this->gallery as $file) {
            $galleryPaths[] = $file->store('paket_wisata/gallery', 'public');
        }
    }

    // 🧠 normalize fasilitas
    $fasilitas_id = $this->fasilitas['id'] ?? [];
    $fasilitas_en = $this->fasilitas['en'] ?? [];

    PaketWisata::create([
        'title' => $this->title,
        'description' => $this->description,
        'price' => $this->price,
        'max_person' => $this->max_person,
        'location' => $this->location,
        'duration' => $this->duration,
        'category_id' => $this->category_id,
        'main_image' => $mainImagePath,
        'gallery' => $galleryPaths,
        'fasilitas' => [
            'id' => is_array($fasilitas_id)
                ? array_filter(Arr::flatten($fasilitas_id))
                : array_filter(array_map('trim', explode(',', $fasilitas_id))),
            'en' => is_array($fasilitas_en)
                ? array_filter(Arr::flatten($fasilitas_en))
                : array_filter(array_map('trim', explode(',', $fasilitas_en))),
        ],
    ]);

    session()->flash('message', '✅ Paket wisata berhasil ditambahkan.');
    $this->resetForm();
    $this->viewMode = 'list';
}



    // === READ ===
    public function getPaketWisata()
    {
        return PaketWisata::latest()->get();
    }

    // === DETAIL ===
    public function detail($id)
    {
        $this->paket_id = $id;
        $this->viewMode = 'detail';
    }

    // === EDIT ===
    public function edit($id)
    {
        $paket = PaketWisata::findOrFail($id);
        $this->paket_id  = $id;
        $this->title     = $paket->title;
        $this->description = $paket->description;
        $this->price     = $paket->price;
        $this->max_person = $paket->max_person;
        $this->location  = $paket->location;
        $this->duration  = $paket->duration;
        $this->category_id  = $paket->category_id;
        $this->fasilitas = $paket->fasilitas ?? ['id'=>'','en'=>''];
        $this->viewMode = 'form';
    }



    public function update()
{
    $this->validate();

    $paket = PaketWisata::findOrFail($this->paket_id);

    // === Handle main image ===
    if ($this->main_image) {
        if ($paket->main_image) Storage::disk('public')->delete($paket->main_image);
        $paket->main_image = $this->main_image->store('paket_wisata/main', 'public');
    }

    // === Handle gallery ===
    if (!empty($this->gallery)) {
        foreach ($paket->gallery ?? [] as $old) {
            Storage::disk('public')->delete($old);
        }

        $newGallery = [];
        foreach ($this->gallery as $file) {
            $newGallery[] = $file->store('paket_wisata/gallery', 'public');
        }
        $paket->gallery = $newGallery;
    }

    // 🧠 normalize fasilitas
    $fasilitas_id = $this->fasilitas['id'] ?? [];
    $fasilitas_en = $this->fasilitas['en'] ?? [];

    $paket->update([
        'title' => $this->title,
        'description' => $this->description,
        'price' => $this->price,
        'max_person' => $this->max_person,
        'location' => $this->location,
        'duration' => $this->duration,
        'category_id' => $this->category_id,
        'fasilitas' => [
            'id' => is_array($fasilitas_id)
                ? array_filter(Arr::flatten($fasilitas_id))
                : array_filter(array_map('trim', explode(',', $fasilitas_id))),
            'en' => is_array($fasilitas_en)
                ? array_filter(Arr::flatten($fasilitas_en))
                : array_filter(array_map('trim', explode(',', $fasilitas_en))),
        ],
    ]);

    session()->flash('message', '✅ Paket wisata berhasil diperbarui.');
    $this->resetForm();
    $this->viewMode = 'list';
}


    // === DELETE ===
    public function delete($id)
    {
        $paket = PaketWisata::findOrFail($id);

        // Hapus gambar utama jika ada
        if ($paket->main_image && Storage::disk('public')->exists($paket->main_image)) {
            Storage::disk('public')->delete($paket->main_image);
        }

        // Hapus semua gambar gallery jika ada
        if (is_array($paket->gallery)) {
            foreach ($paket->gallery as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }
        }

        // Hapus data dari database
        $paket->delete();
        $this->resetForm();
        $this->viewMode = 'list';
        session()->flash('message', '🗑️ Paket wisata dan semua gambar berhasil dihapus.');
    }


    // === RESET FORM ===
    public function resetForm()
{
    $this->title = ['id' => '', 'en' => ''];
    $this->description = ['id' => '', 'en' => ''];
    $this->fasilitas = ['id' => '', 'en' => ''];

    $this->price = null;
    $this->max_person = null;
    $this->location = null;
    $this->duration = null;
    $this->category_id = null;
    $this->main_image = null;
    $this->gallery = [];
    $this->paket_id = null;

    $this->uploadKey = rand();
    $this->resetValidation();
    $this->dispatch('reset-file-inputs');
}


    public function render()
    {
        return view('livewire.admin.paket-wisata-crud', [
            'paketList' => $this->filteredProducts, // pakai filteredProducts
            'selectedPaket' => $this->paket_id ? PaketWisata::find($this->paket_id) : null,
        ]);
    }
}
