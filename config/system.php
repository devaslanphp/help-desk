<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Statuses configuration
    |--------------------------------------------------------------------------
    |
    | This value is the configured statuses used by the application, you can
    | change it as you like, but be sure that your old data will not be
    | corrupted
    |
    | 'text-color' and 'bg-color' are tailwindcss based css classes
    | 'default' must be unique, and will be used to link the status to
    |           new created tickets
    |
    */
    'statuses' => [
        'created' => [
            'title' => 'Created',
            'text-color' => 'text-gray-500',
            'bg-color' => 'bg-color-100',
            'default' => true
        ],
        'in_progress' => [
            'title' => 'In progress',
            'text-color' => 'text-sky-500',
            'bg-color' => 'bg-sky-100',
            'default' => false
        ],
        'done' => [
            'title' => 'Created',
            'text-color' => 'text-orange-500',
            'bg-color' => 'bg-orange-100',
            'default' => false
        ],
        'validated' => [
            'title' => 'Created',
            'text-color' => 'text-green-500',
            'bg-color' => 'bg-green-100',
            'default' => false
        ],
        'rejected' => [
            'title' => 'Created',
            'text-color' => 'text-red-500',
            'bg-color' => 'bg-red-100',
            'default' => false
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Priorities configuration
    |--------------------------------------------------------------------------
    |
    | This value is the configured priorities used by the application, you can
    | change it as you like, but be sure that your old data will not be
    | corrupted
    |
    | 'text-color' and 'bg-color' are tailwindcss based css classes
    | 'icon' is a fontawesome based css class
    |
    */
    'priorities' => [
        'lowest' => [
            'title' => 'Created',
            'text-color' => 'text-green-500',
            'bg-color' => 'bg-green-100',
            'icon' => 'fa-arrow-down'
        ],
        'low' => [
            'title' => 'In progress',
            'text-color' => 'text-emerald-500',
            'bg-color' => 'bg-emerald-100',
            'icon' => 'fa-angle-down'
        ],
        'normal' => [
            'title' => 'Normal',
            'text-color' => 'text-gray-500',
            'bg-color' => 'bg-gray-100',
            'icon' => 'fa-minus'
        ],
        'high' => [
            'title' => 'High',
            'text-color' => 'text-orange-500',
            'bg-color' => 'bg-orange-100',
            'icon' => 'fa-arrow-up'
        ],
        'highest' => [
            'title' => 'Highest',
            'text-color' => 'text-red-500',
            'bg-color' => 'bg-red-100',
            'icon' => 'fa-arrow-up'
        ],
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
    | 'permissions' contains the rights to access "pages" and "functions"
    | 'pages' contains the pages accessible by the role
    |   -> Same declared in App\View\Components\MainMenu component)
    | 'functions' contains the functionnalities accessible by the role
    |
    | Available permissions:
    |   - Pages: analytics, chat, tickets, administration
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
    |
    */
    'roles' => [
        'administrator' => [
            'title' => 'Administrator',
            'text-color' => 'bg-red-50',
            'bg-color' => 'text-red-500',
            'permissions' => [
                'pages' => ['analytics', 'chat', 'tickets', 'administration'],
                'functions' => [
                    'view-all-projects', 'update-all-projects', 'delete-all-projects', 'create-projects',
                    'view-all-tickets', 'update-all-tickets', 'delete-all-tickets', 'create-tickets',
                    'view-all-users', 'manage-all-users', 'create-user'
                ]
            ]
        ],
        'employee' => [
            'title' => 'Employee',
            'text-color' => 'bg-gray-50',
            'bg-color' => 'text-gray-500',
            'permissions' => [
                'pages' => ['analytics', 'chat', 'tickets'],
                'functions' => [
                    'view-own-projects',
                    'view-own-tickets', 'update-own-tickets', 'delete-own-tickets', 'create-tickets'
                ]
            ]
        ],
        'customer' => [
            'title' => 'Customer',
            'text-color' => 'bg-blue-50',
            'bg-color' => 'text-blue-500',
            'permissions' => [
                'pages' => ['analytics', 'chat', 'tickets'],
                'functions' => [
                    'view-own-projects',
                    'view-own-tickets', 'update-own-tickets', 'delete-own-tickets', 'create-tickets'
                ]
            ]
        ],
    ],

];
