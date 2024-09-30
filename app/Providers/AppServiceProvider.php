<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twig\Loader\FilesystemLoader;

class AppServiceProvider extends ServiceProvider {
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
    public function boot(): void {
        $loader = new FilesystemLoader();
        $loader->addPath( base_path() . '/resources/views/Layouts', 'Layouts' );
        $loader->addPath( base_path() . '/resources/views/Components', 'Components' );
        
        \Twig::getLoader()->addLoader( $loader );
    }
}
