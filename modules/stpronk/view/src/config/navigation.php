<?php

return [
    'styles' => [
        'general' => 'view::navigation.general',
        'submenu' => 'view::navigation.submenu',
    ],

    'types' => [
        'general' => 'Stpronk\\View\\Services\\Navigation\\Types\\General',
        'admin'   => 'Stpronk\\View\\Services\\Navigation\\Types\\Admin',
        'submenu' => 'Stpronk\\View\\Services\\Navigation\\Types\\Submenu',
    ]
];
