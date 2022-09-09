<?php

namespace App\Http\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;

class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount()
    {
        $this->form->fill([]);
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
                ->prefixIcon('heroicon-o-at-symbol')
                ->required(),

            Password::make('password')
                ->label('Password')
                ->prefixIcon('heroicon-o-lock-closed')
                ->required(),

            Checkbox::make('remember_me')
                ->label('Remember me'),
        ];
    }

    public function login(): void
    {
        $data = $this->form->getState();
        dd($data);
    }
}
