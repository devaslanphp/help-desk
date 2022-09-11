<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Notifications\ProjectCreatedNotification;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Projects extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;
    public $selectedProject;

    protected $listeners = ['projectSaved', 'projectDeleted'];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $query = Project::query();
        if (has_all_permissions(auth()->user(), 'view-own-projects')) {
            $query->where('owner_id', auth()->user()->id);
        }
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        }
        $projects = $query->paginate();
        return view('livewire.projects', compact('projects'));
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Grid::make(1)
                ->schema([
                    TextInput::make('search')
                        ->label(__('Search for projects'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for projects')),
                ]),
        ];
    }

    /**
     * Search for projects
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

    /**
     * Show update project dialog
     *
     * @param $id
     * @return void
     */
    public function updateProject($id)
    {
        $this->selectedProject = Project::find($id);
        $this->dispatchBrowserEvent('toggleProjectModal');
    }

    /**
     * Show create project dialog
     *
     * @return void
     */
    public function createProject()
    {
        $this->selectedProject = new Project();
        $this->dispatchBrowserEvent('toggleProjectModal');
    }

    /**
     * Cancel and close project create / update dialog
     *
     * @return void
     */
    public function cancelProject()
    {
        $this->selectedProject = null;
        $this->dispatchBrowserEvent('toggleProjectModal');
    }

    /**
     * Event launched after a project is created / updated
     *
     * @return void
     */
    public function projectSaved() {
        $this->search();
        $this->cancelProject();
    }

    /**
     * Event launched after a project is deleted
     *
     * @return void
     */
    public function projectDeleted() {
        $this->projectSaved();
    }
}
