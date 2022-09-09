<?php

namespace App\Http\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
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
        return view('livewire.auth.login');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label('Email address')
                ->email()
                ->disableLabel()
                ->placeholder('Email address')
                ->required(),

            Password::make('password')
                ->label('Password')
                ->disableLabel()
                ->placeholder('Password')
                ->required(),

            Checkbox::make('remember')
                ->label('Remember me'),
        ];
    }

    public function login(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again in ' . $exception->secondsUntilAvailable . ' seconds.'
            ]);
        }

        $data = $this->form->getState();
        if (!Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $data['remember'])) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        redirect()->to(route('home'));

    }
}
