<?php

namespace App\Http\Livewire\TicketDetails;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Responsible extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    public function mount(): void
    {
        $this->form->fill([
            'responsible_id' => $this->ticket->responsible_id
        ]);
    }

    public function render()
    {
        return view('livewire.ticket-details.responsible');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('responsible_id')
                ->label(__('Responsible'))
                ->disableLabel()
                ->placeholder(__('Responsible'))
                ->options(User::all()->pluck('name', 'id')->toArray())
                ->required()
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
        $before = $this->ticket->responsible?->name ?? '-';
        $this->ticket->responsible_id = $data['responsible_id'];
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Responsible updated'))
            ->body(__('The ticket responsible has been successfully updated'))
            ->send();
        $this->form->fill([
            'responsible_id' => $this->ticket->responsible_id
        ]);
        $this->updating = false;
        $this->ticket = $this->ticket->refresh();
        $this->emit('ticketSaved');
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Responsible'),
            $before,
            ($this->ticket->responsible?->name ?? '-'),
            auth()->user()
        );
    }

    /**
     * Assign ticket to the authenticated user
     *
     * @return void
     */
    public function assignToMe(): void
    {
        $this->form->fill([
            'responsible_id' => auth()->user()->id
        ]);
        $this->save();
    }
}
