<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Livewire\Component;

class Analytics extends Component
{
    public $assignedTickets;
    public $notAssignedTickets;
    public $ticketsAssignments;
    public $ticketsByStatuses;

    public function mount(): void
    {
        $this->loadAssignedTickets();
        $this->loadNotAssignedTickets();
        $this->loadTicketsAssignments();
        $this->loadTicketsByStatuses();
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

    /**
     * Load tickets assignements
     *
     * @return void
     */
    private function loadTicketsAssignments(): void
    {
        $query = Ticket::query();
        if (auth()->user()->can('View own tickets') && !auth()->user()->can('View all tickets')) {
            $query->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('responsible_id', auth()->user()->id);
            });
        }
        $tickets = $query->get()->groupBy('responsible_id')->sort(function ($a, $b) {
            return ($a->first()->responsible_id ?? 0) > ($b->first()->responsibe_id ?? 0);
        });
        $this->ticketsAssignments = [];
        foreach ($tickets as $ticket) {
            $this->ticketsAssignments[$ticket->first()->responsible?->name ?? __('Unassigned')] = $ticket->count();
        }
    }

    /**
     * Load tickets by statuses
     *
     * @return void
     */
    private function loadTicketsByStatuses(): void
    {
        $query = Ticket::query();
        if (auth()->user()->can('View own tickets') && !auth()->user()->can('View all tickets')) {
            $query->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('responsible_id', auth()->user()->id);
            });
        }
        $tickets = $query->get()->groupBy('status');
        $this->ticketsByStatuses = [];
        $statuses = TicketStatus::all();
        foreach ($tickets as $ticket) {
            $status = $statuses->where('slug', $ticket->first()->status)->first();
            if ($status) {
                $this->ticketsByStatuses[$status->title] = $ticket->count();
            }
        }
    }
}
