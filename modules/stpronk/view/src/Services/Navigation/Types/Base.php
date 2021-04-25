<?php

Namespace Stpronk\View\Services\Navigation\Types;

class Base {

    protected $items = [];

    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
