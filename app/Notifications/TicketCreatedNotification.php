<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TicketCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Ticket $ticket;
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line(__('We inform you that a new ticket has been created in the platform :platform.', [
                        'platform' => config('app.name')
                    ]))
                    ->line(__('Below are the details of this ticket:'))
                    ->line(__('- Title: :title', ['title' => $this->ticket->title]))
                    ->line(__('- Type: :type', ['type' => config('system.types.' . $this->ticket->type . '.title')]))
                    ->line(
                        __(
                            '- Priority: :priority',
                            [
                                'priority' => config('system.priorities.' . $this->ticket->priority . '.title')
                            ]
                        )
                    )
                    ->action(
                        __('Ticket details'),
                        route(
                            'tickets.details',
                            [
                                'ticket' => $this->ticket,
                                'slug' => Str::slug($this->ticket->title)
                            ]
                        ))
                    ->line(__('Thank you for using our application!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ticket' => $this->ticket,
            'user' => $this->user,
        ];
    }
}
