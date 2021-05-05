<?php

Namespace Stpronk\View\Services\Navigation\Types;

use Illuminate\Support\Arr;
use Stpronk\View\Services\Navigation\Interfaces\TypeInterface;

class Group extends BaseType implements TypeInterface {

    /**
     * Filter the navigation array
     *
     * @return array
     * @throws \Exception
     */
    public function filter() : array
    {
        if(!isset($this->options['groups'])) {
            Throw new \Exception('This filter should implement `groups` with the desired groups within the options', 500);
        }

        if(!is_array($this->options['groups'])) {
            Throw new \Exception('This filter should have an array with desired groups within the `groups` variable within the options', 500);
        }

        $options = $this->options;

        return Arr::where($this->items, function ($item) use ($options) {
            if (!in_array($item['group'], $options['groups'])) {
                return false;
            }

            return true;
        });
    }
}
