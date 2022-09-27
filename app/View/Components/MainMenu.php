<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainMenu extends Component
{

    public $menu;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * Menu array definition
         *
         *  'route name' => 'menu item label'
         */
        $this->menu = [
            'home' => [
                'title' => 'Overview',
                'icon' => 'fa-table-columns',
                'always_shown' => true,
                'show_notification_indicator' => false,
                'permissions' => ['']
            ],
            'analytics' => [
                'title' => 'Analytics',
                'icon' => 'fa-chart-bar',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permissions' => ['Can view Analytics page']
            ],
            'tickets' => [
                'title' => 'Tickets',
                'icon' => 'fa-ticket',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permissions' => ['Can view Tickets page']
            ],
            'kanban' => [
                'title' => 'Kanban Board',
                'icon' => 'fa-clipboard-check',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permissions' => ['Can view Kanban page']
            ],
            'administration' => [
                'title' => 'Administration',
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
                        'title' => 'Manage users',
                        'route' => 'administration.users',
                        'icon' => 'fa-users',
                        'always_shown' => false,
                        'permissions' => ['View all users', 'View company users']
                    ],
                    [
                        'title' => 'Manage companies',
                        'route' => 'administration.companies',
                        'icon' => 'fa-building',
                        'always_shown' => false,
                        'permissions' => ['View all companies', 'View own companies']
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
            'notifications' => [
                'title' => 'Notifications',
                'icon' => 'fa-bell',
                'always_shown' => true,
                'show_notification_indicator' => true,
                'permissions' => ['']
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.main-menu');
    }
}
