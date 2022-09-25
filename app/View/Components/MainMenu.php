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
                'permission' => ''
            ],
            'analytics' => [
                'title' => 'Analytics',
                'icon' => 'fa-chart-bar',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permission' => 'Can view Analytics page'
            ],
            'tickets' => [
                'title' => 'Tickets',
                'icon' => 'fa-ticket',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permission' => 'Can view Tickets page'
            ],
            'kanban' => [
                'title' => 'Kanban Board',
                'icon' => 'fa-clipboard-check',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permission' => 'Can view Kanban page'
            ],
            'administration' => [
                'title' => 'Administration',
                'icon' => 'fa-cogs',
                'always_shown' => false,
                'show_notification_indicator' => false,
                'permission' => 'Can view Administration page'
            ],
            'notifications' => [
                'title' => 'Notifications',
                'icon' => 'fa-bell',
                'always_shown' => true,
                'show_notification_indicator' => true,
                'permission' => ''
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
