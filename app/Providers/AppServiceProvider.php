<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Force HTTPS jika APP_URL menggunakan https
        if (config('app.url') && str_starts_with(config('app.url'), 'https://')) {
            \URL::forceScheme('https');
        }
    }
}
