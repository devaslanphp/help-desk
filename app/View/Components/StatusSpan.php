<?php

namespace App\View\Components;

use App\Models\TicketStatus;
use Illuminate\View\Component;

class StatusSpan extends Component
{
    public $status;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = TicketStatus::where('slug', $status)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.status-span');
    }
}
