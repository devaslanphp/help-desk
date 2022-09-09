<?php

namespace App\Http\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;

class RecoverPassword extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount(string $token)
    {
        $this->form->fill([]);
    }

    public function render()
    {
        return view('livewire.auth.recover-password');
    }

    protected function getFormSchema(): array
    {
        return [
            Password::make('password')
                ->label('New password')
                ->rule('confirmed')
                ->prefixIcon('heroicon-o-lock-closed')
                ->required(),

            Password::make('password_confirmation')
                ->label('Password confirmation')
                ->prefixIcon('heroicon-o-lock-closed')
                ->required()
                ->dehydrated(false),
        ];
    }

    public function recoverPassword(): void
    {
        $data = $this->form->getState();
        dd($data);
    }
}
