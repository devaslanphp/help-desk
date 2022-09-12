<?php

namespace App\Http\Livewire;

use App\Jobs\CommentCreatedJob;
use App\Jobs\TicketCreatedJob;
use App\Models\Comment;
use App\Models\Ticket;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;

class TicketDetailsComments extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $deleteConfirmationOpened = false;

    protected $listeners = ['commentCreated', 'doDeleteComment', 'cancelDeleteComment', 'commentDeleted'];

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

    /**
     * Event launched after a comment is deleted
     *
     * @return void
     */
    public function commentDeleted(): void
    {
        $this->ticket = $this->ticket->refresh();
    }

    /**
     * Event launched after a comment is created
     *
     * @return void
     */
    public function commentCreated(): void
    {
        $this->ticket = $this->ticket->refresh();
    }

    /**
     * Comment main function
     *
     * @return void
     */
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

    /**
     * Delete an existing comment
     *
     * @return void
     */
    public function doDeleteComment(Comment $comment): void {
        $comment->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('commentDeleted');
        Notification::make()
            ->success()
            ->title('Comment deleted')
            ->body(__('The comment has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a comment
     *
     * @return void
     */
    public function cancelDeleteComment(): void {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete comment confirmation dialog
     *
     * @param Comment $comment
     * @return void
     * @throws \Exception
     */
    public function deleteComment(Comment $comment): void {
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title('Comment deletion')
            ->body(__('Are you sure you want to delete this comment?'))
            ->actions([
                Action::make('confirm')
                    ->label(__('Confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteComment', ['comment' => $comment]),
                Action::make('cancel')
                    ->label(__('Cancel'))
                    ->close()
                    ->emit('cancelDeleteComment')
            ])
            ->persistent()
            ->send();
    }
}
