<?php

namespace App\Http\Livewire;

use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;
use Closure;

class MyProfile extends Component implements HasForms
{
    use InteractsWithForms;

    public User|Authenticatable|null $user;

    public function mount(): void
    {
        $this->initProfile();
    }

    public function render()
    {
        return view('livewire.my-profile');
    }

    /**
     * Initialize form data
     *
     * @return void
     */
    private function initProfile(): void
    {
        $this->user = User::where('id', auth()->user()->id)->first();
        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'locale' => $this->user->locale,
        ]);
        if (session()->has('profile_updated')) {
            Notification::make()
                ->success()
                ->title(__('Profile updated'))
                ->body(__('Your account details has been updated'))
                ->send();
        }
    }

    /**
     * Form schema definiation
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
                ->unique(table: User::class, column: 'email', ignorable: fn() => $this->user->id ? $this->user : null)
                ->required(),

            Password::make('current_password')
                ->label(__('Current password'))
                ->required(),

            Grid::make()
                ->schema([
                    Password::make('new_password')
                        ->label(__('New password'))
                        ->rule('confirmed'),

                    Password::make('new_password_confirmation')
                        ->label(__('Password confirmation'))
                        ->dehydrated(false),
                ]),

            Grid::make(1)
                ->schema([
                    Radio::make('locale')
                        ->label(__('Default language'))
                        ->options(locales())
                        ->required()
                ]),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        if (Hash::check($data['current_password'], $this->user->password)) {
            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->locale = $data['locale'];
            if ($data['new_password']) {
                $this->user->password = bcrypt($data['new_password']);
            }
            $this->user->save();
            session()->put('locale', $this->user->locale);
            session()->flash('profile_updated', true);
            redirect()->to(route('my-profile'));
        } else {
            throw ValidationException::withMessages([
                'current_password' => __('The password entered is incorrect.')
            ]);
        }
    }
}
