<?php

namespace App\Http\Livewire\Analytics;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Livewire\Component;

class TicketStatuses extends Component
{
    public $ticketsByStatuses = [];
    public $statusColors = [];
    public $selectedMonth;

    public function mount(): void
    {
        // Set the default selected month to the current month
        $this->selectedMonth = Carbon::now()->format('Y-m');
        $this->loadTicketsByStatuses();
    }

    public function render()
    {
        return view('livewire.analytics.ticket-statuses', [
            'ticketsByStatuses' => $this->ticketsByStatuses,
            'statusColors' => $this->statusColors,
            'selectedMonth' => $this->selectedMonth,
        ]);
    }

    public function updatedSelectedMonth(): void
    {
        $this->loadTicketsByStatuses();
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

        // Filter by the selected month
        $query->whereYear('created_at', Carbon::parse($this->selectedMonth)->year)
              ->whereMonth('created_at', Carbon::parse($this->selectedMonth)->month);
              
        $tickets = $query->get()->groupBy('status');
        $this->ticketsByStatuses = [];
        $statuses = TicketStatus::all();

        foreach ($statuses as $status) {
            if($status->title != 'Open'){
                $this->ticketsByStatuses[$status->title] = $tickets->get($status->slug, collect())->count();
                $this->statusColors[$status->title] = $status->bg_color ?? 'rgba(0, 0, 0, 0.1)'; // Default color if not found
            }else{
                $this->ticketsByStatuses[$status->title] = $query->count();
                $this->statusColors[$status->title] = $status->bg_color ?? 'rgba(0, 0, 0, 0.1)'; // Default color if not found
            }
        }
        
    }
}
