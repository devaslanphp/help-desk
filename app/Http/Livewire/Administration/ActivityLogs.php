<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketPriority;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLogs extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $query = Activity::query();
        $query->orderby('created_at', 'desc');
        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }
        $logs = $query->paginate();
        return view('livewire.administration.activity-logs', compact('logs'));
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Grid::make(1)
                ->schema([
                    TextInput::make('search')
                        ->label(__('Search for activity logs'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for activity logs')),
                ]),
        ];
    }

    /**
     * Search for activity logs
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

}
