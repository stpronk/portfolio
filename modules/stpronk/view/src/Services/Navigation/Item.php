<?php

namespace Stpronk\View\Services\Navigation;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Item
{
    // TODO | Create docs for the options and what can be given through to the items

    public $title;
    public $icon;
    public $routeName;
    public $url;
    public $slug;
    public $order;
    public $options = [];
    public $subMenu = [];

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
        $this->routeName = $routeName ?? null;
        $this->order     = $order ?? 0;
        $this->options   = $options ?? [];
        $this->subMenu   = $submenu ?? [];

        $this->slug = $this->getSlugAttributes();
    }


    /**
     * ********************** GETTERS **********************
     */

    /**
     * get the full url based on the route name
     *
     * @return null|string
     */
    public function getUrlAttribute() : ?string
    {
        return $this->routeName ? route($this->routeName) : null;
    }

    /**
     * Create a slug that can be used within the front-end
     *
     * @return string
     */
    public function getSlugAttributes() : string
    {
        return Str::slug($this->title);
    }


    /**
     * ********************** HELPER FUNCTIONS **********************
     */

    /**
     * Add addition variables to the class
     *
     * @return void
     */
    public function addAdditionalVariables () : void
    {
        $this->url = $this->getUrlAttribute();
        $this->hasSubMenu  = $this->hasSubMenu();
        $this->subIsActive = $this->isSubActive();
        $this->isActive    = $this->isActive();
    }

    /**
     * Find of if an sub menu item is active
     * TODO | Change this function, it is mostly based on the url containing some of the sub item url
     * TODO | Clean up the whole function
     *
     * @return bool
     */
    private function isSubActive () : bool
    {
        if ( isset($this->options['track-sub-active']) && Str::contains( url()->current(), $this->url) && $this->url !== url()->current()) {
            return true;
        }

        if ( ! $this->subMenu || isset($this->options['hide-sub-menu'])) {
            return false;
        }

        foreach ($this->subMenu as $item) {
            if($this->subMenu && ( Str::contains( url()->current(), $item->url))) {
                return true;
            }
        }

        return ($this->subMenu && Str::contains( url()->current(), $this->url) );
    }

    /**
     * Find out if the current item is active
     * TODO | Might want to reconsider this function if we change the "isSubActive()" function
     * TODO | Clean up the whole function
     *
     * @return bool
     */
    private function isActive () : bool
    {
        // Sub active and hide sub is active means active can't be true
        if ($this->subIsActive && !(!isset($this->options['hide-sub-menu']) || !isset($this->options['track-sub-active']))) {
            return false;
        }

        if($this->url === url()->current() && !$this->subMenu) {
            return true;
        }

        if(!$this->subMenu && !isset($this->options['track-sub-active'])) {
            return false;
        }

        if ( (( $this->subMenu && isset($this->options['hide-sub-menu']) ) &&  Str::contains( url()->current(), $this->url))
            || ( !$this->subMenu && Str::contains( url()->current(), $this->url) )
            || ( $this->subIsActive && isset($this->options['track-sub-active']) )
        ) {
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
