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
            'All tickets',
            'Unassigned',
            'Assigned to me',
        ];
        $this->activeMenu = $this->menu[0];
    }

    public function render()
    {
        return view('livewire.tickets');
    }

    /**
     * Change a menu (tab)
     *
     * @param $item
     * @return void
     */
    public function selectMenu($item)
    {
        $this->activeMenu = $item;
    }
}
