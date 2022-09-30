<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Tickets extends Component implements HasForms
{
    use InteractsWithForms;

    public $menu;
    public $activeMenu;
    public $search;
    public $projects;
    public $priorities;
    public $statuses;
    public $types;
    public $responsible;
    public $selectedTicket;

    protected $listeners = ['ticketSaved', 'ticketDeleted'];

    public function mount()
    {
        $this->menu = [
            'All tickets',
            'Unassigned',
            'Assigned to me',
            'Created by me',
        ];
        $this->activeMenu = $this->menu[0];
        $data = [];
        if (request()->get('project')) {
            $data['projects'] = [request()->get('project')];
        }
        $this->form->fill($data);
    }

    public function render()
    {
        $query = Ticket::query();
        $query->withCount('comments');
        if (auth()->user()->can('View own tickets') && !auth()->user()->can('View all tickets')) {
            $query->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhere('responsible_id', auth()->user()->id)
                    ->orWhereHas('project', function ($query) {
                        $query->whereHas('company', function ($query) {
                            $query->whereIn('companies.id', auth()->user()->ownCompanies->pluck('id')->toArray());
                        });
                    });
            });
        }
        if ($this->activeMenu === 'Unassigned') {
            $query->whereNull('responsible_id');
        }
        if ($this->activeMenu === 'Assigned to me') {
            $query->where('responsible_id', auth()->user()->id);
        }
        if ($this->activeMenu === 'Created by me') {
            $query->where('owner_id', auth()->user()->id);
        }
        if ($this->search) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->projects && sizeof($this->projects)) {
            $query->whereIn('project_id', $this->projects);
        }
        if ($this->priorities && sizeof($this->priorities)) {
            $query->whereIn('priority', $this->priorities);
        }
        if ($this->statuses && sizeof($this->statuses)) {
            $query->whereIn('status', $this->statuses);
        }
        if ($this->types && sizeof($this->types)) {
            $query->whereIn('type', $this->types);
        }
        if ($this->statuses && sizeof($this->responsible)) {
            $query->whereIn('responsible_id', $this->responsible);
        }
        $tickets = $query->paginate();
        return view('livewire.tickets', compact('tickets'));
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
        $this->search();
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Grid::make(6)
                ->schema([
                    MultiSelect::make('projects')
                        ->label(__('Project'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Project'))
                        ->options(function () {
                            $query = Project::query();
                            if (auth()->user()->can('View own projects') && !auth()->user()->can('View all projects')) {
                                $query->where('owner_id', auth()->user()->id);
                            }
                            return $query->get()->pluck('name', 'id');
                        }),

                    MultiSelect::make('priorities')
                        ->label(__('Priorities'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Priorities'))
                        ->options(priorities_list()),

                    MultiSelect::make('statuses')
                        ->label(__('Statuses'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Statuses'))
                        ->options(statuses_list()),

                    MultiSelect::make('types')
                        ->label(__('Types'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Types'))
                        ->options(types_list()),

                    MultiSelect::make('responsible')
                        ->label(__('Responsible'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Responsible'))
                        ->options(User::all()->pluck('name', 'id')),

                    TextInput::make('search')
                        ->label(__('Search for tickets'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for tickets'))
                ]),
        ];
    }

    /**
     * Search for tickets
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
        $this->projects = $data['projects'] ?? null;
        $this->priorities = $data['priorities'] ?? null;
        $this->statuses = $data['statuses'] ?? null;
        $this->types = $data['types'] ?? null;
        $this->responsible = $data['responsible'] ?? null;
    }

    public function resetFilters(): void
    {
        $this->search = null;
        $this->projects = null;
        $this->priorities = null;
        $this->statuses = null;
        $this->types = null;
        $this->responsible = null;
    }

    /**
     * Show create ticket dialog
     *
     * @return void
     */
    public function createTicket()
    {
        $this->selectedTicket = new Ticket();
        $this->dispatchBrowserEvent('toggleTicketModal');
    }

    /**
     * Cancel and close ticket create / update dialog
     *
     * @return void
     */
    public function cancelTicket()
    {
        $this->selectedTicket = null;
        $this->dispatchBrowserEvent('toggleTicketModal');
    }

    /**
     * Event launched after a ticket is created / updated
     *
     * @return void
     */
    public function ticketSaved()
    {
        $this->search();
        $this->cancelTicket();
    }

    /**
     * Event launched after a ticket is deleted
     *
     * @return void
     */
    public function ticketDeleted()
    {
        $this->ticketSaved();
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
}
