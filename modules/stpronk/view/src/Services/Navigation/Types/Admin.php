<?php

Namespace Stpronk\View\Services\Navigation\Types;

use Illuminate\Support\Arr;
use Stpronk\View\Services\Navigation\Interfaces\TypeInterface;

class Admin extends BaseType implements TypeInterface {

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
