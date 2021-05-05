<?php

namespace App\Providers;

use App\Services\Finance;
use Illuminate\Support\ServiceProvider;
use Stpronk\View\Facades\Navigation;

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
     */
    public function bootNavigation()
    {
        Navigation::addItem('Dashboard', 'th', 'home', true, false, 'dashboard', 0);

        Navigation::addItem('Assignments','files-o', null, false, false, 'assignments', 1)
            ->addSubItem('Dealer', 'car', 'assignment.dealer', false, false, 'assignments', 0)
            ->addSubItem('Event planner', 'calendar', 'assignment.event-planner', false, false, 'assignments', 1);

        Navigation::addItem('Finance', 'money', 'finance.index', true, false, 'finance', 2);

        /**
         * ---------- ADMIN ROUTES ----------
         */
        Navigation::addItem('Users', 'users', 'users.index', true, true, 'users', 3);

        Navigation::addItem('Site', 'globe', 'site.index', true, true, 'site', 4, ['hide-sub-menu' => true])
            ->addSubItem('', 'home', 'site.index', true, true, 'site', 0)
            ->addSubItem('Analytics', 'search', 'site.analytics', true, true, 'site', 1)
            ->addSubItem('Portfolio', 'briefcase', 'site.portfolio', true, true, 'site', 2);

    }
}
