<?php

namespace App\Http\Livewire\Analytics;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Ticket;

class TicketTrend extends Component
{
    public $startDate;
    public $endDate;
    public $ticketCreationData = [];
    public $pendingTicketData = [];
    public $closedTicketData = [];
    public $labels = [];
    public $totalCreated = 0;
    public $totalClosed = 0;
    public $totalPending = 0;

    public function month($month)
    {
        $this->startDate = Carbon::now()->day(1)->month($month)->format('Y-m-d');
        $this->endDate = Carbon::now()->day(1)->month($month)->endOfMonth()->format('Y-m-d');
        $this->fetchData();
    }

    public function mount()
    {
        // Set default dates
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->fetchData();
    }

    public function updated($property)
    {
        if (in_array($property, ['startDate', 'endDate'])) {
            $this->fetchData();
        }
    }

    public function fetchData()
    {
        $tickets = Ticket::select('created_at', 'inprogress_at', 'closed_at')
                         ->whereBetween('created_at', [$this->startDate, $this->endDate])
                         ->get();

        $this->ticketCreationData = [];
        $this->pendingTicketData = [];
        $this->closedTicketData = [];
        $this->labels = [];

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $this->labels[] = $dateString;

            $this->ticketCreationData[] = $tickets->filter(function($ticket) use ($dateString) {
                return Carbon::parse($ticket->created_at)->format('Y-m-d') == $dateString;
            })->count();

            // $this->pendingTicketData[] = $tickets->filter(function($ticket) use ($dateString) {
            //     $createdDate = Carbon::parse($ticket->created_at);
            //     $closedDate = $ticket->closed_at ? Carbon::parse($ticket->closed_at) : null;
            //     return $createdDate->lte($dateString) && (!$closedDate || $closedDate->gt($dateString));            
            // })->count();

            //pendingTicketData is counted on the same day the ticket is created and reduces one day after the ticket is closed.
            $this->pendingTicketData[] = $tickets->filter(function($ticket) use ($dateString) {
                $createdDate = Carbon::parse($ticket->created_at)->format('Y-m-d');
                $closedDate = $ticket->closed_at ? Carbon::parse($ticket->closed_at)->addDay()->format('Y-m-d') : null;
                return $createdDate <= $dateString && (!$closedDate || $dateString < $closedDate);
            })->count();    

            $this->closedTicketData[] = $tickets->filter(function($ticket) use ($dateString) {
                return $ticket->closed_at && Carbon::parse($ticket->closed_at)->format('Y-m-d') == $dateString;
            })->count();

        }

        // Ensure arrays are sorted by date
        ksort($this->ticketCreationData);
        ksort($this->pendingTicketData);
        ksort($this->closedTicketData);
        $this->ticketCreationData = array_values($this->ticketCreationData);
        $this->pendingTicketData = array_values($this->pendingTicketData);
        $this->closedTicketData = array_values($this->closedTicketData);

        // Calculate totals
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        // Convert date strings to DateTime objects
        $startDate = new \DateTime($this->startDate);
        $endDate = new \DateTime($this->endDate);

        // Initialize totals
        $totalCreated = 0;
        $totalClosed = 0;

        // Iterate through data to calculate totals
        foreach ($this->labels as $index => $label) {
            $date = new \DateTime($label);

            // Check if the date is within the selected range
            if ($date >= $startDate && $date <= $endDate) {
                $totalCreated += $this->ticketCreationData[$index];
                $totalClosed += $this->closedTicketData[$index];
            }
        }

        // Calculate pending tickets
        $totalPending = $totalCreated - $totalClosed;

        // Pass totals to the view
        $this->totalCreated = $totalCreated;
        $this->totalClosed = $totalClosed;
        $this->totalPending = $totalPending;
    }

    public function render()
    {
        return view('livewire.analytics.ticket-trend', [
            'ticketCreationData' => $this->ticketCreationData,
            'pendingTicketData' => $this->pendingTicketData,
            'closedTicketData' => $this->closedTicketData,
            'labels' => $this->labels,
            'totalCreated' => $this->totalCreated,
            'totalClosed' => $this->totalClosed,
            'totalPending' => $this->totalPending,
        ]);
    }
}
