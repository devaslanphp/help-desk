<?php

namespace App\Http\Livewire\TicketDetails;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Status extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    public function mount(): void
    {
        $this->form->fill([
            'status' => $this->ticket->status
        ]);
    }

    public function render()
    {
        return view('livewire.ticket-details.status');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('status')
                ->label(__('Status'))
                ->disableLabel()
                ->placeholder(__('Status'))
                ->required()
                ->searchable()
                ->options(statuses_list()),
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
        $before = __(config('system.statuses.' . $this->ticket->status . '.title')) ?? '-';
        $this->ticket->status = $data['status'];
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Status updated'))
            ->body(__('The ticket status has been successfully updated'))
            ->send();
        $this->form->fill([
            'status' => $this->ticket->status
        ]);
        $this->updating = false;
        $this->emit('ticketSaved');
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Status'),
            $before,
            __(config('system.statuses.' . $this->ticket->status . '.title') ?? '-'),
            auth()->user()
        );
    }
}
