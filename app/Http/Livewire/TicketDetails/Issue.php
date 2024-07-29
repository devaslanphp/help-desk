<?php

namespace App\Http\Livewire\TicketDetails;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Issue extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    protected $listeners = ['refreshForm'];

    public function mount(): void
    {
        $this->form->fill([
            'issue' => $this->ticket->issue
        ]);
    }

    public function refreshForm(): void
    {
        $this->ticket = $this->ticket->refresh();
        $this->form->fill([
            'issue' => $this->ticket->issue
        ]);
        $this->updating = false;
    }

    public function render()
    {
        return view('livewire.ticket-details.issue');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('issue')
                ->label(__('Issue'))
                ->required()
                ->searchable()
                ->disableLabel()
                ->placeholder(__('Issue'))
                ->options(function ($get): array {
                    if($this->ticket->subcategory != "Select new subcategory" && $this->ticket->category != null)
                        $arrayIssues = TicketCategory::getIssues($this->ticket->subcategory);
                    elseif($this->ticket->subcategory == "Select new subcategory")
                    {
                        $arrayIssues = TicketCategory::getIssuesByCategory($this->ticket->category);
                    }

                    return $arrayIssues;
                })
        ];
    }

    /**
     * Enable updating
     *
     * @return void
     */
    public function update(): void
    {
        $this->updating = true;
    }

    /**
     * Save main function
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $before = $this->ticket->issue ?? '-';
        $this->ticket->issue = $data['issue'];
        $this->ticket->subcategory = TicketCategory::getChosenCategory($data['issue']);
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Issue updated'))
            ->body(__('The ticket issue has been successfully updated'))
            ->send();
        $this->form->fill([
            'issue' => $this->ticket->issue
        ]);
        $this->updating = false;
        $this->ticket = $this->ticket->refresh();
        $this->emit('ticketSaved');
        $this->emit('refreshForm');  // Emit event to refresh ticket details form
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Issue'),
            $before,
            ($this->ticket->issue ?? '-'),
            auth()->user()
        );
    }
}
