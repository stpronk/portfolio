<?php

Namespace Stpronk\View\Services\Navigation;

class Compiler
{

    /**
     * @var \Stpronk\View\Services\Navigation\Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array
     */
    protected $options;

    /**
     * Builder constructor.
     *
     * @param \Stpronk\View\Services\Navigation\Builder $builder
     * @param array                                     $options
     *
     * @throws \Exception
     */
    public function __construct(Builder $builder, array $options)
    {
        // Set all values to the right variables
        $this->builder = $builder;
        $this->items   = $builder->items;
        $this->options = $options;

        // Setup some additional variables
        $this->setFilters();

        // Validate the values before passing constructor
        $this->validateValues();
    }

    /**
     * Validate the given values
     *
     * @throws \Exception
     * @return void
     */
    protected function validateValues() : void
    {
        // Search for the given filters and see if they exists within the system
        // If they don't exists then we will give back an error message with the
        // name of the filter they are trying to pass through
        if(isset($this->options['filters'])) {
            collect($this->options['filters'])->map(function ($value, $key) {
                if (is_array($value) && !isset($this->getFilters()[$key])) {
                    Throw new \Exception("The given filter does not exists in our system: \"{$key}\"", 500);
                }

                if (!is_array($value) && !isset($this->getFilters()[$value])) {
                    Throw new \Exception("The given filter does not exists in our system: \"{$value}\"", 500);
                }
            });
        }
    }

    /**
     * set filters that can be used for compiling
     *
     * @return array
     */
    protected function setFilters() : array
    {
        return $this->filters = config('view.navigation.filters');
    }

    /**
     * Get the defined filters
     *
     * @return array
     */
    protected function getFilters() : array
    {
        return $this->filters;
    }


    /**
     * *************** COMPILE FUNCTIONS ***************
     */

    /**
     * Compile the given values to the right format to be used by the blade
     *
     * @return array
     */
    public function compile() : array
    {
        $this->executeFilters();

        return $this->items;
    }

    /**
     * Execute the filters if any are given
     *
     * @return array
     */
    protected function executeFilters () : array
    {
        if( isset($this->options['filters'])) {
            collect($this->options['filters'])->map(function ($value, $key) {
                if (is_array($value) && ! isset($this->getFilters()[$key])) {
                    return $this->items = $this->filter($key, $value);
                }

                return $this->items = $this->filter($value);
            });
        }

        return $this->items;
    }

    /**
     * Filter the navigation based on the filter given
     *
     * @param string $filter
     * @param array  $options
     *
     * @return array|string|void
     */
    protected function filter (string $filter, array $options = []) : array
    {
        return (new $this->filters[$filter]($options))->loopFilter($this->items);
    }

}
