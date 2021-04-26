<?php

Namespace Stpronk\View\Services\Navigation\Types;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Stpronk\View\Services\Navigation\Interfaces\TypeInterface;

class General extends BaseType implements TypeInterface {

    /**
     * Filter the navigation array
     *
     * @return array
     */
    public function filter() : array
    {
        return Arr::where($this->items, function ($item) {
            if ($item['admin']) return false;
            if ($item['auth'] && !( $item['auth'] && Auth::check() )) return false;

            return true;
        });
    }
}
