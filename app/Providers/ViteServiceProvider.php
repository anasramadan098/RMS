<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Vite;

class ViteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // تعطيل Vite وإرجاع محتوى فارغ
        Vite::macro('useBuildDirectory', function ($directory) {
            return $this;
        });

        // إرجاع محتوى فارغ عند استدعاء Vite
        Vite::macro('__invoke', function ($entrypoints = [], $buildDirectory = null) {
            return '';
        });
    }
}
