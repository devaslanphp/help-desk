<?php

namespace App\View\Components;

use App\Models\TicketPriority;
use Illuminate\View\Component;

class PrioritySpan extends Component
{
    public $priority;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($priority)
    {
        $this->priority = TicketPriority::where('slug', $priority)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.priority-span');
    }
}
