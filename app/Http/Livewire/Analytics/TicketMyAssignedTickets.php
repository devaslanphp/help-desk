<?php

namespace App\Http\Livewire\Analytics;

use App\Models\Ticket;
use Livewire\Component;

class TicketMyAssignedTickets extends Component
{
    public $notAssignedTickets;
    public $assignedTickets;

    public function mount(): void
    {
        $this->loadNotAssignedTickets();
        $this->loadAssignedTickets();
    }

    public function render()
    {
        return view('livewire.analytics.ticket-my-assigned-tickets');
    }

    /**
     * Load authenticated user assigned tickets
     *
     * @return void
     */
    private function loadAssignedTickets(): void
    {
        $this->assignedTickets = Ticket::where('responsible_id', auth()->user()->id)->get();
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
