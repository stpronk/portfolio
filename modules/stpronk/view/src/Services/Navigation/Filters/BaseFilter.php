<?php

Namespace Stpronk\View\Services\Navigation\Filters;

class BaseFilter {

    /**
     * All navigation items
     *
     * @var array
     */
    protected $items = [];

    protected $options = [];

    /**
     * BaseType constructor.
     *
     * @param array $items
     * @param array $options
     */
    public function __construct(array $items, array $options)
    {
        $this->options = $options;
        $this->items = $items;
        $this->items = $this->navigationToArray();
    }

    /**
     * Set the navigation to an array to be used within the blades
     *
     * @return array
     */
    protected function navigationToArray() : array
    {
        $items = collect($this->items)->map(function($item) {
            return $item->toArray();
        })->toArray();

        usort($items, function ($a, $b) {
            return strcmp($a['order'], $b['order']);
        });

        return $items;
    }
}
