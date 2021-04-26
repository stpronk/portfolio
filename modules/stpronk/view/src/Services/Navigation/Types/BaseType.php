<?php

Namespace Stpronk\View\Services\Navigation\Types;

class BaseType {

    /**
     * All navigation items
     *
     * @var array
     */
    protected $items = [];

    /**
     * BaseType constructor.
     *
     * @param array $items
     */
    public function __construct(array $items)
    {
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
