<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Password as PasswordFacade;

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
                ->disableLabel()
                ->placeholder(__('Email address'))
                ->email()
                ->exists(table: User::class, column: 'email')
                ->required(),
        ];
    }

    /**
     * Forgot password main function
     *
     * @return void
     * @throws ValidationException
     */
    public function forgotPassword(): void
    {
        $data = $this->form->getState();
        $status = PasswordFacade::sendResetLink([
            'email' => $data['email']
        ]);
        if ($status === PasswordFacade::RESET_LINK_SENT) {
            Notification::make()
                ->success()
                ->title(__('Success'))
                ->body(__('A password recovery email has been sent'))
                ->send();
            $this->form->fill();
        } else {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }
    }
}
