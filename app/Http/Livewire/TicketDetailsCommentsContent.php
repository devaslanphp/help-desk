<?php

namespace App\Http\Livewire;

use App\Jobs\CommentCreatedJob;
use App\Models\Comment;
use App\Models\Ticket;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;

class TicketDetailsCommentsContent extends Component implements HasForms
{
    use InteractsWithForms;

    public Comment|null $selectedComment;
    public Ticket $ticket;
    public bool $updating = false;
    public bool $deleteConfirmationOpened = false;

    protected $listeners = [
        'doDeleteComment',
        'cancelDeleteComment',
        'commentCreated',
        'commentDeleted',
        'commentSaved'
    ];

    public function mount(): void
    {
        $this->selectedComment = null;
        $this->form->fill([
            'content' => $this->selectedComment?->content
        ]);
    }

    public function render()
    {
        return view('livewire.ticket-details-comments-content');
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
                ->label(__('Update your comment...'))
                ->disableLabel()
                ->placeholder(__('Update your comment...'))
                ->required()
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('comments')
                ->fileAttachmentsVisibility('private'),
        ];
    }

    /**
     * Launch the update function
     *
     * @param int $comment
     * @return void
     */
    public function updateComment(int $comment): void
    {
        $this->selectedComment = Comment::where('id', $comment)->first();
        $this->form->fill([
            'content' => $this->selectedComment->content
        ]);
        $this->updating = true;
    }

    /**
     * Comment main function
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $this->selectedComment->content = $data['content'];
        $this->selectedComment->save();
        $this->form->fill([
            'content' => $this->selectedComment->content
        ]);
        $this->emit('commentSaved');
        $this->updating = false;
        Notification::make()
            ->success()
            ->title(__('Comment updated'))
            ->body(__('The comment has been updated'))
            ->send();
    }

    /**
     * Delete an existing comment
     *
     * @param int $commentId
     * @return void
     */
    public function doDeleteComment(int $commentId): void
    {
        if ($commentId === $this->selectedComment->id) {
            $this->selectedComment->delete();
            $this->deleteConfirmationOpened = false;
            $this->emit('commentDeleted');
            Notification::make()
                ->success()
                ->title(__('Comment deleted'))
                ->body(__('The comment has been deleted'))
                ->send();
        }
    }

    /**
     * Cancel the deletion of a comment
     *
     * @return void
     */
    public function cancelDeleteComment(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete comment confirmation dialog
     *
     * @param Comment $comment
     * @return void
     * @throws \Exception
     */
    public function deleteComment(Comment $comment): void
    {
        $this->selectedComment = $comment;
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title(__('Comment deletion'))
            ->body(__('Are you sure you want to delete this comment?'))
            ->actions([
                Action::make('confirm')
                    ->label(__('Confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteComment', ['comment' => $comment->id]),
                Action::make('cancel')
                    ->label(__('Cancel'))
                    ->close()
                    ->emit('cancelDeleteComment')
            ])
            ->persistent()
            ->send();
    }

    /**
     * Event launched after a comment is deleted
     *
     * @return void
     */
    public function commentDeleted(): void
    {
        $this->commentCreated();
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
     * Event launched after a comment is updated
     *
     * @return void
     */
    public function commentSaved(): void
    {
        $this->commentCreated();
    }
}
