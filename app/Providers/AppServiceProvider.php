<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Jangan pakai session di sini, cukup default
        app()->setLocale(config('app.locale'));

        Blade::directive('rupiah', function ($expression) {
            return "<?php echo formatRupiah($expression); ?>";
        });

        // Register Blade directive for formatDate
        Blade::directive('date', function ($expression) {
            return "<?php echo formatDate($expression); ?>";
        });

        //
        // if (config('app.debug')) {
        //     Carbon::setTestNow(Carbon::now()->addDays(2));
        // }
    }
}
