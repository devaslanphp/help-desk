<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\CommentCreateNotification;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
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
    private User|Authenticatable $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        Ticket $ticket,
        string $field,
        string $before,
        string $after,
        User|Authenticatable $user
    )
    {
        $this->ticket = $ticket;
        $this->field = $field;
        $this->before = $before;
        $this->after = $after;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->before !== $this->after) {
            $users = User::whereNull('register_token')->where('id', '<>', $this->user->id)->get();
            foreach ($users as $u) {
                if (
                    (
                        auth()->user()->can('View all tickets')
                        && $this->ticket->owner_id !== $u->id
                    )
                    ||
                    (
                        auth()->user()->can('View own tickets')
                        && (
                            $this->ticket->owner_id === $u->id
                            || $this->ticket->responsible_id === $u->id
                        )
                        && $this->ticket->owner_id !== $u->id
                    )
                ) {
                    $u->notify(
                        new TicketUpdatedNotification(
                            $this->ticket,
                            $this->field,
                            $this->before,
                            $this->after,
                            $this->user
                        )
                    );
                }
            }
        }
    }
}
