<?php

namespace Stpronk\View\Facades;

use \Illuminate\Support\Facades\Facade;

/**
 * Class Navigation
 *
 * @package Stpronk\View\Facades
 *
 * @method static \Stpronk\View\Services\Navigation\Builder group(string $name)
 * @method static \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View generate(string $group, string $style, array $filters = [], array $options = []) Generate a navigation
 */
class Navigation extends Facade
{
    protected static function getFacadeAccessor(): string
    { return 'Navigation'; }
}
