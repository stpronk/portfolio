<?php

namespace Stpronk\View\Services\Navigation;

use Illuminate\Support\Str;

class Item
{
    public $title;
    public $icon;
    public $route;
    public $auth;
    public $admin;
    public $order;
    public $subMenu = [];
    public $options = [];

    public $subIsActive;
    public $isActive;
    public $hasSubMenu;

    public function __construct(
        string $title,
        string $icon,
        string $route,
        bool $auth,
        bool $admin,
        int $order,
        array $options = []
    ) {
        $this->title = $title;
        $this->icon = $icon;
        $this->route = $route;
        $this->auth = $auth;
        $this->admin = $admin;
        $this->order = $order;
        $this->subMenu = [];
        $this->options = $options;
    }

    public function addSubItem (string $title, string $icon, string $routeName, bool $auth, bool $admin, int $order)
    {
        $this->subMenu[] = new Item($title, $icon, $routeName, $auth, $admin, $order);

        return $this;
    }

    public function toArray() {

        return [
            'title'      => $this->title,
            'icon'       => $this->icon,
            'route'      => $this->route(),
            'auth'       => $this->auth,
            'admin'      => $this->admin,
            'order'      => $this->order,
            'sub-active' => $this->isSubActive(),
            'active'     => $this->isActive(),
            'has-sub'    => $this->hasSubMenu(),
            'hide-sub-menu' => isset($this->options['hide-sub-menu']),

            'sub-menu' => ! $this->subMenu ? null
                : collect($this->subMenu)->map(function ($item) {
                    return $item->toArray();
                })->toArray(),
        ];
    }


    public function route()
    {
        return $this->route !== '' ? route($this->route) : null;
    }

    protected function isSubActive ()
    {
        if ($this->subMenu) {
            return false;
        }

        if (isset($this->options['hide-sub-menu'])) {
            return false;
        }

        return $this->subMenu && ( Str::contains( url()->current(), $this->route()) );
    }

    protected function isActive ()
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

    protected function hasSubMenu ()
    {
        if( $this->subMenu && !isset($this->options['hide-sub-menu']) ) {
            return true;
        }

        return false;
    }
}
