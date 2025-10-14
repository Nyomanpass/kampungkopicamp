<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use Livewire\Attributes\Layout;

class Category extends Component
{
    public $name = ['id'=>'','en'=>''];
    public $categoryId; // untuk edit
    public $categories;
    public $resetKey = 0;
    public $lang;



    #[Layout('layouts.admin')]
    public function render()
    {
        $this->categories = CategoryModel::all();
        return view('livewire.admin.category');
    }

        protected $listeners = [
            'languageChanged' => 'updateLang'
        ];

        public function mount()
        {
            $this->lang = session('locale', 'id'); // default bahasa
        }

        public function updateLang($payload)
        {
            $this->lang = $payload['lang'] ?? 'id';
        }



    public function save()
    {
        $this->validate([
            'name.id' => 'required|min:3',
            'name.en' => 'required|min:3',
        ]);

        if ($this->categoryId) {
            CategoryModel::where('id', $this->categoryId)->update([
                'name' => $this->name
            ]);
            session()->flash('message', 'Kategori berhasil diperbarui!');
        } else {
            CategoryModel::create(['name' => $this->name]);
            session()->flash('message', 'Kategori berhasil ditambahkan!');
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $category = CategoryModel::findOrFail($id);
        $this->name = $category->name;
        $this->categoryId = $category->id;
    }

    public function delete($id)
    {
        CategoryModel::destroy($id);
        session()->flash('message', 'Kategori berhasil dihapus!');

        if ($this->categoryId == $id) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->name = ['id'=>'','en'=>''];
        $this->categoryId = null;
        $this->resetKey++;
    }
}
