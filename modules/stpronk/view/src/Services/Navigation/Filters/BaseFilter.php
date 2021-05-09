<?php

Namespace Stpronk\View\Services\Navigation\Filters;

use Illuminate\Support\Arr;
use Stpronk\View\Services\Navigation\Interfaces\FilterInterface;
use Stpronk\View\Services\Navigation\Item;

class BaseFilter implements FilterInterface {

    protected $items = [];

    protected $options = [];

    /**
     * BaseType constructor.
     *
     * @param array $items
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Loop through the items and sub menu's on which the filters will be executed
     * TODO | Change the naming of the function
     *
     * @param array $items
     *
     * @return array
     */
    public function loopFilter(array $items) : array
    {
        $items = Arr::where($items, function ($item) {
            return $this->filter($item);
        });

        foreach ($items as $item) {
            if($item->subMenu) {
                $item->subMenu = $this->loopFilter($item->subMenu->items);
            }
        }

        return $items;
    }

    /**
     * Filter that needs to be set up within it's own class
     *
     * @param \Stpronk\View\Services\Navigation\Item $item
     *
     * @return bool
     */
    public function filter(Item $item) : bool
    {
        return true;
    }

// TODO | Find a way to implement the function under here in the application
//
//    /**
//     * Set the navigation to an array to be used within the blades
//     *
//     * @return array
//     */
//    protected function navigationToArray() : array
//    {
//        $items = collect($this->items)->map(function($item) {
//            return $item->toArray();
//        })->toArray();
//
//        usort($items, function ($a, $b) {
//            return strcmp($a['order'], $b['order']);
//        });
//
//        return $this->items = $items;
//    }
//
//    /**
//     * Filter the array based on middleware
//     *
//     * @return array
//     */
//    protected function filterByMiddleware() : array
//    {
//        $middleware = collect(config('view.navigation.middleware-filters'))->mapWithKeys(function($class, $name) {
//            try {
//                // Try to access the middleware and see if it passes
//                // When it doesn't pass, it will return something so making that the opposite will return false.
//                // When passing, it will access the callback and will in return return false which makes it true in the end.
//                $result = !app($class)->handle(request(), function () { return false; });
//
//            } catch (\Exception $e) {
//                // When an exceptions pops up, we will catch this and this means the middleware has failed.
//                // When it fails, we will simply set the result to false
//                $result = false;
//            }
//
//            // Return de name of the middleware with the given result
//            return [$name => $result];
//        })->toArray();
//
//        dump($middleware);
//
//        $items = Arr::where($this->items, function ($item) use ($middleware) {
//            dump($item->route ? \Illuminate\Support\Facades\Route::getRoutes()->getByName($item->route)->middleware() : null);
//
//            return true;
//        });
//
//        return $this->items = $items;
//    }
}
