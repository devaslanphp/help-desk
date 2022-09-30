<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locales configuration
    |--------------------------------------------------------------------------
    |
    | This value is the configured locales that the application can use
    |
    */
    'locales' => [
        'en' => 'English',
        'fr' => 'Français'
    ],

    /*
    |--------------------------------------------------------------------------
    | Main menu configuration
    |--------------------------------------------------------------------------
    |
    | This value is the definition of the application main menu
    | Used in the 'App\View\Components\MainMenu' blade component
    |
    | Parameters:
    | -----------
    |   - 'title' The translatable title of the menu
    |
    |   - 'route' The menu route name
    |
    |   - 'icon' The Fontawesome icon class
    |           (icons list: http://fontawesome.io/icons/)
    |
    |   - 'always_shown' If equals to "true" the menu is always shown without
    |           checking permissions, if "false" the 'permissions' parameter
    |           is used to show or not the menu item
    |
    |   - 'show_notification_indicator' If equals to "true" the menu item will
    |           show an indicator if there is notifications not read
    |
    |   - 'permissions' The permissions used to show or not the menu item
    |
    |   - (Optional) 'children' The sub menu items
    |       - 'children.title' The translatable title of the sub menu
    |
    |       - 'children.route' The sub menu route name
    |
    |       - 'children.icon' The Fontawesome icon class
    |           (icons list: http://fontawesome.io/icons/)
    |
    |       - 'children.always_shown' If equals to "true" the menu is always
    |           shown without checking permissions, if "false"
    |           the 'permissions' parameter is used to show or not
    |           the menu item
    |
    |       - 'children.permissions' The permissions used to show or not
    |           the menu item
    |
    */
    'main_menu' => [
        [
            'title' => 'Overview',
            'route' => 'home',
            'icon' => 'fa-table-columns',
            'always_shown' => true,
            'show_notification_indicator' => false,
            'permissions' => ['']
        ],
        [
            'title' => 'Analytics',
            'route' => 'analytics',
            'icon' => 'fa-chart-bar',
            'always_shown' => false,
            'show_notification_indicator' => false,
            'permissions' => ['Can view Analytics page']
        ],
        [
            'title' => 'Tickets',
            'route' => 'tickets',
            'icon' => 'fa-ticket',
            'always_shown' => false,
            'show_notification_indicator' => false,
            'permissions' => ['Can view Tickets page']
        ],
        [
            'title' => 'Kanban Board',
            'route' => 'kanban',
            'icon' => 'fa-clipboard-check',
            'always_shown' => false,
            'show_notification_indicator' => false,
            'permissions' => ['Can view Kanban page']
        ],
        [
            'title' => 'Administration',
            'route' => 'administration',
            'icon' => 'fa-cogs',
            'always_shown' => false,
            'show_notification_indicator' => false,
            'permissions' => [
                'View all users', 'View company users',
                'View all companies', 'View own companies',
                'Manage ticket statuses',
                'Manage ticket types',
                'Manage ticket priorities',
                'View activity log'
            ],
            'children' => [
                [
                    'title' => 'Manage companies',
                    'route' => 'administration.companies',
                    'icon' => 'fa-building',
                    'always_shown' => false,
                    'permissions' => ['View all companies', 'View own companies']
                ],
                [
                    'title' => 'Manage users',
                    'route' => 'administration.users',
                    'icon' => 'fa-users',
                    'always_shown' => false,
                    'permissions' => ['View all users', 'View company users']
                ],
                [
                    'title' => 'Manage user roles',
                    'route' => 'administration.roles',
                    'icon' => 'fa-user-lock',
                    'always_shown' => false,
                    'permissions' => ['Manage user roles']
                ],
                [
                    'title' => 'Manage statuses',
                    'route' => 'administration.ticket-statuses',
                    'icon' => 'fa-square-check',
                    'always_shown' => false,
                    'permissions' => ['Manage ticket statuses']
                ],
                [
                    'title' => 'Manage types',
                    'route' => 'administration.ticket-types',
                    'icon' => 'fa-copy',
                    'always_shown' => false,
                    'permissions' => ['Manage ticket types']
                ],
                [
                    'title' => 'Manage priorities',
                    'route' => 'administration.ticket-priorities',
                    'icon' => 'fa-arrow-up',
                    'always_shown' => false,
                    'permissions' => ['Manage ticket priorities']
                ],
                [
                    'title' => 'Activity logs',
                    'route' => 'administration.activity-logs',
                    'icon' => 'fa-bell',
                    'always_shown' => false,
                    'permissions' => ['View activity log']
                ]
            ]
        ],
        [
            'title' => 'Notifications',
            'route' => 'notifications',
            'icon' => 'fa-bell',
            'always_shown' => true,
            'show_notification_indicator' => true,
            'permissions' => ['']
        ],
    ],

];
