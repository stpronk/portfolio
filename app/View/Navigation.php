<?php

namespace App\View;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Navigation {

    public $navigation;

    /**
     * Navigation constructor.
     */
    public function __construct () {
        $this->navigation = require resource_path('variables/navigation.php');

        $this->initCompiler();
    }

    /**
     * generate the General side menu
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function generateMenu () {
        $navigation = Arr::where($this->navigation, function ($item, $key) {
            if ($item['admin']) {
                return false;
            }

            if ( $item['auth'] && !( $item['auth'] && Auth::check() )) {
                return false;
            }

            return true;
        });

        return view('layouts.components.navigation.side.general', [
           'navigation' => $navigation
        ]);
    }

    /**
     * Generate the Admin menu
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function generateAdminMenu () {
        $navigation = Arr::where($this->navigation, function ($item, $key) {
            if (!$item['admin']) {
                return false;
            }

            return true;
        });

        return view('layouts.components.navigation.side.general', [
            'navigation' => $navigation
        ]);
    }

    /**
     * Generate the top menu
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function generateTopMenu () {
        $item = Arr::where($this->navigation, function ($item, $key) {
            if ( ! Str::contains( url()->current(), $item['route']) ) {
                return false;
            }

            if ( !$item['sub-menu'] ) {
                return false;
            }

            return true;
        });

        if( count($item) > 1 ) {
            Throw new \Exception('There is more one Sub Menu present...');
        }

        if( count($item) === 0 ) {
            return '';
        }

        return view('layouts.components.navigation.top.general', [
            'navigation' => Arr::first($item)['sub-menu']
        ]);
    }

    /**
     * Compile navigation to setup variables for the front-end
     *
     * @return array
     */
    protected function initCompiler ()
    {
        $this->navigation = collect($this->navigation)->mapWithKeys(function ($item, $key) {
            return [$key => $this->compiler($item)];
        })->toArray();

        return $this->navigation;
    }

    /**
     *
     *
     * @param $item
     *
     * @return mixed
     */
    protected function compiler ($item)
    {
        if (isset($item['sub-menu'])) {
            $item['sub-menu'] = collect($item['sub-menu'])->map(function ($item) {
                return $this->compiler($item);
            })->toArray();
        }

        $item['sub-active'] = $this->isSubActive($item);
        $item['active'] = $this->isActive($item);
        $item['has-sub'] = $this->hasSubMenu($item);

        return $item;
    }

    /**
     * Look if there is a active sub menu item
     *
     * @param $item
     *
     * @return bool
     */
    protected function isSubActive($item) {
        if (!isset($item['sub-menu'])) {
            return false;
        }

        if (isset($item['hide-sub-menu'])) {
            return false;
        }

        return $item['sub-menu'] && ( Str::contains( url()->current(), $item['route']) );
    }

    /**
     * Look if the item is active
     *
     * @param $item
     *
     * @return bool
     */
    protected function isActive($item)
    {
        // Sub active and hide sub is active means active can't be true
        if ($item['sub-active'] && !isset($item['hide-sub-menu'])) {
            return false;
        }

        if($item['route'] === url()->current() && !isset($item['sub-menu'])) {
            return true;
        }

        if(!isset($item['sub-menu'])) {
            return false;
        }

        if ((( $item['sub-menu'] && isset($item['hide-sub-menu']) ) &&  Str::contains( url()->current(), $item['route']) ) || ( !$item['sub-menu'] && Str::contains( url()->current(), $item['route']) )) {
            return true;
        }

        return false;
    }

    /**
     * Look if the item has a sub menu
     *
     * @param $item
     *
     * @return bool
     */
    protected function hasSubMenu ($item)
    {
        if( isset($item['sub-menu']) && !isset($item['hide-sub-menu'])) {
            return true;
        }

        return false;
    }
}

