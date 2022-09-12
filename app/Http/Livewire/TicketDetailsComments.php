<?php

namespace App\Http\Livewire;

use App\Jobs\CommentCreatedJob;
use App\Jobs\TicketCreatedJob;
use App\Models\Comment;
use App\Models\Ticket;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class TicketDetailsComments extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;

    protected $listeners = ['commentCreated'];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.ticket-details-comments');
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
                ->label(__('Type a new comment...'))
                ->disableLabel()
                ->placeholder(__('Type a new comment...'))
                ->required()
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('comments')
                ->fileAttachmentsVisibility('private'),
        ];
    }

    public function commentCreated(): void
    {
        $this->ticket = $this->ticket->refresh();
    }

    public function comment(): void
    {
        $data = $this->form->getState();
        $comment = Comment::create([
            'content' => $data['content'],
            'owner_id' => auth()->user()->id,
            'ticket_id' => $this->ticket->id
        ]);
        Notification::make()
            ->success()
            ->title('Comment created')
            ->body(__('Your comment has been successfully added to the ticket'))
            ->send();
        $this->form->fill();
        $this->emit('commentCreated');
        CommentCreatedJob::dispatch($comment);
    }
}
