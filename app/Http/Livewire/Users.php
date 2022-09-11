<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;

class Users extends Component implements HasForms
{
    use InteractsWithForms;

    public $search;
    public $selectedUser;

    protected $listeners = ['userSaved', 'userDeleted'];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $query = User::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }
        $users = $query->paginate();
        return view('livewire.users', compact('users'));
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(1)
                ->schema([
                    TextInput::make('search')
                        ->label(__('Search for users'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for users')),
                ]),
        ];
    }

    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

    public function updateUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->dispatchBrowserEvent('toggleUserModal');
    }

    public function createUser()
    {
        $this->selectedUser = new User();
        $this->dispatchBrowserEvent('toggleUserModal');
    }

    public function cancelUser()
    {
        $this->selectedUser = null;
        $this->dispatchBrowserEvent('toggleUserModal');
    }

    public function userSaved() {
        $this->search();
        $this->cancelUser();
    }

    public function userDeleted() {
        $this->userSaved();
    }

    public function resendActivationEmail(User $user) {
        if ($user->register_token) {
            $user->notify(new UserCreatedNotification($user));
            Notification::make()
                ->success()
                ->title('Success')
                ->body(__('An email has been sent to the user'))
                ->send();
        }
    }
}
