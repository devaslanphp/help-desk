<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class TicketNumberController extends Controller
{

    /**
     * Redirect to a ticket based on it's number
     *
     * @param string $number
     * @return RedirectResponse|void
     */
    public function __invoke(string $number)
    {
        $ticket_prefix = substr($number, 0, 4);
        $ticket_number = str_replace($ticket_prefix, "", $number);
        $ticket = Ticket::where('number', $ticket_number)
            ->whereHas('project', fn($query) => $query->where('ticket_prefix', $ticket_prefix))
            ->first();
        if ($ticket) {
            return redirect()->route('tickets.details', [
                'ticket' => $ticket,
                'slug' => Str::slug($ticket->title)
            ]);
        } else {
            abort(404);
        }
    }

}
