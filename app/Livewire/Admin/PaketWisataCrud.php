<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PaketWisata;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

class PaketWisataCrud extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Form fields
    public $title, $description, $price, $max_person, $location, $duration, $category;
    public $main_image;
    public $gallery = [];
    public $fasilitas = '';

    public $uploadKey;
    public $paket_id; // untuk edit
    public $viewMode = 'list'; // 'list', 'form', 'detail'

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'max_person' => 'required|integer|min:1',
        'location' => 'required|string',
        'duration' => 'required|string',
        'category' => 'nullable|string',
        'main_image' => 'nullable|image|max:10240', // maks 10MB
        'gallery.*' => 'nullable|image|max:10240', // maks 10MB per fi
    ];

    public function mount()
    {
        $this->uploadKey = rand();
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

        $fasilitasArray = array_filter(array_map('trim', explode(',', $this->fasilitas)));

        PaketWisata::create([
            'title'       => $this->title,
            'description' => $this->description,
            'price'       => $this->price,
            'max_person'  => $this->max_person,
            'location'    => $this->location,
            'duration'    => $this->duration,
            'category'    => $this->category,
            'main_image'  => $mainImagePath,
            'gallery'     => $galleryPaths,
            'fasilitas'   => $fasilitasArray,
        ]);

        session()->flash('message', '✅ Paket wisata berhasil ditambahkan.');
        $this->resetForm();
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
        $this->category  = $paket->category;
        $this->fasilitas = implode(',', $paket->fasilitas ?? []);
        $this->viewMode = 'form';
    }

    public function update()
    {
        $this->validate();

        $paket = PaketWisata::findOrFail($this->paket_id);

        if ($this->main_image) {
            if ($paket->main_image) Storage::disk('public')->delete($paket->main_image);
            $paket->main_image = $this->main_image->store('paket_wisata/main', 'public');
        }

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

        $paket->update([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'max_person' => $this->max_person,
            'location' => $this->location,
            'duration' => $this->duration,
            'category' => $this->category,
            'fasilitas' => array_filter(array_map('trim', explode(',', $this->fasilitas))),
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
        $this->reset([
            'title', 'description', 'price', 'max_person', 'location',
            'duration', 'category', 'main_image', 'gallery', 'fasilitas', 'paket_id'
        ]);
        $this->uploadKey = rand();
        $this->resetValidation();
        $this->dispatch('reset-file-inputs');
    }

    public function render()
    {
        return view('livewire.admin.paket-wisata-crud', [
            'paketList' => $this->getPaketWisata(),
            'selectedPaket' => $this->paket_id ? PaketWisata::find($this->paket_id) : null
        ]);
    }
}
