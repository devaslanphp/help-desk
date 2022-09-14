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
                'show_notification_indicator' => false
            ],
            'analytics' => [
                'title' => 'Analytics',
                'icon' => 'fa-chart-bar',
                'always_shown' => false,
                'show_notification_indicator' => false
            ],
            'tickets' => [
                'title' => 'Tickets',
                'icon' => 'fa-ticket',
                'always_shown' => false,
                'show_notification_indicator' => false
            ],
            'administration' => [
                'title' => 'Administration',
                'icon' => 'fa-cogs',
                'always_shown' => false,
                'show_notification_indicator' => false
            ],
            'notifications' => [
                'title' => 'Notifications',
                'icon' => 'fa-bell',
                'always_shown' => true,
                'show_notification_indicator' => true
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
