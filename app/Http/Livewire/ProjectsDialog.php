<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;

class ProjectsDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public Project $project;
    public bool $deleteConfirmationOpened = false;

    protected $listeners = ['doDeleteProject', 'cancelDeleteProject'];

    public function mount(): void {
        $this->form->fill([
            'name' => $this->project->name,
            'description' => $this->project->description,
            'owner_id' => $this->project->owner_id ?? auth()->user()->id,
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
            Select::make('owner_id')
                ->label(__('Owner'))
                ->required()
                ->searchable()
                ->options(User::all()->pluck('name', 'id')),

            TextInput::make('name')
                ->label(__('Full name'))
                ->maxLength(255)
                ->required(),

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
    public function save(): void {
        $data = $this->form->getState();
        if (!$this->project?->id) {
            Project::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'owner_id' => $data['owner_id']
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
    public function doDeleteProject(): void {
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
    public function cancelDeleteProject(): void {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete project confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteProject(): void {
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title(__('Project deletion'))
            ->body(__('Are you sure you want to delete this project?'))
            ->actions([
                Action::make('confirm')
                    ->label(__('Confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteProject'),
                Action::make('cancel')
                    ->label(__('Cancel'))
                    ->close()
                    ->emit('cancelDeleteProject')
            ])
            ->persistent()
            ->send();
    }
}
