<?php

namespace App\Http\Livewire\Administration;

use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
        $query = User::query();
        if (auth()->user()->can('View company users') && !auth()->user()->can('View all users')) {
            $query->whereHas(
                'companies',
                fn($query) => $query->whereIn(
                    'companies.id',
                    auth()->user()->ownCompanies->pluck('id')->toArray()
                )
            );
        } elseif (!auth()->user()->can('View all users')) {
            // Get empty list
            $query->whereNull('id');
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
            TextColumn::make('name')
                ->label(__('Full name'))
                ->searchable()
                ->sortable(),

            BooleanColumn::make('isAccountActivated')
                ->label(__('Account activated')),

            TagsColumn::make('roles.name')
                ->label(__('User roles'))
                ->limit(1)
                ->visible(fn() => auth()->user()->can('Assign permissions'))
                ->searchable()
                ->sortable(),

            TagsColumn::make('companies.name')
                ->label(__('Companies'))
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
                ->visible(fn(User $record) => $record->register_token && auth()->user()->can('Update users'))
                ->action(fn(User $record) => $this->resendActivationEmail($record->id)),

            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->link()
                ->label(__('Edit user'))
                ->visible(fn() => auth()->user()->can('Update users'))
                ->action(fn(User $record) => $this->updateUser($record->id))
        ];
    }

    /**
     * Table header actions definition
     *
     * @return array
     */
    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label(__('Export'))
                ->color('success')
                ->icon('heroicon-o-document-download')
                ->exports([
                    ExcelExport::make()
                        ->askForWriterType()
                        ->withFilename('users-export')
                        ->withColumns([
                            Column::make('name')
                                ->heading(__('Full name')),
                            Column::make('companies')
                                ->heading(__('Companies'))
                                ->formatStateUsing(
                                    fn(User $record) => $record->companies->pluck('name')->join(', ')
                                ),
                            Column::make('roles')
                                ->heading(__('User roles'))
                                ->formatStateUsing(
                                    fn(User $record) => $record->roles->pluck('name')->join(', ')
                                ),
                            Column::make('created_at')
                                ->heading(__('Created at'))
                                ->formatStateUsing(fn(Carbon $state) => $state->format(__('Y-m-d g:i A'))),
                        ])
                ])
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
     * Table filters definition
     *
     * @return array
     */
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('isAccountActivated')
                ->label(__('Account activated'))
                ->placeholder(__('All users'))
                ->options([
                    'yes' => __('Yes'),
                    'no' => __('No'),
                ])
                ->query(function ($state, $query) {
                    if ($state['value'] === 'yes') {
                        $query->whereNull('register_token');
                    }
                    if ($state['value'] === 'no') {
                        $query->whereNotNull('register_token');
                    }
                })
        ];
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
