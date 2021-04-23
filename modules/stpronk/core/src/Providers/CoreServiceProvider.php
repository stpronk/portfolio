<?php

namespace Stpronk\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Stpronk\Core\Commands\InstallCommand;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            InstallCommand::class
        ]);
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
