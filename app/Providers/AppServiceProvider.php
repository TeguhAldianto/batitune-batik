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
        // // Define signal constants for Windows
        // if (!defined('SIGINT')) {
        //     define('SIGINT', 2);
        //     define('SIGTERM', 15);
        //     define('SIGHUP', 1);
        }
    }

