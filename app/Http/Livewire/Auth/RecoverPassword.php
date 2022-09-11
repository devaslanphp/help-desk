<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;
use Illuminate\Support\Facades\Password as PasswordFacade;

class RecoverPassword extends Component implements HasForms
{
    use InteractsWithForms;

    public $token;

    public function mount(string $token)
    {
        $this->token = $token;
        $this->form->fill([
            'email' => request()->get('email') ?? null,
            'password' => null,
            'password_confirmation' => null
        ]);
    }

    public function render()
    {
        return view('livewire.auth.recover-password');
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

            Password::make('password')
                ->label(__('New password'))
                ->rule('confirmed')
                ->disableLabel()
                ->placeholder(__('New password'))
                ->required(),

            Password::make('password_confirmation')
                ->label(__('Password confirmation'))
                ->disableLabel()
                ->placeholder(__('Password confirmation'))
                ->required(),
        ];
    }

    /**
     * Recover a password main function
     *
     * @return void
     * @throws ValidationException
     */
    public function recoverPassword(): void
    {
        $data = $this->form->getState();

        $status = PasswordFacade::reset([
            'email' => $data['email'],
            'password' => $data['password'],
            'password_confirmation' => $data['password_confirmation'],
            'token' => $this->token
        ], function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });

        if ($status === PasswordFacade::PASSWORD_RESET) {
            session()->flash('password_reset', true);
            redirect()->to(route('auth.login'));
        } else {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }
    }
}
