<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App; // Pastikan ini diimpor
use Illuminate\Support\Facades\Session; // Pastikan ini diimpor

class LanguageSwitcher extends Component
{
    // Properti publik untuk menyimpan bahasa yang sedang aktif
    public $lang;
    public $open = false; // Untuk toggle dropdown



    // Fungsi yang dijalankan saat komponen dimuat
    public function mount()
    {
        // 1. Baca bahasa dari Session, default ke 'id' (Indonesia)
        $this->lang = Session::get('locale', 'id');
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }


    // Fungsi yang dijalankan saat tombol bahasa diklik
    public function setLang($lang)
    {
        // 2. KRUSIAL: Simpan bahasa baru ke Session
        Session::put('locale', $lang);

        // 3. Set bahasa Laravel secara instan (untuk permintaan saat ini)
        App::setLocale($lang);

        // 4. Update properti lokal dan reload (agar halaman me-render ulang dengan bahasa baru)
        $this->lang = $lang;
        $this->open = false; // otomatis tutup dropdown
        
        // Opsional: Jika Anda ingin seluruh halaman me-reload penuh (lebih aman)
        return redirect(request()->header('Referer')); 
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
