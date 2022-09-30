<?php

namespace App\Http\Livewire\Administration;

use App\Core\CrudDialogHelper;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public Role $role;

    protected $listeners = ['doDeleteRole', 'cancelDeleteRole'];

    public array $permissions;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->role->name,
            'permissions' => $this->role->permissions->pluck('id')->toArray(),
        ]);
    }


    public function render()
    {
        return view('livewire.administration.roles-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->label(__('Role name'))
                ->maxLength(255)
                ->required(),

            CheckboxList::make('permissions')
                ->label(__('Permissions'))
                ->hint(new HtmlString('
                    <div class="w-full flex items-center gap-2">
                        <button type="button"
                            class="text-xs text-primary-500 hover:text-primary-600 hover:underline"
                            wire:click="assignAllPermissions">
                            ' . __('Assign all permissions') . '
                        </button>
                        <span class="text-xs text-gray-300">|</span>
                        <button type="button"
                            class="text-xs text-primary-500 hover:text-primary-600 hover:underline"
                            wire:click="removeAllPermissions">
                            ' . __('Remove all permissions') . '
                        </button>
                    </div>
                '))
                ->columns(3)
                ->options(Permission::orderBy('name')->get()->pluck('name', 'id')->toArray())
        ];
    }

    /**
     * Assign all permissions
     *
     * @return void
     */
    public function assignAllPermissions(): void
    {
        $this->permissions = Permission::all()->pluck('id')->toArray();
    }

    /**
     * Remove all assigned permissions
     *
     * @return void
     */
    public function removeAllPermissions(): void
    {
        $this->permissions = [];
    }

    /**
     * Create / Update the role
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->role?->id) {
            $role = Role::create(['name' => $data['name']]);
            $role->syncPermissions($this->permissions);
            Notification::make()
                ->success()
                ->title(__('Role created'))
                ->body(__('The user role has been created'))
                ->send();
        } else {
            $this->role->name = $data['name'];
            $this->role->save();
            $this->role->syncPermissions($this->permissions);
            Notification::make()
                ->success()
                ->title(__('Role updated'))
                ->body(__('The role\'s details has been updated'))
                ->send();
        }
        $this->emit('roleSaved');
    }

    /**
     * Delete an existing role
     *
     * @return void
     */
    public function doDeleteRole(): void
    {
        $this->role->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('roleDeleted');
        Notification::make()
            ->success()
            ->title(__('Role deleted'))
            ->body(__('The role has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a role
     *
     * @return void
     */
    public function cancelDeleteRole(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete role confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteRole(): void
    {
        $this->deleteConfirmation(
            __('Role deletion'),
            __('Are you sure you want to delete this role?'),
            'doDeleteRole',
            'cancelDeleteRole'
        );
    }
}
