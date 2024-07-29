<?php

namespace App\View\Components;

use App\Models\TicketType;
use Illuminate\View\Component;

class TypeSpan extends Component
{
    public $type;
    public $min;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $min = false)
    {
        $this->type = TicketType::where('slug', $type)->first();
        $this->min = $min;
        if($type == "Select new type"){
            $this->type = "Select new type";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.type-span');
    }
}
