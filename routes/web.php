<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\Paketwisata;
use App\Livewire\PaketDetail;
use App\Livewire\Article;
use App\Livewire\ExplorePupuan;
use App\Livewire\ExplorePupuan\Detail;

use App\Livewire\ArticleDetail;
use App\Livewire\Admin\PaketWisataCrud;
use App\Livewire\Admin\ArticleCrud;
use App\Livewire\Admin\Category;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\ForgotPassword;
use App\Livewire\ResetPassword;
use App\Livewire\Package;

use App\Livewire\PackageDetail;
use App\Livewire\BookingFlow;

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Bookings;
use App\Livewire\Admin\Payments;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Articles;
use App\Livewire\Admin\Reports;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Vouchers;
use App\Livewire\Admin\Availabilities;


use App\Http\Controllers\InvoiceController;

use App\Http\Controllers\PaymentController;


Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/explore-pupuan', ExplorePupuan::class)->name('explore-pupuan');
Route::get('/explore-pupuan/{slug}', Detail::class)->name('explore-pupuan.detail');

Route::get('/article', \App\Livewire\Blog::class)->name('article');
Route::get('/article/{slug}', \App\Livewire\DetailBlog::class)->name('article.detail');

Route::get('/package', Package::class)->name('package.product');
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
      Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
      Route::get('/password/reset/{token}', ResetPassword::class)->name('password.reset');
});


// ========== AUTH ROUTES (For logged-in users) ==========
Route::middleware('auth')->group(function () {});


Route::middleware(['auth'])->group(function () {
      // ========== ADMIN ROUTES (Only for admin role) ==========
      Route::middleware(['role:admin'])->prefix('admin')->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
            Route::get('/bookings', Bookings::class)->name('admin.bookings');
            Route::get('/addons', \App\Livewire\Admin\Addons::class)->name('admin.addons');
            Route::get('/payments', Payments::class)->name('admin.payments');
            Route::get('/products', Products::class)->name('admin.products');
            Route::get('/articles', Articles::class)->name('admin.articles');
            Route::get('/profile', \App\Livewire\Admin\ProfileSettings::class)->name('admin.profile');
            Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('admin.settings');

            Route::get('/users', Users::class)->name('admin.users');
            Route::get('/vouchers', Vouchers::class)->name('admin.vouchers');
            Route::get('/availability', Availabilities::class)
                  ->middleware(['auth'])
                  ->name('admin.availability');

            Route::prefix('reports')->group(function () {
                  Route::get('/overview', \App\Livewire\Admin\Reports\Overview::class)->name('admin.reports.overview');
                  Route::get('/revenue', \App\Livewire\Admin\Reports\Revenue::class)->name('admin.reports.revenue');
                  Route::get('/bookings', \App\Livewire\Admin\Reports\Bookings::class)->name('admin.reports.bookings');
                  Route::get('/customers', \App\Livewire\Admin\Reports\Customers::class)->name('admin.reports.customers');
                  Route::get('/financial', \App\Livewire\Admin\Reports\Financial::class)->name('admin.reports.financial');
            });
      });

      Route::middleware(['role:user'])->group(function () {
            Route::get('/dashboard', \App\Livewire\User\Dashboard::class)->name('user.dashboard');
            Route::get('/bookings', \App\Livewire\User\MyBooking::class)->name('user.bookings');
            Route::get('/rewards', \App\Livewire\User\Rewards::class)->name('user.rewards');
            Route::get('/account', \App\Livewire\User\Account::class)->name('user.account');
      });


      // Logout route
      Route::get('/logout', [Login::class, 'logout'])->name('logout');
});
