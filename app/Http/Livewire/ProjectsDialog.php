<?php

namespace App\Http\Livewire;

use App\Core\CrudDialogHelper;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class ProjectsDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public Project $project;

    protected $listeners = ['doDeleteProject', 'cancelDeleteProject'];

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->project->name,
            'ticket_prefix' => $this->project->ticket_prefix,
            'description' => $this->project->description,
            'owner_id' => $this->project->owner_id ?? auth()->user()->id,
            'company_id' => $this->project->company_id
        ]);
    }

    public function render()
    {
        return view('livewire.projects-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Grid::make()
                ->schema([
                    Select::make('owner_id')
                        ->label(__('Owner'))
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function () {
                            $query = User::query();
                            if (auth()->user()->can('View company users') && !auth()->user()->can('View all users')) {
                                $query->whereHas(
                                    'companies',
                                    fn($query) => $query->whereIn(
                                        'companies.id',
                                        auth()->user()->ownCompanies->pluck('id')->toArray()
                                    )
                                )->orWhere('id', auth()->user()->id);
                            }
                            return $query->get()->pluck('name', 'id')->toArray();
                        }),

                    Select::make('company_id')
                        ->label(__('Company'))
                        ->searchable()
                        ->options(function (Closure $get) {
                            $query = Company::query();
                            if ($get('owner_id')) {
                                $query->where('responsible_id', $get('owner_id'));
                            } elseif (auth()->user()->can('View own companies')) {
                                $query->where('responsible_id', auth()->user()->id);
                            }
                            return $query->get()->pluck('name', 'id')->toArray();
                        }),
                ]),

            Grid::make(3)
                ->schema([
                    TextInput::make('ticket_prefix')
                        ->label(__('Ticket prefix'))
                        ->minLength(4)
                        ->maxLength(4)
                        ->columnSpan(1)
                        ->helperText(__('Used to generate tickets numbers'))
                        ->required(),

                    TextInput::make('name')
                        ->label(__('Full name'))
                        ->maxLength(255)
                        ->columnSpan(2)
                        ->required(),
                ]),

            RichEditor::make('description')
                ->label(__('Description'))
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('projects')
                ->fileAttachmentsVisibility('private'),
        ];
    }

    /**
     * Create / Update the project
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->project?->id) {
            Project::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'owner_id' => $data['owner_id'],
                'ticket_prefix' => $data['ticket_prefix'],
                'company_id' => $data['company_id'],
            ]);
            Notification::make()
                ->success()
                ->title(__('Project created'))
                ->body(__('The project has been successfully created'))
                ->send();
        } else {
            $this->project->name = $data['name'];
            $this->project->description = $data['description'];
            $this->project->owner_id = $data['owner_id'];
            $this->project->company_id = $data['company_id'];
            $this->project->ticket_prefix = $data['ticket_prefix'];
            $this->project->save();
            Notification::make()
                ->success()
                ->title(__('Project updated'))
                ->body(__('The project\'s details has been updated'))
                ->send();
        }
        $this->emit('projectSaved');
    }

    /**
     * Delete an existing project
     *
     * @return void
     */
    public function doDeleteProject(): void
    {
        $this->project->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('projectDeleted');
        Notification::make()
            ->success()
            ->title(__('Project deleted'))
            ->body(__('The project has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a project
     *
     * @return void
     */
    public function cancelDeleteProject(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete project confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteProject(): void
    {
        $this->deleteConfirmation(
            __('Project deletion'),
            __('Are you sure you want to delete this project?'),
            'doDeleteProject',
            'cancelDeleteProject'
        );
    }
}
