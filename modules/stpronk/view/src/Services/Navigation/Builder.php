<?php

Namespace Stpronk\View\Services\Navigation;

use Exception;

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
        // Check if there is an item with the same title already in the item array
        if (isset($this->items[$title])) {
            throw new Exception("This item already exists within the group: \"{$title}\"", '500');
        }

        // Execute the call back if it exists
        if ( $submenu ) {
            $submenu($submenu = new Builder('submenu'));
        }

        // Set the item within the item array
        $this->items[$title] = new Item($title, $icon, $routeName, $order, $options, $submenu ?? null);

        return $this;
    }
}
