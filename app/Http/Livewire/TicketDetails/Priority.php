<?php

namespace App\Http\Livewire\TicketDetails;

use App\Models\Ticket;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Priority extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    public function mount(): void
    {
        $this->form->fill([
            'priority' => $this->ticket->priority
        ]);
    }

    public function render()
    {
        return view('livewire.ticket-details.priority');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('priority')
                ->label(__('Priority'))
                ->required()
                ->searchable()
                ->disableLabel()
                ->placeholder(__('Priority'))
                ->options(priorities_list()),
        ];
    }

    /**
     * Enable updating
     *
     * @return void
     */
    public function update(): void
    {
        $this->updating = true;
    }

    /**
     * Save main function
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $this->ticket->priority = $data['priority'];
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title('Priority updated')
            ->body(__('The ticket priority has been successfully updated'))
            ->send();
        $this->form->fill([
            'priority' => $this->ticket->priority
        ]);
        $this->updating = false;
        $this->emit('ticketSaved');
    }
}
