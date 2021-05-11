<?php

Namespace Stpronk\View\Services\Navigation;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class Compiler
{

    /**
     * @var array
     */
    protected $groups;

    /**
     * @var \Stpronk\View\Services\Navigation\Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * @var array
     */
    protected $options;

    /**
     * Builder constructor.
     *
     * @param \Stpronk\View\Services\Navigation\Builder $builder
     * @param array                                     $options
     *
     * @throws \Exception
     */
    public function __construct(Builder $builder, array $options)
    {
        // Set all values to the right variables
        $this->builder = $builder;
        $this->options = $options;

        // Get all items from the group that os specified
        $this->items = $this->getItemsFromBuilder($builder);

        // Setup some additional variables
        $this->setFilters();

        // Validate the values before passing constructor
        $this->validateValues();
    }

    /**
     * Validate the given values
     *
     * @throws \Exception
     * @return void
     */
    protected function validateValues() : void
    {
        // Search for the given filters and see if they exists within the system
        // If they don't exists then we will give back an error message with the
        // name of the filter they are trying to pass through
        if(isset($this->options['filters'])) {
            collect($this->options['filters'])->map(function ($value, $key) {
                if (is_array($value) && !isset($this->filters[$key])) {
                    Throw new Exception("The given filter does not exists in our system: \"{$key}\"", 500);
                }

                if (!is_array($value) && !isset($this->filters[$value])) {
                    Throw new Exception("The given filter does not exists in our system: \"{$value}\"", 500);
                }
            });
        }
    }

    /**
     * set filters that can be used for compiling
     *
     * @return array
     */
    protected function setFilters() : array
    {
        return $this->filters = config('view.navigation.filters');
    }

    /**
     * Get items from the builder that is passed through
     * -- Sub menu included --
     *
     * @param \Stpronk\View\Services\Navigation\Builder $builder
     *
     * @return array
     */
    protected function getItemsFromBuilder(Builder $builder) : array
    {
        return collect($builder->items)->mapWithKeys(function ($item, $key) {
            if( $item->subMenu ) {
                $item->subMenu = $this->getItemsFromBuilder($item->subMenu);
            }

            return [$key => $item];
        })->toArray();
    }


    /**
     * *************** COMPILE FUNCTIONALITIES ***************
     */

    /**
     * Compile the given values to the right format to be used by the blade
     *
     * @return array
     */
    public function compile() : array
    {
        // Execute the filters that are given from the front-end
        if (!isset($this->options['ignore_filters'])) {
            $this->filter();
        }

        if (!isset($this->options['ignore_middleware'])) {
            $this->middleware();
        }

        // Clean up the items and return these to be used in the blade
        return $this->cleanup($this->items);
    }

    /**
     * Execute the filters if any are given
     *
     * @return array
     */
    protected function filter () : array
    {
        if( isset($this->options['filters'])) {
            collect($this->options['filters'])->map(function ($value, $key) {
                if (is_array($value) && ! isset($this->filters[$key])) {
                    return $this->items = (new $this->filters[$key]($value))->loopFilter($this->items);
                }

                return $this->items = (new $this->filters[$value]([]))->loopFilter($this->items);
            });
        }

        return $this->items;
    }

    /**
     * find out if middleware passes on routes and such see which items need to be removed
     * -- Middleware that needs to be checked needs to be specified within the config file
     *
     * @return array
     */
    protected function middleware () : array
    {
        // Loop through the middleware which are specified in the config in order to find out which middleware passes
        $this->middleware = collect(config('view.navigation.middleware-filters'))->mapWithKeys(function($class, $name) : array {
            try {
                // Try to access the middleware and see if it passes
                // When it doesn't pass, it will return something so making that the opposite will return false.
                // When passing, it will access the callback and will in return return false which makes it true in the end.
                $result = !app($class)->handle(request(), function () { return false; });

            } catch (\Exception $e) {
                // When an exceptions pops up, we will catch this and this means the middleware has failed.
                // When it fails, we will simply set the result to false
                $result = false;
            }

            // Return de name of the middleware with the given result
            return [$name => $result];
        })->toArray();

        // Loop through the items to filter the items based on the results of the middleware
        return $this->items = $this->filterByMiddleware($this->items);
    }

    /**
     * Filter the items based on the middleware
     *
     * @param array $items
     *
     * @return array
     */
    protected function filterByMiddleware (array $items) : array
    {
        return Arr::where($items, function ($item) {
            // Get current middleware of the route
            $currentMiddlewareInRoute = $item->routeName ? Route::getRoutes()->getByName($item->routeName)->middleware() : null;

            // Check the middleware for if it passes
            if( is_array($currentMiddlewareInRoute) ) {
                foreach ($currentMiddlewareInRoute as $middlewareName) {
                    if(isset($this->middleware[$middlewareName]) && $this->middleware[$middlewareName] !== true) {
                        return false;
                    }
                }
            }

            // If something else has been send through then an array or null then we will throw an error
            if( !is_null($currentMiddlewareInRoute) && !is_array($currentMiddlewareInRoute)) {
                Throw new Exception("Current route middleware is different then expended and should be an array, route: \"{$item->routeName}\"", 500);
            }

            // Filter the sub menu as well if it's present
            if( $item->subMenu && !empty($item->subMenu)) {
                $this->filterByMiddleware($item->subMenu);
            }

            // Everything is good :ok_hand:
            return true;
        });
    }

    /**
     * Clean up the items in the navigation
     * -- By removing items that don't have a route and sub menu
     * -- Sort the items by the order given
     *
     * @param array $items
     *
     * @return array
     */
    protected function cleanup(array $items) : array
    {
        // Remove items that don't have a route and sub menu
        // and add additional variables
        $items = collect($items)->mapWithKeys(function($item, $key) {
            // Begin with the cleanup on the sub items if they are set
            if( $item->subMenu || !empty($item->subMenu) ) {
                $item->subMenu = $this->cleanup($item->subMenu);
            }

            // Remove the item if the url and sub menu are null or empty
            if( !$item->getUrl() && ( !$item->subMenu || empty($item->subMenu) ) ) {
                return [];
            }

            // Add the additional variables that are needed
            $item->addAdditionalVariables();

            return [$key => $item];
        })->toArray();

        // Sort the items on the order variable
        usort($items, function ($a, $b) {
            return strcmp($a->order, $b->order);
        });

        // return the items again
        return $items;
    }
}
