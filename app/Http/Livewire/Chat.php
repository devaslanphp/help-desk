<?php

namespace App\Http\Livewire;

use App\Models\Chat as Model;
use App\Models\Ticket;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Chat extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $messages = Model::where('ticket_id', $this->ticket->id)->get();
        return view('livewire.chat', compact('messages'));
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            RichEditor::make('message')
                ->label(__('Type a message..'))
                ->disableLabel()
                ->placeholder(__('Type a message..'))
                ->required()
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('chat')
                ->fileAttachmentsVisibility('private'),
        ];
    }

    /**
     * Send a message
     *
     * @return void
     */
    public function send(): void
    {
        $data = $this->form->getState();
        Model::create([
            'message' => $data['message'],
            'user_id' => auth()->user()->id,
            'ticket_id' => $this->ticket->id
        ]);
        $this->form->fill();
    }
}
