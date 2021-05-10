<?php

Namespace Stpronk\View\Services\Navigation\Filters;

use Stpronk\View\Services\Navigation\Interfaces\FilterInterface;
use Stpronk\View\Services\Navigation\Item;

class Submenu extends BaseFilter implements FilterInterface {

    /**
     * Filter the navigation array
     *
     * @param \Stpronk\View\Services\Navigation\Item $item
     *
     * @return bool
     */
    public function filter(Item $item) : bool
    {
        // TODO | Create this filter
        return true;
    }
}
