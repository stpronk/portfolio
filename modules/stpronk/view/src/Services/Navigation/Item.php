<?php

namespace Stpronk\View\Services\Navigation;

use Illuminate\Support\Str;

class Item
{
    // TODO: Clean up this class and add PHPDOCS
    // TODO: Create docs for the options and what can be given through to the items
    // TODO | Change the place where this class will be set to an array (Might need more work then expected (Expected place is the compiler class))

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

//    /**
//     * @return array
//     */
//    public function toArray() : array
//    {
//        $this->additionVariables();
//
//        return [
//            'title'         => $this->title,
//            'icon'          => $this->icon,
//            'url'           => $this->route(),
//            'routeName'     => $this->routeName,
//            'order'         => $this->order,
//            'sub-active'    => $this->subIsActive,
//            'active'        => $this->isActive,
//            'has-sub'       => $this->hasSubMenu,
//            'hide-sub-menu' => isset($this->options['hide-sub-menu']),
//
//            'sub-menu' => ! $this->subMenu ? null
//                : collect($this->subMenu)->map(function ($item) {
//                    return $item->toArray();
//                })->toArray(),
//        ];
//    }

    /**
     * @return null|string
     */
    public function route() : ?string
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
        $this->subIsActive = $this->isSubActive();
        $this->isActive    = $this->isActive();
        $this->hasSubMenu  = $this->hasSubMenu();
        $this->url         = $this->route();
    }


    /**
     * ********************** HELPER FUNCTIONS **********************
     */

    /**
     * @return bool
     */
    protected function isSubActive () : bool
    {
        if (!$this->subMenu) {
            return false;
        }

        if (isset($this->options['hide-sub-menu'])) {
            return false;
        }

        foreach ($this->subMenu as $key => $item) {
            if($this->subMenu && ( Str::contains( url()->current(), $item->route()))) {
                return true;
            }
        }

        return $this->subMenu && ( Str::contains( url()->current(), $this->route()) );
    }

    /**
     * @return bool
     */
    protected function isActive () : bool
    {
        // Sub active and hide sub is active means active can't be true
        if ($this->subIsActive && !isset($this->options['hide-sub-menu'])) {
            return false;
        }

        if($this->route() === url()->current() && !$this->subMenu) {
            return true;
        }

        if(!$this->subMenu) {
            return false;
        }

        if ((( $this->subMenu && isset($this->options['hide-sub-menu']) ) &&  Str::contains( url()->current(), $this->route()) ) || ( !$this->subMenu && Str::contains( url()->current(), $this->route()) )) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function hasSubMenu () : bool
    {
        if( $this->subMenu && !isset($this->options['hide-sub-menu']) ) {
            return true;
        }

        return false;
    }
}
