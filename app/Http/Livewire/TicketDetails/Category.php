<?php

namespace App\Http\Livewire\TicketDetails;

use App\Jobs\TicketUpdatedJob;
use App\Models\Ticket;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Category extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public bool $updating = false;

    protected $listeners = ['refreshForm'];

    public function mount(): void
    {
        $this->form->fill([
            'category' => $this->ticket->category
        ]);
        
    }

    public function refreshForm(): void
    {
        $this->ticket = $this->ticket->refresh();
        $this->form->fill([
            'category' => $this->ticket->category
        ]);
        $this->updating = false;
    }

    public function render()
    {
        return view('livewire.ticket-details.category');
    }
    
    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('category')
                ->label(__('Category'))
                ->required()
                ->searchable()
                ->disableLabel()
                ->placeholder(__('Category'))
                ->options(function($state){
                    $categories = categories_list();
                    return $categories;
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
        $before = $this->ticket->category ?? '-';
        $this->ticket->category = $data['category'];
        $this->ticket->subcategory = 'Select new subcategory';
        $this->ticket->issue = 'Select new issue';
        $this->ticket->type = 'Select new type';
        $this->ticket->save();
        Notification::make()
            ->success()
            ->title(__('Category updated'))
            ->body(__('The ticket category has been successfully updated'))
            ->send();
        $this->form->fill([
            'category' => $this->ticket->category
        ]);
        $this->updating = false;
        $this->ticket = $this->ticket->refresh();
        $this->emit('ticketSaved');
        $this->emit('refreshForm');  // Emit event to refresh ticket details form

        TicketUpdatedJob::dispatch(
            $this->ticket,
            __('Category'),
            $before,
            ($this->ticket->category ?? '-'),
            auth()->user()
        );
    }
}
