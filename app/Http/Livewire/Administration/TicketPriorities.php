<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketPriority;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class TicketPriorities extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;
    public $selectedPriority;

    protected $listeners = ['prioritySaved', 'priorityDeleted'];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $query = TicketPriority::query();
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('text_color', 'like', '%' . $this->search . '%')
                ->orWhere('bg_color', 'like', '%' . $this->search . '%')
                ->orWhere('icon', 'like', '%' . $this->search . '%');
        }
        $priorities = $query->paginate();
        return view('livewire.administration.ticket-priorities', compact('priorities'));
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
                        ->label(__('Search for tickets priorities'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for tickets priorities')),
                ]),
        ];
    }

    /**
     * Search for tickets priorities
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

    /**
     * Show update priority dialog
     *
     * @param $id
     * @return void
     */
    public function updatePriority($id)
    {
        $this->selectedPriority = TicketPriority::find($id);
        $this->dispatchBrowserEvent('togglePriorityModal');
    }

    /**
     * Show create priority dialog
     *
     * @return void
     */
    public function createPriority()
    {
        $this->selectedPriority = new TicketPriority();
        $this->dispatchBrowserEvent('togglePriorityModal');
    }

    /**
     * Cancel and close priority create / update dialog
     *
     * @return void
     */
    public function cancelPriority()
    {
        $this->selectedPriority = null;
        $this->dispatchBrowserEvent('togglePriorityModal');
    }

    /**
     * Event launched after a priority is created / updated
     *
     * @return void
     */
    public function prioritySaved() {
        $this->search();
        $this->cancelPriority();
    }

    /**
     * Event launched after a priority is deleted
     *
     * @return void
     */
    public function priorityDeleted() {
        $this->prioritySaved();
    }
}
