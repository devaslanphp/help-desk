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


class Subcategory extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    protected $listeners = ['refreshForm'];

    public function mount(): void
    {
        $this->form->fill([
            'subcategory' => $this->ticket->subcategory
        ]);
        
    }

    public function refreshForm(): void
    {
        $this->ticket = $this->ticket->refresh();
        $this->form->fill([
            'subcategory' => $this->ticket->subcategory
        ]);
        $this->updating = false;
    }

    public function render()
    {
        return view('livewire.ticket-details.subcategory');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('subcategory')
                ->label(__('Subcategory'))
                ->required()
                ->searchable()
                ->disableLabel()
                ->placeholder(__('Subcategory'))
                ->options(fn ($get): array => TicketCategory::getSubCategories($this->ticket->category))
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
        $before = $this->ticket->subcategory ?? '-';
        $this->ticket->subcategory = $data['subcategory'];
        $this->ticket->issue = 'Select new issue';
        $this->ticket->type = 'Select new type';
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Subcategory updated'))
            ->body(__('The ticket subcategory has been successfully updated'))
            ->send();
        $this->form->fill([
            'subcategory' => $this->ticket->subcategory
        ]);
        $this->updating = false;
        $this->emit('ticketSaved');
        $this->emit('refreshForm');  // Emit event to refresh ticket details form
        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Subcategory'),
            $before,
            ($this->ticket->subcategory ?? '-'),
            auth()->user()
        );
    }
}
