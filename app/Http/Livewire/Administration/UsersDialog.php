<?php

namespace App\Http\Livewire\Administration;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Permission;
use Closure;

class UsersDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;
    public bool $deleteConfirmationOpened = false;

    protected $listeners = ['doDeleteUser', 'cancelDeleteUser'];

    public array $permissions;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'permissions' => $this->user->permissions->pluck('id')->toArray(),
        ]);
    }


    public function render()
    {
        return view('livewire.administration.users-dialog');
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
                    TextInput::make('name')
                        ->label(__('Full name'))
                        ->maxLength(255)
                        ->required(),

                    TextInput::make('email')
                        ->label(__('Email address'))
                        ->email()
                        ->unique(table: User::class, column: 'email', ignorable: fn() => $this->user->id ? $this->user : null)
                        ->required(),
                ]),

            Grid::make()
                ->extraAttributes([
                    'class' => 'border-t border-gray-200 pt-5 mt-5'
                ])
                ->schema([
                    Select::make('same_permissions_as')
                        ->label(__('Use same permissions of'))
                        ->helperText(__("Update the permissions of this user based on another user's permissions"))
                        ->searchable()
                        ->options(User::all()->pluck('name', 'id')->toArray())
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get) {
                            if ($get('same_permissions_as')) {
                                $user = User::find($get('same_permissions_as'));
                                $set('permissions', $user->permissions->pluck('id')->toArray());
                            }
                        })
                ]),

            Placeholder::make('permissions_buttons')
                ->content(new HtmlString('
                    <div class="w-full flex items-center gap-2">
                        <button type="button" class="text-xs text-primary-500 hover:text-primary-600 hover:underline" wire:click="assignAllPermissions">' . __('Assign all permissions') . '</button>
                        <button type="button" class="text-xs text-primary-500 hover:text-primary-600 hover:underline" wire:click="removeAllPermissions">' . __('Remove all permissions') . '</button>
                    </div>
                ')),

            CheckboxList::make('permissions')
                ->label(__('Permissions'))
                ->required()
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
     * Create / Update the user
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->user?->id) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt(uniqid()),
                'register_token' => Uuid::uuid4()->toString()
            ]);
            $user->syncPermissions($data['permissions']);
            $user->notify(new UserCreatedNotification($user));
            Notification::make()
                ->success()
                ->title(__('User created'))
                ->body(__('An email has been sent to the user'))
                ->send();
        } else {
            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->save();
            $this->user->syncPermissions($data['permissions']);
            Notification::make()
                ->success()
                ->title(__('User updated'))
                ->body(__('The user\'s details has been updated'))
                ->send();
        }
        $this->emit('userSaved');
    }

    /**
     * Delete an existing user
     *
     * @return void
     */
    public function doDeleteUser(): void
    {
        $this->user->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('userDeleted');
        Notification::make()
            ->success()
            ->title(__('User deleted'))
            ->body(__('The user has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a user
     *
     * @return void
     */
    public function cancelDeleteUser(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete user confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteUser(): void
    {
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title(__('User deletion'))
            ->body(__('Are you sure you want to delete this user?'))
            ->actions([
                Action::make('confirm')
                    ->label(__('Confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteUser'),
                Action::make('cancel')
                    ->label(__('Cancel'))
                    ->close()
                    ->emit('cancelDeleteUser')
            ])
            ->persistent()
            ->send();
    }
}
