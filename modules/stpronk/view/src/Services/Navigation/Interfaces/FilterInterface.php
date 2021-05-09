<?php

Namespace Stpronk\View\Services\Navigation\Interfaces;

use Stpronk\View\Services\Navigation\Item;

interface FilterInterface {
    public function filter(Item $item) : bool;
}
