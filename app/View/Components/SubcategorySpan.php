<?php

namespace App\View\Components;

use App\Models\TicketCategory;
use Illuminate\View\Component;

class SubcategorySpan extends Component
{
    public $subcategory;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($subcategory)
    {
        $this->subcategory = TicketCategory::where('slug', $subcategory)->first();
        if($subcategory == "Select new subcategory"){
            $this->subcategory = "Select new subcategory";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.subcategory-span');
    }
}