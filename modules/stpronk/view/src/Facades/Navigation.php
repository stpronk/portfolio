<?php

namespace Stpronk\View\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * Class Navigation
 *
 * @package Stpronk\View\Facades
 *
 * @method static \Stpronk\View\Services\Navigation\Item addItem(string $title, string $icon, string $routeName, bool $auth, bool $admin, int $order, string $category = null, array $options = []) Add item to navigation
 * @method static \Stpronk\View\Services\Navigation\Item addSubItemToExisting(string $key, string $title, string $icon, string $routeName, bool $auth, bool $admin, int $order, string $category = null, array $options = []) Add sub-item to existing navigation item
 * @method static \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View generate(string $style, string $type) Generate a navigation
 */
class Navigation extends Facade
{
    protected static function getFacadeAccessor() { return 'Navigation'; }
}
