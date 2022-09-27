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
        $ticketPrefix = substr($number, 0, 4);
        $ticketNumber = str_replace($ticketPrefix, "", $number);
        $ticket = Ticket::where('number', $ticketNumber)
            ->whereHas('project', fn($query) => $query->where('ticket_prefix', $ticketPrefix))
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
