<?php

Namespace Stpronk\View\Services\Navigation\Filters;

use Illuminate\Support\Arr;
use Stpronk\View\Services\Navigation\Interfaces\FilterInterface;

class Admin extends BaseFilter implements FilterInterface {

    /**
     * Filter the navigation array
     *
     * @return array
     */
    public function filter() : array
    {
        return Arr::where($this->items, function ($item) {
            if (!$item['admin']) return false;

            return true;
        });
    }
}
