<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;
use Ramsey\Uuid\Uuid;

class UsersDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;

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

    public function deleteUser(): void {
        $this->user->delete();
        $this->dispatchBrowserEvent('toggleUserModal');
    }
}
