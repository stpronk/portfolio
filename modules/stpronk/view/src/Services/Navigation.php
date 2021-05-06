<?php

namespace Stpronk\View\Services;

use Illuminate\Contracts\View\View;
use Stpronk\View\Services\Navigation\Item;

class Navigation {

    // TODO: Redo all the http error messages and codes
    // TODO: Add a default group option to every filter if a group has been given in the options

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
     * Available filters for the navigation
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Navigation constructor.
     *
     * @param array $styles
     * @param array $filters
     */
    public function __construct(array $styles = [], array $filters = [])
    {
        $this->setStyles($styles);
        $this->setFilters($filters);
    }

    /**
     * Set styles for the navigation
     *
     * @param array $styles
     *
     * @return array
     */
    protected function setStyles(array $styles) : array
    {
        return $this->styles = array_merge(config('view.navigation.styles'), $styles);
    }

    /**
     * set filters for the navigation
     *
     * @param array $filters
     *
     * @return array
     */
    protected function setFilters(array $filters) : array
    {
        return $this->filters = array_merge(config('view.navigation.filters'), $filters);
    }

    /**
     * Returns all the styles that are available within the system
     *
     * if desired, could be overwritten within the app space when extending this class
     *
     * filters should be added within an array in the following fashion: [
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
     * Returns all the filters that are available within the system
     *
     * if desired, could be overwritten within the app space when extending this class
     *
     * @return array
     */
    protected function filters() : array
    {
        return $this->filters;
    }

    /**
     * Filter the navigation based on the filter given
     *
     * @param string $filter
     * @param array  $options
     *
     * @return array|string|void
     */
    protected function filterNavigation (string $filter, array $options) : array
    {
        return (new $this->filters[$filter]($this->items, $options))->filter();
    }


    /**
     * ********************** FACADE FUNCTIONS **********************
     */

    /**
     * Add an item to the navigation menu
     *
     * @param string      $title
     * @param string      $icon
     * @param null|string $routeName
     * @param bool        $auth
     * @param bool        $admin
     * @param null|string $group
     * @param null|int    $order
     * @param array       $options
     *
     * @return \Stpronk\View\Services\Navigation\Item
     * @throws \Exception
     */
    public function addItem(string $title, string $icon, ?string $routeName, bool $auth, bool $admin, ?string $group = null, ?int $order = null, array $options = []) : Item
    {
        if (isset($this->items[$title])) {
            throw new \Exception("This item already exists within the navigation: \"{$title}\"", '500');
        }

        return $this->items[$title] = new Item($title, $icon, $routeName, $auth, $admin, $group, $order, $options);
    }

    /**
     * Add a sub item to an existing item
     *
     * @param string      $key
     * @param string      $title
     * @param string      $icon
     * @param null|string $routeName
     * @param bool        $auth
     * @param bool        $admin
     * @param null|string $group
     * @param null|int    $order
     * @param array       $options
     *
     * @return \Stpronk\View\Services\Navigation\Item
     * @throws \Exception
     */
    public function addSubItemToExisting (string $key, string $title, string $icon, ?string $routeName, bool $auth, bool $admin, ?string $group = null, ?int $order = null, array $options = []) : Item
    {
        if (!isset($this->items[$key])) {
            Throw new \Exception("The item you are trying to add an sub item to does not exists: \"{$key}\"", '500');
        }

        $this->items[$title]->addSubItem($title, $icon, $routeName, $auth, $admin, $group, $order, $options);

        return $this->items[$title];
    }

    /**
     * Generate a filter for navigation that is desired
     *
     * @param null|string $filter
     * @param null|string $style
     * @param array       $options
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function generate (string $filter = null, string $style = null, array $options = []) : View
    {
        if(!$filter) {
            Throw new \Exception('A filter needs to given to load the right items, please refer to the documentation for the available filters or use one of the following: '.implode(', ', $this->filters()), 500);
        }

        if(!isset($this->filters()[$filter])) {
            Throw new \Exception("The filter that has been given is not known within our system, given filter: \"{$filter}\"", 500);
        }

        if(!$style) {
            Throw new \Exception('A style needs to be given to the generate function, please refer to the documentation to the available styles or use one of the following: '.implode(', ', $this->styles()), 500);
        }

        if(!isset($this->styles()[$style])) {
            Throw new \Exception("The style that has been given is not known within our system, given style: \"{$style}\"", 500);
        }

        $items = $this->filterNavigation($filter, $options);

        return view($this->styles()[$style], [
            'navigation' => $items
        ]);
    }
}

