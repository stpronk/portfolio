<?php

namespace Stpronk\View\Services;

use Exception;
use Illuminate\Contracts\View\View;
use Stpronk\View\Services\Navigation\Builder;
use Stpronk\View\Services\Navigation\Compiler;

class Navigation {

    // TODO: Redo all the http error messages and codes

    /**
     * @var array
     */
    protected $groups = [];

    /**
     * Available styles for the navigation
     *
     * Styles are imported through the config file in the constructor
     *
     * @var string[]
     */
    protected $styles = [];

    /**
     * Navigation constructor.
     *
     * @param array $styles
     */
    public function __construct(array $styles = [])
    {
        $this->setStyles($styles);
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
    protected function getStyles() : array
    {
        return $this->styles;
    }

    /**
     * Returns all groups that are available within the system
     *
     * @return array
     */
    protected function getGroups() : array
    {
        return $this->groups;
    }


    /**
     * ********************** FACADE FUNCTIONS **********************
     */

    /**
     * Create or select a navigation group
     *
     * @param string $name
     *
     * @return \Stpronk\View\Services\Navigation\Builder
     */
    public function group(string $name) : Builder
    {
        // if the group already exists then we will return that builder from the array
        if(isset($this->groups[$name])) {
            return $this->groups[$name];
        }

        // else we will create a new group and return that directly
        return $this->groups[$name] = new Builder($name);
    }

    /**
     * Generate a filter for navigation that is desired
     *
     * @param string      $group
     * @param null|string $style
     * @param array       $options
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function generate (string $group, string $style, array $options = []) : View
    {
        // Groups validation
        if(!$group) {
            Throw new Exception('A group needs to given to load the right items, please use one of the following: '.implode(', ', array_keys($this->getGroups())), 500);
        }

        if(!isset($this->getGroups()[$group])) {
            Throw new Exception("The group that has been given is not known within our system, given group: \"{$group}\"", 500);
        }

        // Style validation
        if(!$style) {
            Throw new Exception('A style needs to be given to the generate function, please refer to the documentation to the available styles or use one of the following: '.implode(', ', $this->styles()), 500);
        }

        if(!isset($this->getStyles()[$style])) {
            Throw new Exception("The style that has been given is not known within our system, given style: \"{$style}\"", 500);
        }

        // Compile the group to the right format through the compiler
        $items = (new Compiler($this->getGroups()[$group], $options))->compile();

        // Return the blade to the front-end
        return view($this->getStyles()[$style], [
            'navigation' => $items
        ]);
    }
}

