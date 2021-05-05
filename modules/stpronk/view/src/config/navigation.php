<?php

return [
    'styles' => [
        'general' => 'view::navigation.styles.general',
        'submenu' => 'view::navigation.styles.submenu',
    ],

    'types' => [
        'general' => 'Stpronk\\View\\Services\\Navigation\\Types\\General',
        'group'   => 'Stpronk\\View\\Services\\Navigation\\Types\\Group',
        'admin'   => 'Stpronk\\View\\Services\\Navigation\\Types\\Admin',
        'submenu' => 'Stpronk\\View\\Services\\Navigation\\Types\\Submenu',
    ]
];
