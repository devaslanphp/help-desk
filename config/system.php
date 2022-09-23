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
    | Users statuses configuration
    |--------------------------------------------------------------------------
    |
    | This value is the configured roles assigned to users while creating /
    | updating them, you can change it as you like
    |
    | 'text-color' and 'bg-color' are tailwindcss based css classes
    | 'badge-color' uses the colors defined on 'tailwind.config.js'
    | 'permissions' contains the rights to access "pages" and "functions"
    | 'pages' contains the pages accessible by the role
    |   -> Same declared in App\View\Components\MainMenu component)
    | 'functions' contains the functionnalities accessible by the role
    |
    | Available permissions:
    |   - Pages: analytics, tickets, administration
    |   - Functions:
    |       - view-all-projects: View all configured projects
    |       - update-all-projects: Update all configured projects
    |       - delete-all-projects: Delete all configured projects
    |       - create-projects: Create a new project
    |       - view-own-projects: View assigned projects
    |       - update-own-projects: Update assigned projects
    |       - delete-own-projects: Delete assigned projects
    |       - view-all-tickets: View all configured tickets
    |       - update-all-tickets: Update all configured tickets
    |       - delete-all-tickets: Delete all configured tickets
    |       - create-tickets: Create a new ticket
    |       - view-own-tickets: View assigned tickets
    |       - update-own-tickets: Update assigned tickets
    |       - delete-own-tickets: Delete assigned tickets
    |       - assign-tickets: Assign tickets to responsibles
    |       - change-status-tickets: Change tickets status
    |
    */
    'roles' => [
        'administrator' => [
            'title' => 'Administrator',
            'text-color' => 'bg-red-50',
            'bg-color' => 'text-red-500',
            'badge-color' => 'danger',
            'permissions' => [
                'pages' => ['analytics', 'tickets', 'kanban', 'administration'],
                'functions' => [
                    'view-all-projects', 'update-all-projects', 'delete-all-projects', 'create-projects',
                    'view-all-tickets', 'update-all-tickets', 'delete-all-tickets', 'create-tickets', 'assign-tickets', 'change-status-tickets'
                ]
            ]
        ],
        'employee' => [
            'title' => 'Employee',
            'text-color' => 'bg-gray-50',
            'bg-color' => 'text-gray-500',
            'badge-color' => 'warning',
            'permissions' => [
                'pages' => ['analytics', 'tickets', 'kanban'],
                'functions' => [
                    'view-own-projects',
                    'view-own-tickets', 'update-own-tickets', 'delete-own-tickets', 'create-tickets', 'assign-tickets', 'change-status-tickets'
                ]
            ]
        ],
        'customer' => [
            'title' => 'Customer',
            'text-color' => 'bg-blue-50',
            'bg-color' => 'text-blue-500',
            'badge-color' => 'primary',
            'permissions' => [
                'pages' => ['analytics', 'tickets', 'kanban'],
                'functions' => [
                    'view-own-projects',
                    'view-own-tickets', 'update-own-tickets', 'delete-own-tickets', 'create-tickets'
                ]
            ]
        ],
    ],

];
