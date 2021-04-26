<?php

namespace Stpronk\View\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Stpronk\View\Services\Navigation\Item;

class Navigation {

    // TODO: Redo all the http error messages and codes
    // TODO: Setup the types as dynamically loading in classes

    /**
     * @var array
     */
    public $items = [];

    /**
     * Available styles for the navigation
     *
     * Styles are imported through the config file in the constructor
     *
     * @var string[]
     */
    protected $styles = [];

    /**
     * Available types for the navigation
     * TODO: Maybe find a way to make this more dynamic
     *
     * @var array
     */
    protected $types = [
        'general',
        'admin',
        'submenu'
    ];

    /**
     * Navigation constructor.
     *
     * @param array $styles
     * @param array $types
     */
    public function __construct(array $styles = [], array $types = [])
    {
        $this->setStyles($styles);
        $this->setTypes($types);
    }

    /**
     * Set styles for the navigation
     *
     * @param $styles
     *
     * @return array
     */
    private function setStyles(array $styles) : array
    {
        return $this->styles = array_merge(config('view.navigation.styles'), $styles);
    }

    /**
     * Returns all the styles that are available within the system
     *
     * if desired, could be overwritten within the app space when extending this class
     *
     * Types should be added within an array in the following fashion: [
     *      'Name' => 'path.to.blade'
     * ]
     *
     * @return array
     */
    protected function styles() : array
    {
        return $this->styles;
    }

    /**
     * set types for the navigation
     *
     * @param array $types
     *
     * @return array
     */
    private function setTypes(array $types) : array
    {
        return $this->types = array_merge($this->types, $types);
    }

    /**
     * Returns all the types that are available within the system
     *
     * if desired, could be overwritten within the app space when extending this class
     *
     * @return array
     */
    protected function types() : array
    {
        return $this->types;
    }


    /**
     * Add an item to the navigation menu
     *
     * @param string $title
     * @param string $icon
     * @param string $routeName
     * @param bool   $auth
     * @param bool   $admin
     * @param int    $order
     *
     * @param array  $options
     *
     * @return \Stpronk\View\Services\Navigation\Item
     * @throws \Exception
     */
    public function addItem(string $title, string $icon, string $routeName, bool $auth, bool $admin, int $order, array $options = []) : Item
    {
        if (isset($this->items[$title])) {
            throw new \Exception("This item already exists within the navigation: \"{$title}\"", '500');
        }

        return $this->items[$title] = new Item($title, $icon, $routeName, $auth, $admin, $order, $options);
    }

    /**
     * Add a sub item to an existing item
     *
     * @param string $key
     * @param string $title
     * @param string $icon
     * @param string $routeName
     * @param bool   $auth
     * @param bool   $admin
     * @param int    $order
     *
     * @param array  $options
     *
     * @return \Stpronk\View\Services\Navigation\Item
     * @throws \Exception
     */
    public function addSubItemToExisting (string $key, string $title, string $icon, string $routeName, bool $auth, bool $admin, int $order, array $options = []) : Item
    {
        if (!isset($this->items[$key])) {
            Throw new \Exception("The item you are trying to add an sub item to does not exists: \"{$key}\"", '500');
        }

        $this->items[$title]->addSubItem($title, $icon, $routeName, $auth, $admin, $order, $options);

        return $this->items[$title];
    }

    /**
     * Generate a type for navigation that is desired
     *
     * @param null|string $style
     * @param null|string $type
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function generate (string $style = null, string $type = null) : View
    {
        if(!$type) {
            Throw new \Exception('A type needs to given to load the right items, please refer to the documentation for the available types or use one of the following: '.implode(', ', $this->types()), 500);
        }

        if(!in_array($type, $this->types())) {
            Throw new \Exception("The type that has been given is not known within our system, given type: \"{$type}\"", 500);
        }

        if(!$style) {
            Throw new \Exception('A style needs to be given to the generate function, please refer to the documentation to the available styles or use one of the following: '.implode(', ', $this->styles()), 500);
        }

        if(!isset($this->styles()[$style])) {
            Throw new \Exception("The style that has been given is not known within our system, given style: \"{$style}\"", 500);
        }

        $items = $this->filterNavigation($type);

        return view($this->styles()[$style], [
            'navigation' => $items
        ]);
    }


    /**
     * Filter the navigation based on the type given
     *
     * @param string $type
     *
     * @return array|string|void
     * @throws \Exception
     */
    protected function filterNavigation (string $type) : array
    {
        $type = Str::ucfirst($type);
        $className = "Stpronk\\View\\Services\\Navigation\\Types\\{$type}";
        return (new  $className($this->items))->filter();
    }

    /**
     * Set the navigation to an array to be used within the blades
     *
     * @param array $items
     *
     * @return array
     */
    protected function navigationToArray(array $items) : array
    {
        $items = collect($items)->mapWithKeys(function($item) {
            $item = $item->toArray();

            return [$item['order'] => $item];
        })->toArray();

        return $items;
    }
}

