<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\Paketwisata;
use App\Livewire\PaketDetail;
use App\Livewire\Article;
use App\Livewire\ExplorePupuan;
use App\Livewire\ArticleDetail;
use App\Livewire\Admin\PaketWisataCrud;
use App\Livewire\Admin\ArticleCrud;
use App\Livewire\Admin\Category;


Route::get('/', Home::class);
Route::get('/about', About::class);
Route::get('/contact', Contact::class);
Route::get('/paket-wisata', Paketwisata::class);
Route::get('/paket/{slug}', PaketDetail::class)->name('paket.detail');
Route::get('/explore-pupuan', ExplorePupuan::class);
Route::get('/article', Article::class);
Route::get('/article/{slug}', ArticleDetail::class)->name('article.detail');
Route::get('/admin/paket-wisata', PaketWisataCrud::class)->name('admin.paket-wisata');
Route::get('/admin/article', ArticleCrud::class)->name('admin.article');
Route::get('/admin/category', Category::class)->name('admin.category');
