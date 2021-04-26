<?php

Namespace Stpronk\View\Services\Navigation\Types;

class BaseType {

    protected $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
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
