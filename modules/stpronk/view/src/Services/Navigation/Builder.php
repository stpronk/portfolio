<?php

Namespace Stpronk\View\Services\Navigation;

use Exception;
use Illuminate\Support\Str;

class Builder
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var string
     */
    public $name;

    /**
     * Builder constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Add an item to the navigation menu
     *
     * @param string        $title
     * @param string        $icon
     * @param null|string   $routeName
     * @param null|int      $order
     * @param null|callable $submenu
     *  @param null|array    $options
     *
     * @return \Stpronk\View\Services\Navigation\Builder
     * @throws \Exception
     */
    public function addItem(string $title, string $icon, ?string $routeName, ?int $order = null, ?callable $submenu = null, ?array $options = []) : Builder
    {
        // Execute the call back if it exists
        if ( $submenu ) {
            $submenu($submenu = new Builder('submenu'));
        }

        // Create the item if able
        $item = new Item($title, $icon, $routeName, $order, $options, $submenu ?? null);

        // Check if there is an item with the same title already in the item array
        if (isset($this->items[$item->slug])) {
            throw new Exception("This item already exists within the group: \"{$title}\"", '500');
        }

        // Set the item within the array under the slug
        $this->items[$item->slug] = $item;

        // Return the builder itself again
        return $this;
    }
}
