<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotificationType extends Component
{
    public $notification;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-type');
    }
}
