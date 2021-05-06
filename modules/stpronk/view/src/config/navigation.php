<?php

return [
    'styles' => [
        'general' => 'view::navigation.styles.general',
        'submenu' => 'view::navigation.styles.submenu',
    ],

    'filters' => [
        'general' => 'Stpronk\\View\\Services\\Navigation\\Filters\\General',
        'group'   => 'Stpronk\\View\\Services\\Navigation\\Filters\\Group',
        'admin'   => 'Stpronk\\View\\Services\\Navigation\\Filters\\Admin',
        'submenu' => 'Stpronk\\View\\Services\\Navigation\\Filters\\Submenu',
    ]
];
