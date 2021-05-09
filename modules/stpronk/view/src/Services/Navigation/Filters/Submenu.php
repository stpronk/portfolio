<?php

Namespace Stpronk\View\Services\Navigation\Filters;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Stpronk\View\Services\Navigation\Interfaces\FilterInterface;
use Stpronk\View\Services\Navigation\Item;

class Submenu extends BaseFilter implements FilterInterface {

    /**
     * Filter the navigation array
     *
     * @return array
     * @throws \Exception
     */
    public function filter(Item $item) : bool
    {
        // TODO | Create this filter
        return true;
    }
}
