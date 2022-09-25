<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Notifications\UserActivatedNotification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Phpsa\FilamentPasswordReveal\Password;

class ActivateAccount extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.auth.activate-account');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Password::make('password')
                ->label(__('Choose a password'))
                ->disableLabel()
                ->placeholder(__('Choose a password'))
                ->required()
                ->rule('confirmed'),

            Password::make('password_confirmation')
                ->label(__('Confirm your password'))
                ->disableLabel()
                ->placeholder(__('Confirm your password'))
                ->required()
                ->dehydrated(false),
        ];
    }

    /**
     * Activate the user's account
     *
     * @return void
     */
    public function activate(): void
    {
        $data = $this->form->getState();
        $this->user->password = bcrypt($data['password']);
        $this->user->register_token = null;
        $this->user->save();
        $this->user->notify(new UserActivatedNotification());
        Auth::login($this->user);
        session()->put('locale', $this->user->locale);
        redirect()->to(route('home'));
    }
}
