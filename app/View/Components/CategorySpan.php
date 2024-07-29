<?php

namespace App\View\Components;

use App\Models\TicketCategory;
use Illuminate\View\Component;

class CategorySpan extends Component
{
    public $category;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->category = TicketCategory::where('slug', $category)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.category-span');
    }
}