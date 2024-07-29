<?php

namespace App\Http\Livewire\Analytics;

use App\Models\Ticket;
use Livewire\Component;

class NoAssignedTickets extends Component
{
    public $notAssignedTickets;

    public function mount(): void
    {
        $this->loadNotAssignedTickets();
    }

    public function render()
    {
        return view('livewire.analytics.no-assigned-tickets');
    }

    /**
     * Load not assigned tickets
     *
     * @return void
     */
    private function loadNotAssignedTickets(): void
    {
        $this->notAssignedTickets = Ticket::whereNull('responsible_id')->get();
    }
}
