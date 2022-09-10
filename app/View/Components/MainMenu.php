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
         *  'route name' => 'menu item label'
         */
        $this->menu = [
            'home' => ['title' => 'Overview', 'icon' => 'fa-table-columns'],
            'analytics' => ['title' => 'Analytics', 'icon' => 'fa-chart-bar'],
            'chat' => ['title' => 'Chat', 'icon' => 'fa-comments'],
            'tickets' => ['title' => 'Tickets', 'icon' => 'fa-ticket'],
            'administration' => ['title' => 'Administration', 'icon' => 'fa-cogs'],
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
