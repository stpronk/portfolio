<?php

return [
    'styles' => [
        'general' => 'view::navigation.styles.general',
    ],

    'filters' => [
        'general' => 'Stpronk\\View\\Services\\Navigation\\Filters\\General',
        'group'   => 'Stpronk\\View\\Services\\Navigation\\Filters\\Group',
        'admin'   => 'Stpronk\\View\\Services\\Navigation\\Filters\\Admin',
        'submenu' => 'Stpronk\\View\\Services\\Navigation\\Filters\\Submenu',
    ],

    'middleware-filters' => [
        'auth'    => 'App\\Http\\Middleware\\Authenticate',
        'isAdmin' => 'App\\Http\\Middleware\\isAdmin',
    ]
];
