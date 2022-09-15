<?php

namespace App\Http\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;

class Login extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public function mount()
    {
        $this->form->fill([
            'email' => null,
            'password' => null,
            'remember' => false
        ]);
    }

    public function render()
    {
        if (session()->get('password_reset')) {
            Notification::make()
                ->success()
                ->title(__('Success'))
                ->body(__('Your password is now updated'))
                ->send();
        }
        return view('livewire.auth.login');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(__('Email address'))
                ->email()
                ->disableLabel()
                ->placeholder(__('Email address'))
                ->required(),

            Password::make('password')
                ->label(__('Password'))
                ->disableLabel()
                ->placeholder(__('Password'))
                ->required(),

            Checkbox::make('remember')
                ->label(__('Remember me')),
        ];
    }

    /**
     * Login the user main function
     *
     * @return void
     * @throws ValidationException
     */
    public function login(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $exception->secondsUntilAvailable
                ])
            ]);
        }

        $data = $this->form->getState();
        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'])) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        session()->put('locale', auth()->user()->locale);
        redirect()->to(route('home'));

    }
}
