<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use Livewire\Attributes\Layout;

class Category extends Component
{
    public $name;
    public $categoryId; // Untuk edit
    public $categories;
    public $resetKey = 0;


    #[Layout('layouts.admin')]
    public function render()
    {
        $this->categories = CategoryModel::all();
        return view('livewire.admin.category');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3'
        ]);

        if ($this->categoryId) {
            CategoryModel::where('id', $this->categoryId)->update(['name' => $this->name]);
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

        // Kalau sedang dalam mode edit kategori yang dihapus, reset form
        if ($this->categoryId == $id) {
            $this->resetForm();
        }
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'categoryId']);
        $this->resetKey++; // Paksa re-render field input
    }

}
