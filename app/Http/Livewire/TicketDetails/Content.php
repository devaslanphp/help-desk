<?php

namespace App\Http\Livewire\TicketDetails;

use App\Models\Ticket;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Content extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    public function mount(): void
    {
        $this->form->fill([
            'content' => $this->ticket->content
        ]);
    }

    public function render()
    {
        return view('livewire.ticket-details.content');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            RichEditor::make('content')
                ->label(__('Content'))
                ->disableLabel()
                ->placeholder(__('Content'))
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('tickets')
                ->fileAttachmentsVisibility('private'),
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
        $this->ticket->content = $data['content'];
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title('Content updated')
            ->body(__('The ticket content has been successfully updated'))
            ->send();
        $this->form->fill([
            'content' => $this->ticket->content
        ]);
        $this->updating = false;
        $this->emit('ticketSaved');
    }
}
