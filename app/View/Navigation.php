<?php

namespace App\View;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Navigation {

    public $navigation;

    /**
     * Navigation constructor.
     */
    public function __construct () {
        $this->navigation = require resource_path('variables/navigation.php');
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
            if ( !\Illuminate\Support\Str::contains( url()->current(), $item['route']) ) {
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
}

