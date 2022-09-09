<?php

namespace App\Http\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;

class ForgotPassword extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount()
    {
        $this->form->fill([]);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label('Email address')
                ->prefixIcon('heroicon-o-at-symbol')
                ->email()
                ->required(),
        ];
    }

    public function forgotPassword(): void
    {
        $data = $this->form->getState();
        dd($data);
    }
}
