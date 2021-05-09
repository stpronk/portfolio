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
//        Navigation::addItem('Dashboard', 'th', 'home', true, false, 'dashboard', 0);
//
//        Navigation::addItem('Assignments','files-o', null, false, false, 'assignments', 1)
//            ->addSubItem('Dealer', 'car', 'assignment.dealer', false, false, 'assignments', 0)
//            ->addSubItem('Event planner', 'calendar', 'assignment.event-planner', false, false, 'assignments', 1);
//
//        Navigation::addItem('Finance', 'money', 'finance.index', true, false, 'finance', 2);
//
//        /**
//         * ---------- ADMIN ROUTES ----------
//         */
//        Navigation::addItem('Users', 'users', 'users.index', true, true, 'users', 3);
//
//        Navigation::addItem('Site', 'globe', 'site.index', true, true, 'site', 4, ['hide-sub-menu' => true])
//            ->addSubItem('', 'home', 'site.index', true, true, 'site', 0)
//            ->addSubItem('Analytics', 'search', 'site.analytics', true, true, 'site', 1)
//            ->addSubItem('Portfolio', 'briefcase', 'site.portfolio', true, true, 'site', 2);

//        /**
//         * ---------- USER ROUTES ----------
//         */
//        Navigation::addItem('Profile', 'user', null, true, false, 'auth',3)
//            ->addSubItem('Settings', 'cog', 'site.analytics', true, false, 'auth',0);



        // TODO | Desired format:

//        Navigation::group('group_name')                                                           // Select a group that you will add items to
//            ->addItem('title', 'icon', 'route_name', 0)                                           // Add item with the least amount off parameters
//            ->addItem('title', 'icon', 'route_name', 0, ['option' => 'value'])                    // Add item with an options array
//            ->addItem('title', 'icon', 'route_name', 0, null, function ($item) {                  // Use callback to create sub-items
//                $item->addItem('title', 'icon', 'route_name', 0);                                     // Create sub item in the same way as before
//                $item->addItem('title', 'icon', 'route_name', 0, ['option' => 'value']);              // Create sub item in the same way with option
//            })                                                                                        // Can also give another callback to the sub item to create another submenu
//            ->addItem('title', 'icon', 'route_name', 0, ['option' => 'value']);                   // Add items again to the main group



        // TODO | Testing items in desired format:

        Navigation::group('general')
            ->addItem('Dashboard', 'th', 'home', 0)
            ->addItem('Assignments','files-o', null, 1, null, function (Builder $builder) {
                $builder->addItem('Dealer', 'car', 'assignment.dealer', 0)
                        ->addItem('Event planner', 'calendar', 'assignment.event-planner', 1);
            })
            ->addItem('Finance', 'money', 'finance.index', 2);
    }
}
