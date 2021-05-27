<?php

namespace Stpronk\View\Services;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Stpronk\View\Services\Navigation\Builder;
use Stpronk\View\Services\Navigation\Compiler;

class Navigation {

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
     * ********************** CACHE FUNCTIONS **********************
     * TODO | SUGGESTION | Might want to place these function within a separate class within the core package
     */

    /**
     * Get the items of the selected group with options from the compiler or cache
     *
     * @param string     $group
     * @param null|array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function getItems (string $group, ?array $options) : array
    {
        // Create a unique ID that is constant with the group and options to be used as caching key
        // TODO | When roles are implemented within the application, this unique id should also implement the role string
        $cacheKey = $this->createCacheKey([
            'auth'    => Auth::check() ? 'true' : 'false',
            'group'   => $group,
            'options' => $options,
        ]);

        // In case of development, you might want to remove the cache for debugging purpose
        if ( Cache::has($cacheKey) && !env('APP_DEBUG') ) {
            Cache::forget($cacheKey);
        }

        // If the cache has not been set, compile and set the cache
        if ( !Cache::has($cacheKey) ) {
            // Compile the group to the right format through the compiler
            Cache::put($cacheKey, $items = (new Compiler($this->getGroups()[$group], $options))->compile());
        } else {
            $items = Cache::get($cacheKey);
        }

        return $items;
    }

    /**
     * Create the cache key for the navigation that will be create or already is created
     *
     * TODO | Might want to use a way to inject these rules dynamically?
     *
     * @param array  $array
     * @param string $seperator
     * @param string $string
     *
     * @return string
     */
    private function createCacheKey(array $array, string $seperator = '|', string $string = '') : string
    {
        // Loop over the array and format everything correctly
        $array = collect($array)->map(function ($value, $key) {
            return $key . ':' . (is_string($value) ? $value : json_encode($value));
        })->toArray();

        // Return the formatted imploded array back within a md5 hash, md5 is used for a simpler alternative to the cache key
        return md5(($string ? $string . $seperator : null) . implode($seperator, $array));
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
     * Generate a filter for navigation group that is desired
     *
     * @param string      $group
     * @param null|string $style
     * @param array       $options
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function generateMenu (string $group, string $style, array $options = []) : View
    {
        // Groups validation
        if(!$group) {
            Throw new Exception('A group needs to given to load the right items, please use one of the following: '.implode(', ', array_keys($this->getGroups())), 412);
        }

        if(!isset($this->getGroups()[$group])) {
            Throw new Exception("The group that has been given is not known within our system, given group: \"{$group}\"", 400);
        }

        // Style validation
        if(!$style) {
            Throw new Exception('A style needs to be given to the generate function, please refer to the documentation to the available styles or use one of the following: '.implode(', ', array_keys($this->getStyles())), 412);
        }

        if(!isset($this->getStyles()[$style])) {
            Throw new Exception("The style that has been given is not known within our system, given style: \"{$style}\"", 400);
        }

        // Return the blade to the front-end with the items
        return view($this->getStyles()[$style], [
            'navigation' => $this->getItems($group, $options)
        ]);
    }
}

