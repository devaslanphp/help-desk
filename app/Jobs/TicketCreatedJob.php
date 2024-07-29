<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TicketCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Ticket $ticket;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::whereNull('register_token')->get();
        foreach ($users as $user) {
            if ($user->can('View all tickets') && auth()->user()->hasRole('administrator') == 'administrator')  {
                $user->notify(new TicketCreatedNotification($this->ticket, $user));
            }
        }
    }
}
