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
        Navigation::addItem('Dashboard', 'th', 'home', true, false, 0);

        Navigation::addItem('Assignments','files-o', 'assignments', false, false, 1)
            ->addSubItem('Dealer', 'car', 'assignment.dealer', false, false, 0)
            ->addSubItem('Event planner', 'calendar', 'assignment.event-planner', false, false, 1);

        Navigation::addItem('Finance', 'money', 'finance.index', true, false, 2);

        /**
         * ---------- ADMIN ROUTES ----------
         */
        Navigation::addItem('Users', 'users', 'users.index', true, true, 3);

        Navigation::addItem('Site', 'globe', 'site.index', true, true, 4, null,['hide-sub-menu' => true])
            ->addSubItem('', 'home', 'site.index', true, true, 0)
            ->addSubItem('Analytics', 'search', 'site.analytics', true, true, 1)
            ->addSubItem('Portfolio', 'briefcase', 'site.portfolio', true, true, 2);

    }
}
