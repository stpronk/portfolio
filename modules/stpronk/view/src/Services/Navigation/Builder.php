<?php

Namespace Stpronk\View\Services\Navigation;

class Builder
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var string
     */
    protected $name;

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
     * @param null|array    $options
     * @param null|callable $callback
     *
     * @return \Stpronk\View\Services\Navigation\Builder
     * @throws \Exception
     */
    public function addItem(string $title, string $icon, ?string $routeName, ?int $order = null, ?array $options = [], ?callable $callback = null) : Builder
    {
        if (isset($this->items[$title])) {
            throw new \Exception("This item already exists within the group: \"{$title}\"", '500');
        }

        // Execute the call back if it exists
        if ( $callback ) {
            $callback($submenu = new Builder('submenu'));
        }

        $this->items[$title] = new Item($title, $icon, $routeName, $order, $options, $submenu ?? null);

        return $this;
    }



//
//    TODO | create and way to add sub items to an existing item with sub menu
//
//    /**
//     * Add a sub item to an existing item
//     *
//     * @param string      $key
//     * @param string      $title
//     * @param string      $icon
//     * @param null|string $routeName
//     * @param bool        $auth
//     * @param bool        $admin
//     * @param null|string $group
//     * @param null|int    $order
//     * @param array       $options
//     *
//     * @return \Stpronk\View\Services\Navigation\Item
//     * @throws \Exception
//     */
//    public function addSubItemToExisting (string $key, string $title, string $icon, ?string $routeName, bool $auth, bool $admin, ?string $group = null, ?int $order = null, array $options = []) : Item
//    {
//        if (!isset($this->items[$key])) {
//            Throw new \Exception("The item you are trying to add an sub item to does not exists: \"{$key}\"", '500');
//        }
//
//        $this->items[$title]->addSubItem($title, $icon, $routeName, $auth, $admin, $group, $order, $options);
//
//        return $this->items[$title];
//    }
}
