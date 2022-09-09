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

];
