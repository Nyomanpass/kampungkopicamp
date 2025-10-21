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
use App\Livewire\Login;
use App\Livewire\Register;

use App\Livewire\PackageDetail;
use App\Livewire\BookingFlow;

use App\Http\Controllers\InvoiceController;

use App\Http\Controllers\PaymentController;


Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/paket-wisata', Paketwisata::class)->name('paket-wisata');
Route::get('/paket/{slug}', PaketDetail::class)->name('paket.detail');
Route::get('/explore-pupuan', ExplorePupuan::class)->name('explore-pupuan');
Route::get('/article', Article::class)->name('article');
Route::get('/article/{slug}', ArticleDetail::class)->name('article.detail');


Route::get('/package/{slug}', PackageDetail::class)->name('package.detail');
Route::get('/booking/{slug}', BookingFlow::class)->name('booking.flow');

// payment routes
Route::get('/payment/{token}', [PaymentController::class, 'show'])->name('payment.show');
Route::get('/booking/{token}/finish', [PaymentController::class, 'finish'])->name('booking.finish');

// Webhook route (exclude from CSRF, web middleware)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

//invoice routes
Route::get('/invoice/{invoice}/download', [InvoiceController::class, 'download'])->name('invoice.download');
Route::get('/invoice/{invoice}/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');


Route::middleware('guest')->group(function () {
      Route::get('/login', action: Login::class)->name('login');
      Route::get('/register', action: Register::class)->name('register');
});


// ========== AUTH ROUTES (For logged-in users) ==========
Route::middleware('auth')->group(function () {
      Route::get('/logout', [Login::class, 'logout'])->name('logout');
});


// ========== ADMIN ROUTES (Only for admin role) ==========
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
      Route::get('/package', PaketWisataCrud::class)->name('admin.paket-wisata');
      Route::get('/article', ArticleCrud::class)->name('admin.article');
});
