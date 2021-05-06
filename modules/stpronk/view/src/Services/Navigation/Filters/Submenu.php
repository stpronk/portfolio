<?php

Namespace Stpronk\View\Services\Navigation\Filters;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Stpronk\View\Services\Navigation\Interfaces\FilterInterface;

class Submenu extends BaseType implements FilterInterface {

    /**
     * Filter the navigation array
     *
     * @return array
     * @throws \Exception
     */
    public function filter() : array
    {
        // TODO: Refactor this code to make it more stable
        $item = Arr::where($this->items, function ($item) {
            if ( ! Str::contains( url()->current(), $item['route']) ) return false;
            if ( !$item['sub-menu'] ) return false;
            return true;
        });

        if( count($item) > 1 ) Throw new \Exception('There is more one item that fits the criteria...');
        if( count($item) === 0 ) return [];

        return Arr::first($item)['sub-menu'];
    }
}
