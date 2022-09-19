<?php

namespace App\Http\Livewire\TicketDetails;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Title extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->ticket->title
        ]);
    }

    public function render()
    {
        return view('livewire.ticket-details.title');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label(__('Title'))
                ->disableLabel()
                ->placeholder(__('Title'))
                ->maxLength(255)
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
        $before = $this->ticket->title;
        $this->ticket->title = $data['title'];
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Title updated'))
            ->body(__('The ticket title has been successfully updated'))
            ->send();
        $this->form->fill([
            'title' => $this->ticket->title
        ]);
        $this->updating = false;
        $this->emit('ticketSaved');
        TicketUpdatedJob::dispatch($this->ticket, __('Title'), $before, $this->ticket->title, auth()->user());
    }
}
