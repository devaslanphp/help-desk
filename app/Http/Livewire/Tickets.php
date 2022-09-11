<?php

namespace App\Http\Livewire;

use App\Models\FavoriteProject;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
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
    public $owner;
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
        $this->form->fill();
    }

    public function render()
    {
        $query = Ticket::query();
        if (has_all_permissions(auth()->user(), 'view-own-tickets') && !has_all_permissions(auth()->user(), 'view-all-tickets')) {
            $query->where('owner_id', auth()->user()->id);
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
                ->extraAttributes([
                    'class' => 'w-full'
                ])
                ->schema([
                    MultiSelect::make('projects')
                        ->label(__('Project'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Project'))
                        ->options(function () {
                            $query = Project::query();
                            if (has_all_permissions(auth()->user(), 'view-own-projects') && !has_all_permissions(auth()->user(), 'view-all-projects')) {
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

                    MultiSelect::make('owner')
                        ->label(__('Owner'))
                        ->disableLabel()
                        ->searchable()
                        ->placeholder(__('Owner'))
                        ->options(User::all()->pluck('name', 'id')),

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
        $this->owner = $data['owner'] ?? null;
        $this->responsible = $data['responsible'] ?? null;
    }

    public function resetFilters(): void {
        $this->search = null;
        $this->projects = null;
        $this->priorities = null;
        $this->statuses = null;
        $this->owner = null;
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
}
