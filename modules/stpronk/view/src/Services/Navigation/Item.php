<?php

namespace Stpronk\View\Services\Navigation;

use Illuminate\Support\Str;

class Item
{
    // TODO: Create docs for the options and what can be given through to the items

    public $title;
    public $icon;
    public $routeName;
    public $url;
    public $order;
    public $subMenu = [];
    public $options = [];

    public $subIsActive;
    public $isActive;
    public $hasSubMenu;

    /**
     * Item constructor.
     *
     * @param string                                         $title
     * @param string                                         $icon
     * @param null|string                                    $routeName
     * @param null|int                                       $order
     * @param null|array                                     $options
     * @param null|\Stpronk\View\Services\Navigation\Builder $submenu
     */
    public function __construct(
        string $title,
        string $icon,
        ?string $routeName,
        ?int $order,
        ?array $options,
        ?Builder $submenu
    ) {
        $this->title = $title;
        $this->icon = $icon;
        $this->routeName = $routeName;
        $this->order = $order ?? 0;
        $this->subMenu = [];
        $this->options = $options ?? [];
        $this->subMenu = $submenu;
    }

    /**
     * get the full url based on the route name
     *
     * @return null|string
     */
    public function getUrl() : ?string
    {
        return $this->routeName ? route($this->routeName) : null;
    }

    /**
     * Add addition variables to the class
     *
     * @return void
     */
    public function addAdditionalVariables () : void
    {
        $this->url         = $this->getUrl();
        $this->subIsActive = $this->isSubActive();
        $this->isActive    = $this->isActive();
        $this->hasSubMenu  = $this->hasSubMenu();
        $this->url         = $this->getUrl();
    }


    /**
     * ********************** HELPER FUNCTIONS **********************
     */

    /**
     * Find of if an sub menu item is active
     * TODO | Change this function, it is mostly based on the url containing some of the sub item url
     *
     * @return bool
     */
    private function isSubActive () : bool
    {
        if (!$this->subMenu) {
            return false;
        }

        if (isset($this->options['hide-sub-menu'])) {
            return false;
        }

        foreach ($this->subMenu as $key => $item) {
            if($this->subMenu && ( Str::contains( url()->current(), $item->url))) {
                return true;
            }
        }

        return $this->subMenu && ( Str::contains( url()->current(), $this->url) );
    }

    /**
     * Find out if the current item is active
     * TODO | Might want to reconsider this function if we change the "isSubActive()" function
     *
     * @return bool
     */
    private function isActive () : bool
    {
        // Sub active and hide sub is active means active can't be true
        if ($this->subIsActive && !isset($this->options['hide-sub-menu'])) {
            return false;
        }

        if($this->url === url()->current() && !$this->subMenu) {
            return true;
        }

        if(!$this->subMenu) {
            return false;
        }

        if ((( $this->subMenu && isset($this->options['hide-sub-menu']) ) &&  Str::contains( url()->current(), $this->url) ) || ( !$this->subMenu && Str::contains( url()->current(), $this->url) )) {
            return true;
        }

        return false;
    }

    /**
     * Find out if this item has a submenu
     *
     * @return bool
     */
    private function hasSubMenu () : bool
    {
        if( $this->subMenu && !isset($this->options['hide-sub-menu']) ) {
            return true;
        }

        return false;
    }
}
