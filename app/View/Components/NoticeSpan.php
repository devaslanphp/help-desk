<?php

namespace App\View\Components;

use App\Models\Notice;
use Illuminate\View\Component;

class NoticeSpan extends Component
{
    public $notice;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notice)
    {
        $this->notice = Notice::where('slug', $notice)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notice-span');
    }
}