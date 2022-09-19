<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketStatus;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class TicketStatuses extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;
    public $selectedStatus;

    protected $listeners = ['statusSaved', 'statusDeleted'];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $query = TicketStatus::query();
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('text_color', 'like', '%' . $this->search . '%')
                ->orWhere('bg_color', 'like', '%' . $this->search . '%');
        }
        $statuses = $query->paginate();
        return view('livewire.administration.ticket-statuses', compact('statuses'));
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
                        ->label(__('Search for tickets statuses'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for tickets statuses')),
                ]),
        ];
    }

    /**
     * Search for tickets statuses
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

    /**
     * Show update status dialog
     *
     * @param $id
     * @return void
     */
    public function updateStatus($id)
    {
        $this->selectedStatus = TicketStatus::find($id);
        $this->dispatchBrowserEvent('toggleStatusModal');
    }

    /**
     * Show create status dialog
     *
     * @return void
     */
    public function createStatus()
    {
        $this->selectedStatus = new TicketStatus();
        $this->dispatchBrowserEvent('toggleStatusModal');
    }

    /**
     * Cancel and close status create / update dialog
     *
     * @return void
     */
    public function cancelStatus()
    {
        $this->selectedStatus = null;
        $this->dispatchBrowserEvent('toggleStatusModal');
    }

    /**
     * Event launched after a status is created / updated
     *
     * @return void
     */
    public function statusSaved() {
        $this->search();
        $this->cancelStatus();
    }

    /**
     * Event launched after a status is deleted
     *
     * @return void
     */
    public function statusDeleted() {
        $this->statusSaved();
    }
}
