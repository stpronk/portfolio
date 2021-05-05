<?php

return [
    'styles' => [
        'general' => 'view::navigation.styles.general',
        'submenu' => 'view::navigation.styles.submenu',
    ],

    'types' => [
        'general' => 'Stpronk\\View\\Services\\Navigation\\Types\\General',
        'admin'   => 'Stpronk\\View\\Services\\Navigation\\Types\\Admin',
        'submenu' => 'Stpronk\\View\\Services\\Navigation\\Types\\Submenu',
    ]
];
