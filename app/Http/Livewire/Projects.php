<?php

namespace App\Http\Livewire;

use App\Models\FavoriteProject;
use App\Models\Project;
use App\Tables\Columns\UserColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Component;

class Projects extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedProject;

    protected $listeners = ['projectSaved', 'projectDeleted'];

    public function render()
    {
        return view('livewire.projects');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        $query = Project::query();
        $query->withCount('tickets');
        if (has_all_permissions(auth()->user(), 'view-own-projects') && !has_all_permissions(auth()->user(), 'view-all-projects')) {
            $query->where(function ($query) {
                $query->where('owner_id', auth()->user()->id)
                    ->orWhereHas('tickets', function ($query) {
                        $query->where('responsible_id', auth()->user()->id);
                    });
            });
        }
        return $query;
    }

    /**
     * Table definition
     *
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('make_favorite')
                ->label('')
                ->formatStateUsing(function (Project $record) {
                    $btnClass = $record->favoriteUsers()->where('user_id', auth()->user()->id)->count() ? 'text-warning-500' : 'text-gray-500';
                    $iconClass = $record->favoriteUsers()->where('user_id', auth()->user()->id)->count() ? 'fa-star' : 'fa-star-o';
                    return new HtmlString('
                        <button wire:click="toggleFavoriteProject(' . $record->id . ')" type="button" class="' . $btnClass . '">
                            <i class="fa ' . $iconClass . '"></i>
                        </button>
                    ');
                }),

            TextColumn::make('name')
                ->label(__('Project name'))
                ->searchable()
                ->sortable(),

            TextColumn::make('description')
                ->label(__('Description'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn(string|null $state) => Str::limit(htmlspecialchars(strip_tags($state ?? '')), 50)),

            UserColumn::make('owner')
                ->label(__('Owner')),

            TextColumn::make('tickets_count')
                ->label(__('Tickets'))
                ->sortable(),

            TextColumn::make('created_at')
                ->label(__('Created at'))
                ->sortable()
                ->searchable()
                ->dateTime(),
        ];
    }

    /**
     * Table actions definition
     *
     * @return array
     */
    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->link()
                ->label(__('Edit project'))
                ->action(fn(Project $record) => $this->updateProject($record->id))
        ];
    }

    /**
     * Table default sort column definition
     *
     * @return string|null
     */
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    /**
     * Table default sort direction definition
     *
     * @return string|null
     */
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
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
    public function projectSaved()
    {
        $this->cancelProject();
    }

    /**
     * Event launched after a project is deleted
     *
     * @return void
     */
    public function projectDeleted()
    {
        $this->projectSaved();
    }

    /**
     * Add / Remove project from authenticated user favorite projects
     *
     * @param int $projectId
     * @return void
     */
    public function toggleFavoriteProject(int $projectId)
    {
        $project = Project::find($projectId);
        if (FavoriteProject::where('user_id', auth()->user()->id)->where('project_id', $project->id)->count()) {
            FavoriteProject::where('user_id', auth()->user()->id)->where('project_id', $project->id)->delete();
            Notification::make()
                ->success()
                ->title(__('Favorite removed'))
                ->body(__('The project has been successfully remove from your favorite projects'))
                ->send();
        } else {
            FavoriteProject::create([
                'user_id' => auth()->user()->id,
                'project_id' => $project->id
            ]);
            Notification::make()
                ->success()
                ->title(__('Favorite added'))
                ->body(__('The project has been successfully added to your favorite projects'))
                ->send();
        }
    }
}
