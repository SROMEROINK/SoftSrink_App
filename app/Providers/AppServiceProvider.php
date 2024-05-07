<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

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
        Schema::defaultStringLength(191); // for MySQL < 5.7
        VerifyCsrfToken::except([
            'registro_de_fabricacion/carga'
        ]);
    }

    }

