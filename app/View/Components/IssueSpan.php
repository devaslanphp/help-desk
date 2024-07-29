<?php

namespace App\View\Components;

use App\Models\TicketCategory;
use Illuminate\View\Component;

class IssueSpan extends Component
{
    public $issue;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($issue)
    {
        $this->issue = TicketCategory::where('slug', $issue)->first();
        if($issue == "Select new issue"){
            $this->issue = "Select new issue";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.issue-span');
    }
}