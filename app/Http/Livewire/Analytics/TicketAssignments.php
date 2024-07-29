<?php

namespace App\Http\Livewire\Analytics;

use Livewire\Component;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketAssignments extends Component
{
    public $startDateAssignment;
    public $endDateAssignment;
    public $labels = [];
    public $dataAssignment = [];
    public $ticketsAssignments = [];

    public function mount()
    {
        $this->startDateAssignment = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->endDateAssignment = Carbon::now()->month(4)->endOfMonth()->format('Y-m-d');
        $this->loadTicketsAssignments();
    }

    public function updated($property)
    {
        if (in_array($property, ['startDateAssignment', 'endDateAssignment'])) {
            $this->loadTicketsAssignments();
        }
    }

    public function loadTicketsAssignments(): void
    {
        $query = Ticket::query();

        if ($this->startDateAssignment && $this->endDateAssignment) {
            $query->whereBetween('created_at', [$this->startDateAssignment, $this->endDateAssignment]);
        }

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

    
        $this->labelAssignment = array_keys($this->ticketsAssignments);
        $this->dataAssignment = array_values($this->ticketsAssignments);

        $this->emit('updateChart', $this->labelAssignment, $this->dataAssignment);
    }

    public function render()
    {
        return view('livewire.analytics.ticket-assignments');
    }
}
