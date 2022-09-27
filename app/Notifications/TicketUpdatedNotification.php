<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TicketUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Ticket $ticket;
    private string $field;
    private string $before;
    private string $after;
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, string $field, string $before, string $after, User $user)
    {
        $this->ticket = $ticket;
        $this->field = $field;
        $this->before = $before;
        $this->after = $after;
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
            ->line(__('We inform you that the ticket :ticket has been updated.', [
                'ticket' => $this->ticket->title
            ]))
            ->line(__('Below are the details of this modification:'))
            ->line(__('- Field: :field', ['field' => $this->field]))
            ->line(__('- Old value: :oldValue', ['oldValue' => $this->before]))
            ->line(__('- New value: :newValue', ['newValue' => $this->after]))
            ->action(
                __('Ticket details'),
                route(
                    'tickets.details',
                    [
                        'ticket' => $this->ticket,
                        'slug' => Str::slug($this->ticket->title)
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
            'ticket' => $this->ticket,
            'field' => $this->field,
            'before' => $this->before,
            'after' => $this->after,
            'user' => $this->user,
        ];
    }
}
