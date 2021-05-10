<?php

Namespace Stpronk\View\Services\Navigation\Filters;

use Illuminate\Support\Arr;
use Stpronk\View\Services\Navigation\Interfaces\FilterInterface;
use Stpronk\View\Services\Navigation\Item;

class BaseFilter implements FilterInterface {

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * BaseType constructor.
     *
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
        // Execute the filter on each items that has been passed through
        $items = Arr::where($items, function ($item) {
            return $this->filter($item);
        });

        // Also Execute the filter on each item on a sub menu
        return collect($items)->mapWithKeys(function($item, $key) {
            if($item->subMenu) {
                $item->subMenu = $this->loopFilter($item->subMenu);
            }

            return [$key => $item];
        })->toArray();
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
}
