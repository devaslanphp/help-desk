<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CommentCreateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Comment $comment;
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(__('We inform you that a new comment has been added to the ticket :ticket in the platform :platform.', [
                'platform' => config('app.name'),
                'ticket' => $this->comment->ticket->title
            ]))
            ->line(__('Below are the details of this comment:'))
            ->line(__('- Owner: :owner', ['owner' => $this->comment->owner->name]))
            ->line(__('- Content: :content', ['content' => htmlspecialchars(strip_tags($this->comment->content))]))
            ->action(
                __('Ticket details'),
                route('tickets.details', [
                        'ticket' => $this->comment->ticket,
                        'slug' => Str::slug($this->comment->ticket->title)
                    ]
                )
            )
            ->line(__('Thank you for using our application!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket' => $this->comment->ticket,
            'comment' => $this->comment,
            'user' => $this->user,
        ];
    }
}
