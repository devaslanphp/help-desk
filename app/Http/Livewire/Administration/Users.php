<?php

namespace App\Http\Livewire\Administration;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Filament\Forms\Components\TagsInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class Users extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedUser;

    protected $listeners = ['userSaved', 'userDeleted'];

    public function render()
    {
        return view('livewire.administration.users');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return User::query();
    }

    /**
     * Table definition
     *
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('Full name'))
                ->searchable()
                ->sortable(),

            BooleanColumn::make('isAccountActivated')
                ->label(__('Account activated'))
                ->sortable()
                ->searchable(),

            TagsColumn::make('permissions.name')
                ->label(__('Permissions'))
                ->limit(1)
                ->searchable()
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
            Action::make('resend_email_registration')
                ->icon('heroicon-o-at-symbol')
                ->link()
                ->color('warning')
                ->label(__('Resend activation email'))
                ->visible(fn(User $record) => $record->register_token)
                ->action(fn(User $record) => $this->resendActivationEmail($record->id)),

            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->link()
                ->label(__('Edit user'))
                ->action(fn(User $record) => $this->updateUser($record->id))
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
    public function userSaved()
    {
        $this->cancelUser();
    }

    /**
     * Event launched after a user is deleted
     *
     * @return void
     */
    public function userDeleted()
    {
        $this->userSaved();
    }

    /**
     * Resend the account activation email to a specific user
     *
     * @param int $userId
     * @return void
     */
    public function resendActivationEmail(int $userId)
    {
        $user = User::find($userId);
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
