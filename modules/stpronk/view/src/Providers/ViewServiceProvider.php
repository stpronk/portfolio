<?php

namespace Stpronk\View\Providers;

use Illuminate\Support\ServiceProvider;
use Stpronk\View\Services\Navigation;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        if (file_exists($file = __DIR__.'/../Helpers/Navigation.php')) {
            require $file;
        }

        $this->app->bind('Navigation', Navigation::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
