<?php

namespace App\Http\Livewire;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class UsersDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public User $user;

    public function mount(): void {
        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
        ]);
    }

    public function render()
    {
        return view('livewire.users-dialog');
    }

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
                ->unique(table: User::class, column: 'email', ignorable: fn () => $this->user->id ? $this->user : null)
                ->required()
        ];
    }

    public function save(): void {
        $data = $this->form->getState();
        dd($data);
    }

    public function deleteUser(): void {
        dd($this->user);
    }
}
