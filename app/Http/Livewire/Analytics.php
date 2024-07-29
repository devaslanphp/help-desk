<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Models\TicketStatus;
use Livewire\Component;

class Analytics extends Component
{
    
    
    public $assignedTickets;
    public $notAssignedTickets;

    public $startDate;
    public $endDate;

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();

        $this->loadAssignedTickets();
        $this->loadNotAssignedTickets();
    }

    public function render()
    {
        return view('livewire.analytics');
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
