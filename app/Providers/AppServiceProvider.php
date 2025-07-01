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
        // Solução para o erro do Prettus/L5-Repository no Laravel 9+
        $this->app->singleton('composer', function () {
            return new class {
                public function dumpAutoloads() {}
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
    
}
