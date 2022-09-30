<?php

namespace App\Http\Livewire\Administration;

use App\Core\CrudDialogHelper;
use App\Models\CompanyUser;
use App\Models\User;
use App\Notifications\UserCreatedNotification;
use Closure;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public User $user;

    protected $listeners = ['doDeleteUser', 'cancelDeleteUser'];

    public array $roles;

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'locale' => $this->user->locale ?? config('app.locale'),
            'roles' => $this->user->roles->pluck('id')->toArray(),
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
                        ->unique(
                            table: User::class,
                            column: 'email',
                            ignorable: fn() => $this->user->id ? $this->user : null
                        )
                        ->required(),
                ]),

            Grid::make(2)
                ->schema([
                    Radio::make('locale')
                        ->label(__('Default language'))
                        ->options(locales())
                        ->columnSpan(2)
                        ->required(),

                    Select::make('company')
                        ->label(__('Company'))
                        ->columnSpan(1)
                        ->visible(
                            fn() => !$this->user?->id
                                && (
                                    auth()->user()->can('View own companies')
                                    && !auth()->user()->can('View all companies')
                                )
                        )
                        ->options(fn() => auth()->user()->ownCompanies->pluck('name', 'id')->toArray()),
                ]),

            CheckboxList::make('roles')
                ->label(__('User roles'))
                ->hint(new HtmlString('
                    <div class="w-full flex items-center gap-2">
                        <button type="button"
                            class="text-xs text-primary-500 hover:text-primary-600 hover:underline"
                            wire:click="assignAllRoles">
                            ' . __('Assign all roles') . '
                        </button>
                        <span class="text-xs text-gray-300">|</span>
                        <button type="button"
                            class="text-xs text-primary-500 hover:text-primary-600 hover:underline"
                            wire:click="removeAllRoles">
                            ' . __('Remove all roles') . '
                        </button>
                    </div>
                '))
                ->options(Role::orderBy('name')->get()->pluck('name', 'id')->toArray())
        ];
    }

    /**
     * Assign all permissions
     *
     * @return void
     */
    public function assignAllRoles(): void
    {
        $this->roles = Role::all()->pluck('id')->toArray();
    }

    /**
     * Remove all assigned permissions
     *
     * @return void
     */
    public function removeAllRoles(): void
    {
        $this->roles = [];
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
                'locale' => $data['locale'],
                'password' => bcrypt(uniqid()),
                'register_token' => Uuid::uuid4()->toString()
            ]);
            $user->syncRoles($this->roles);
            $user->notify(new UserCreatedNotification($user));
            Notification::make()
                ->success()
                ->title(__('User created'))
                ->body(__('An email has been sent to the user'))
                ->send();
            if (isset($data['company'])) {
                CompanyUser::create([
                    'user_id' => $user->id,
                    'company_id' => $data['company']
                ]);
            }
        } else {
            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->locale = $data['locale'];
            $this->user->save();
            $this->user->syncRoles($this->roles);
            Notification::make()
                ->success()
                ->title(__('User updated'))
                ->body(__('The user\'s details has been updated'))
                ->send();

            if ($this->user->id == auth()->user()->id) {
                session()->put('locale', $this->user->locale);
            }
            if (isset($data['company'])) {
                CompanyUser::create([
                    'user_id' => $this->user->id,
                    'company_id' => $data['company']
                ]);
            }
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
        $this->deleteConfirmation(
            __('User deletion'),
            __('Are you sure you want to delete this user?'),
            'doDeleteUser',
            'cancelDeleteUser'
        );
    }
}
