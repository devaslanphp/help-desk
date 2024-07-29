<?php

namespace App\Http\Livewire;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use Filament\Notifications\Notification;
use Livewire\Component;

class TicketDetails extends Component
{
    public Ticket $ticket;
    public $menu;
    public $activeMenu;

    protected $listeners = ['ticketSaved'];

    public function mount(): void
    {
        $this->menu = [
            'Comments',
            'Chat',
        ];
        $this->activeMenu = $this->menu[0];
    }

    public function render()
    {
        return view('livewire.ticket-details');
    }

    /**
     * Change a menu (tab)
     *
     * @param $item
     * @return void
     */
    public function selectMenu($item)
    {
        $this->activeMenu = $item;
        $this->dispatchBrowserEvent('initMagnificPopupOnTicketComments');
    }

    /**
     * Event launched after the ticket is updated
     *
     * @return void
     */
    public function ticketSaved(): void
    {
        $this->ticket = $this->ticket->refresh();
    }

    /**
     * Copy a ticket url
     *
     * @param int $ticketId
     * @return void
     */
    public function copyTicketUrl(int $ticketId): void
    {
        $ticket = Ticket::where('id', $ticketId)->first();
        Notification::make()
            ->success()
            ->title(__('Ticket url copied'))
            ->body(__('The ticket url successfully copied to your clipboard'))
            ->send();
        $this->dispatchBrowserEvent('ticketUrlCopied', [
            'url' => route('tickets.number', [
                'number' => $ticket->ticket_number
            ])
        ]);
    }

    /**
     * Close ticket
     *
     * @return void
     */
    public function closeTicket(): void
    {
        $before = $this->ticket->status ?? '-';
        $this->ticket->status = 'closed';
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Status updated'))
            ->body(__('The ticket has been successfully closed. Thank you for enquiring with us!'))
            ->send();

        $this->ticket = $this->ticket->refresh();
        $this->emit('ticketSaved');
        $this->emit('refreshStatusForm');  // Emit event to refresh status form
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Status'),
            $before,
            ($this->ticket->status ?? '-'),
            auth()->user()
        );
    }

    /**
     * Approves ticket
     *
     * @return void
     */
    public function approveTicket(): void
    {
        $before = $this->ticket->status ?? '-';
        $this->ticket->status = 'approved';
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Status updated'))
            ->body(__('The ticket has been successfully approved.'))
            ->send();

        $this->ticket = $this->ticket->refresh();
        $this->emit('ticketSaved');
        $this->emit('refreshStatusForm');  // Emit event to refresh status form
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Status'),
            $before,
            ($this->ticket->status ?? '-'),
            auth()->user()
        );
    }

    /**
     * Disapproves ticket
     *
     * @return void
     */
    public function disapproveTicket(): void
    {
        $before = $this->ticket->status ?? '-';
        $this->ticket->status = 'closed';
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Status updated'))
            ->body(__('The ticket has been successfully disapproved.'))
            ->send();

        $this->ticket = $this->ticket->refresh();
        $this->emit('ticketSaved');
        $this->emit('refreshStatusForm');  // Emit event to refresh status form
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Status'),
            $before,
            ($this->ticket->status ?? '-'),
            auth()->user()
        );
    }
}
