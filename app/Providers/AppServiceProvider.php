<?php

namespace App\Providers;

use App\Services\Finance;
use Illuminate\Support\ServiceProvider;
use Stpronk\View\Facades\Navigation;
use Stpronk\View\Services\Navigation\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Exception
     */
    public function boot()
    {
        $this->bootNavigation();

        // TODO: Find out if this bind can be removed
        $this->app->bind('Finance', Finance::class);
    }

    /**
     * Import all navigation items
     *
     * @return void
     * @throws \Exception
     */
    public function bootNavigation()
    {
        /**
         * ---------- GENERAL MENU ----------
         */
        Navigation::group('general')
            ->addItem('Dashboard', 'th', 'home', 0)
            ->addItem('Assignments','files-o', null, 1, function (Builder $b) {
               $b->addItem('Dealer', 'car', 'assignment.dealer', 0)
                 ->addItem('Event planner', 'calendar', 'assignment.event-planner', 1);
            })
            ->addItem('Finance', 'money', 'finance.index', 2);


        /**
         * ---------- ADMIN MENU ----------
         */
        Navigation::group('admin')
            ->addItem('Users', 'users', 'users.index', 3)
            ->addItem('Site', 'globe', 'site.index', 4, function (Builder $b) {
               $b->addItem('', 'home', 'site.index', 0)
                 ->addItem('Analytics', 'search', 'site.analytics', 1)
                 ->addItem('Portfolio', 'briefcase', 'site.portfolio', 2);
            }, ['hide-sub-menu' => true]);

        /**
         * ---------- USER MENU ----------
         *
         * This menu will already be under an submenu
         */
        Navigation::group('user')
            ->addItem('Profile', 'user', null, 0)
            ->addItem('Settings', 'cog', null, 1);
    }
}
