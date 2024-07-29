<?php

namespace App\Http\Livewire\Analytics;

use Livewire\Component;
use App\Models\Ticket;
use Carbon\Carbon;

class DatePicker extends Component
{
    public $startDate;
    public $endDate;
    public $chartData;

    public function setJanuary(){
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->loadChartData();
    }

    public function mount()
    {
        // Set default date range (e.g., the past 30 days)
        // $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->loadChartData();
    }

    public function render()
    {
        return view('livewire.analytics.date-picker');
    }

    public function loadChartData()
    {
        $tickets = Ticket::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();

        // $this->chartData = [
        //     'labels' => $tickets->pluck('date')->toArray(),
        //     'data' => $tickets->pluck('count')->toArray(),
        // ];

        $this->chartData = array_map(function ($ticket) {
            return (array) $ticket;
        }, $tickets);

        $this->emit('chartDataUpdated', $this->chartData);
    }

    public function updated($propertyName)
    {
        // Re-load chart data when the date range is updated
        if ($propertyName === 'startDate' || $propertyName === 'endDate') {
            $this->loadChartData();
        }
    }
}
