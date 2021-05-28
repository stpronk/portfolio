<?php

if (!function_exists('navigation')) {
    function navigation(string $group): \Stpronk\View\Services\Navigation\Builder
    {
        return \Stpronk\View\Facades\Navigation::group($group);
    }
}

if(!function_exists('generateMenu')) {
    function generateMenu(string $group, string $style, array $options = []) : \Illuminate\Contracts\View\View
    {
        return \Stpronk\View\Facades\Navigation::generateMenu($group, $style, $options);
    }
}
