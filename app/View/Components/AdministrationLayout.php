<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdministrationLayout extends Component
{

    public $menu;

    public function __construct()
    {
        $this->menu = [
            [
                'title' => __('Manage users'),
                'route' => 'administration.users',
                'permissions' => ['View all users', 'View company users']
            ],
            [
                'title' => __('Manage companies'),
                'route' => 'administration.companies',
                'permissions' => ['View all companies', 'View own companies']
            ],
            [
                'title' => __('Manage statuses'),
                'route' => 'administration.ticket-statuses',
                'permissions' => ['Manage ticket statuses']
            ],
            [
                'title' => __('Manage types'),
                'route' => 'administration.ticket-types',
                'permissions' => ['Manage ticket types']
            ],
            [
                'title' => __('Activity logs'),
                'route' => 'administration.activity-logs',
                'permissions' => ['View activity log']
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
        return view('components.administration-layout');
    }
}
