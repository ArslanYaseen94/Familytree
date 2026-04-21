<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LanguageService;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LanguageService::class, function ($app) {
            return new LanguageService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
