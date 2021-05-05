<?php

namespace Stpronk\View\Providers;

use Illuminate\Support\ServiceProvider;
use Stpronk\View\Services\Navigation;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * ------------ REGISTER ------------
     */

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacades();
    }

    /**
     * Register facades within the package
     */
    protected function registerFacades() {
        if (file_exists($file = __DIR__.'/../Helpers/Navigation.php')) {
            require $file;
        }

        $this->app->singleton('Navigation', Navigation::class);
    }

    /**
     * ------------ BOOT ------------
     */

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->loadConfigs();
    }

    /**
     * Load views from the package
     */
    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'view');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/view')
        ], 'stpronk:resources');
    }

    /**
     * Load configs from the package
     */
    protected function loadConfigs ()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/navigation.php', 'view.navigation');

        $this->publishes([
            __DIR__.'/../config/navigation.php' => config_path('stpronk/view/navigation.php')
        ], 'stpronk:config');
    }
}
