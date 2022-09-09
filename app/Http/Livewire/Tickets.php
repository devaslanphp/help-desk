<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tickets extends Component
{
    public $menu;
    public $activeMenu;

    public function mount()
    {
        $this->menu = [
            'Unassigned',
            'Assigned to me',
            'All tickets',
        ];
        $this->activeMenu = $this->menu[0];
    }

    public function render()
    {
        return view('livewire.tickets');
    }

    public function selectMenu($item)
    {
        $this->activeMenu = $item;
    }
}
