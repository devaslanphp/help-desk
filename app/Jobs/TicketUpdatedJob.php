<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\CommentCreateNotification;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TicketUpdatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Ticket $ticket;
    private string $field;
    private string $before;
    private string $after;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket, string $field, string $before, string $after)
    {
        $this->ticket = $ticket;
        $this->field = $field;
        $this->before = $before;
        $this->after = $after;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->before !== $this->after) {
            $users = User::whereNull('register_token')->get();
            foreach ($users as $user) {
                if (
                    (has_all_permissions($user, 'view-all-tickets') && $this->ticket->owner_id !== $user->id)
                    ||
                    (has_all_permissions($user, 'view-own-tickets') && ($this->ticket->owner_id === $user->id || $this->ticket->responsible_id === $user->id) && $this->ticket->owner_id !== $user->id)
                ) {
                    $user->notify(new TicketUpdatedNotification($this->ticket, $this->field, $this->before, $this->after, $user));
                }
            }
        }
    }
}
