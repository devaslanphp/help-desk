<?php

namespace App\Http\Livewire\Administration;

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
        return view('livewire.administration.users', compact('users'));
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
                        ->label(__('Search for users'))
                        ->disableLabel()
                        ->type('search')
                        ->placeholder(__('Search for users')),
                ]),
        ];
    }

    /**
     * Search for users
     *
     * @return void
     */
    public function search(): void
    {
        $data = $this->form->getState();
        $this->search = $data['search'] ?? null;
    }

    /**
     * Show update user dialog
     *
     * @param $id
     * @return void
     */
    public function updateUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->dispatchBrowserEvent('toggleUserModal');
    }

    /**
     * Show create user dialog
     *
     * @return void
     */
    public function createUser()
    {
        $this->selectedUser = new User();
        $this->dispatchBrowserEvent('toggleUserModal');
    }

    /**
     * Cancel and close user create / update dialog
     *
     * @return void
     */
    public function cancelUser()
    {
        $this->selectedUser = null;
        $this->dispatchBrowserEvent('toggleUserModal');
    }

    /**
     * Event launched after a user is created / updated
     *
     * @return void
     */
    public function userSaved() {
        $this->search();
        $this->cancelUser();
    }

    /**
     * Event launched after a user is deleted
     *
     * @return void
     */
    public function userDeleted() {
        $this->userSaved();
    }

    /**
     * Resend the account activation email to a specific user
     *
     * @param User $user
     * @return void
     */
    public function resendActivationEmail(User $user) {
        if ($user->register_token) {
            $user->notify(new UserCreatedNotification($user));
            Notification::make()
                ->success()
                ->title(__('Success'))
                ->body(__('An email has been sent to the user'))
                ->send();
        }
    }
}
