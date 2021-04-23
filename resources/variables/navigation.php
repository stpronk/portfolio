<?php

return [
    'Dashboard' => [
        'title'    => 'Dashboard',
        'icon'     => 'th',
        'route'    => 'home',
        'auth'     => true,
        'admin'    => false,
        'sub-menu' => null,
    ],
    'Assignments' => [
        'title' => 'Assignments',
        'icon' => 'files-o',
        'route' => 'assignments',
        'auth' => false,
        'admin' => false,
        'sub-menu' => [
            [
                'title' => 'Dealer',
                'icon'  => 'car',
                'route' => 'assignment.dealer',
                'auth'  => false,
                'admin' => false,
            ],
            [
                'title' => 'Event planner',
                'icon'  => 'calendar',
                'route' => 'assignment.event-planner',
                'auth'  => false,
                'admin' => false
            ]
        ]
    ],
    'Finance'   => [
        'title'    => 'Finance',
        'icon'     => 'money',
        'route'    => 'finance.index',
        'auth'     => true,
        'admin'    => false,
        'sub-menu' => null
    ],

    /**
     * ---------- ADMIN ROUTES ----------
     */
    'Users' => [
        'title'    => 'Users',
        'icon'     => 'users',
        'route'    => 'users.index',
        'auth'     => true,
        'admin'    => true,
        'sub-menu' => null,
    ],
    'Site'  => [
        'title'    => 'Site',
        'icon'     => 'globe',
        'route'    => 'site.index',
        'auth'     => true,
        'admin'    => true,
        'hide-sub-menu' => true,
        'sub-menu' => [
            [
                'title' => 'Analytics',
                'icon' => 'tachometer-alt',
                'route' => 'site.analytics',
                'auth' => true,
                'admin' => true
            ],
            [
                'title' => 'Portfolio',
                'icon'  => 'briefcase',
                'route' => 'site.portfolio',
                'auth'  => true,
                'admin' => true,
            ],
        ],
    ]
];
