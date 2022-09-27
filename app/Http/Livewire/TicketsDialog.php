<?php

namespace App\Http\Livewire;

use App\Jobs\TicketCreatedJob;
use App\Models\Project;
use App\Models\Ticket;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class TicketsDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->ticket->title,
            'content' => $this->ticket->content,
            'priority' => $this->ticket->priority,
            'project_id' => $this->ticket->project_id,
        ]);
    }

    public function render()
    {
        return view('livewire.tickets-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [

            Select::make('project_id')
                ->label(__('Project'))
                ->required()
                ->searchable()
                ->options(function () {
                    $query = Project::query();
                    if (auth()->user()->can('View own projects') && !auth()->user()->can('View all projects')) {
                        $query->where('owner_id', auth()->user()->id);
                    }
                    return $query->get()->pluck('name', 'id');
                }),

            Grid::make()
                ->schema([

                    Select::make('type')
                        ->label(__('Type'))
                        ->required()
                        ->searchable()
                        ->options(types_list()),

                    Select::make('priority')
                        ->label(__('Priority'))
                        ->required()
                        ->searchable()
                        ->options(priorities_list()),

                ]),

            TextInput::make('title')
                ->label(__('Ticket title'))
                ->maxLength(255)
                ->required(),

            RichEditor::make('content')
                ->label(__('Content'))
                ->required()
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('tickets')
                ->fileAttachmentsVisibility('private'),
        ];
    }

    /**
     * Create / Update the ticket
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $ticket = Ticket::create([
            'project_id' => $data['project_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'owner_id' => auth()->user()->id,
            'priority' => $data['priority'],
            'type' => $data['type'],
            'status' => default_ticket_status()
        ]);
        Notification::make()
            ->success()
            ->title(__('Ticket created'))
            ->body(__('The ticket has been successfully created'))
            ->actions([
                Action::make('redirect')
                    ->label(__('See details'))
                    ->color('success')
                    ->button()
                    ->close()
                    ->url(fn() => route('tickets.details', [
                        'ticket' => $ticket,
                        'slug' => Str::slug($ticket->title)
                    ]))
            ])
            ->send();
        $this->emit('ticketSaved');
        TicketCreatedJob::dispatch($ticket);
    }
}
