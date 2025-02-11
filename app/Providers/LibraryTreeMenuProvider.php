<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LibraryTreeMenuProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind('TreeMenu', App\Providers\LibraryTreeMenuProvider::class);
        require_once app_path() . '/Lib/TreeMenu.php';
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
