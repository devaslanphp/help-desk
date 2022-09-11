<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

class UsersDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;
    public bool $deleteConfirmationOpened = false;

    protected $listeners = ['doDeleteUser', 'cancelDeleteUser'];

    public function mount(): void {
        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'role' => $this->user->role,
        ]);
    }


    public function render()
    {
        return view('livewire.users-dialog');
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
                ->label(__('Full name'))
                ->maxLength(255)
                ->required(),

            TextInput::make('email')
                ->label(__('Email address'))
                ->email()
                ->unique(table: User::class, column: 'email', ignorable: fn () => $this->user->id ? $this->user : null)
                ->required(),

            Select::make('role')
                ->label(__('Role'))
                ->required()
                ->searchable()
                ->options(roles_list())
        ];
    }

    /**
     * Create / Update the user
     *
     * @return void
     */
    public function save(): void {
        $data = $this->form->getState();
        if (!$this->user?->id) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => bcrypt(uniqid()),
                'register_token' => Uuid::uuid4()->toString()
            ]);
            $user->notify(new UserCreatedNotification($user));
            Notification::make()
                ->success()
                ->title('User created')
                ->body(__('An email has been sent to the user'))
                ->send();
        } else {
            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->role = $data['role'];
            $this->user->save();
            Notification::make()
                ->success()
                ->title('User updated')
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
    public function doDeleteUser(): void {
        $this->user->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('userDeleted');
        Notification::make()
            ->success()
            ->title('User deleted')
            ->body(__('The user has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a user
     *
     * @return void
     */
    public function cancelDeleteUser(): void {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete user confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteUser(): void {
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title('User deletion')
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
