<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketType;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class TicketTypes extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;
    public $selectedType;

    protected $listeners = ['typeSaved', 'typeDeleted'];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $query = TicketType::query();
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('text_color', 'like', '%' . $this->search . '%')
                ->orWhere('bg_color', 'like', '%' . $this->search . '%')
                ->orWhere('icon', 'like', '%' . $this->search . '%');
        }
        $types = $query->paginate();
        return view('livewire.administration.ticket-types', compact('types'));
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
                        ->label(__('Search for tickets types'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for tickets types')),
                ]),
        ];
    }

    /**
     * Search for tickets statutses
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

    /**
     * Show update type dialog
     *
     * @param $id
     * @return void
     */
    public function updateType($id)
    {
        $this->selectedType = TicketType::find($id);
        $this->dispatchBrowserEvent('toggleTypeModal');
    }

    /**
     * Show create type dialog
     *
     * @return void
     */
    public function createType()
    {
        $this->selectedType = new TicketType();
        $this->dispatchBrowserEvent('toggleTypeModal');
    }

    /**
     * Cancel and close type create / update dialog
     *
     * @return void
     */
    public function cancelType()
    {
        $this->selectedType = null;
        $this->dispatchBrowserEvent('toggleTypeModal');
    }

    /**
     * Event launched after a type is created / updated
     *
     * @return void
     */
    public function typeSaved() {
        $this->search();
        $this->cancelType();
    }

    /**
     * Event launched after a type is deleted
     *
     * @return void
     */
    public function typeDeleted() {
        $this->typeSaved();
    }
}

