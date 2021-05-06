<?php

Namespace Stpronk\View\Services\Navigation\Filters;

class BaseType {

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
        $this->items = $this->navigationToArray($items);
    }

    /**
     * Set the navigation to an array to be used within the blades
     *
     * @param array $items
     *
     * @return array
     */
    protected function navigationToArray(array $items) : array
    {
        $items = collect($items)->mapWithKeys(function($item) {
            $item = $item->toArray();

            return [$item['order'] => $item];
        })->toArray();

        return $items;
    }
}
