<?php

namespace App\Http\Livewire\Administration;

use App\Models\Icon;
use App\Models\Company;
use App\Models\User;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompaniesDialog extends Component implements HasForms
{
    use WithFileUploads, InteractsWithForms;

    public Company $company;
    public bool $deleteConfirmationOpened = false;

    protected $listeners = ['doDeleteCompany', 'cancelDeleteCompany'];

    public function mount(): void
    {
        $this->form->fill([
            'name' => $this->company->name,
            'logo' => $this->company->logo,
            'description' => $this->company->description,
            'is_disabled' => $this->company->is_disabled,
            'responsible_id' => $this->company->responsible_id,
        ]);
    }


    public function render()
    {
        return view('livewire.administration.companies-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [

            Grid::make(5)
                ->schema([

                Grid::make(1)
                    ->columnSpan(2)
                    ->schema([
                        FileUpload::make('logo')
                            ->image()
                            ->maxSize(10240)
                            ->label(__('Logo')),
                    ]),

                Grid::make(1)
                    ->columnSpan(3)
                    ->schema([

                        TextInput::make('name')
                            ->label(__('Company name'))
                            ->maxLength(255)
                            ->unique(table: Company::class, column: 'name', ignorable: fn () => $this->company, callback: function (Unique $rule) {
                                return $rule->withoutTrashed();
                            })
                            ->required(),

                        Select::make('responsible_id')
                            ->label(__('Responsible'))
                            ->searchable()
                            ->required()
                            ->options(User::all()->pluck('name', 'id')->toArray()),
                    ]),

                ]),

            RichEditor::make('description')
                ->label(__('Description'))
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('companies')
                ->fileAttachmentsVisibility('private'),

            Toggle::make('is_disabled')
                ->label(__('Disable access to this company')),
        ];
    }

    /**
     * Create / Update the company
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->company?->id) {
            $company = Company::create([
                'name' => $data['name'],
                'logo' => $data['logo'] ?? null,
                'description' => $data['description'] ?? null,
                'is_disabled' => $data['is_disabled'] ?? false,
                'responsible_id' => $data['responsible_id'],
            ]);
            Notification::make()
                ->success()
                ->title(__('Company created'))
                ->body(__('The company has been created'))
                ->send();
        } else {
            $this->company->name = $data['name'];
            $this->company->description = $data['description'];
            $this->company->logo = $data['logo'];
            $this->company->is_disabled = $data['is_disabled'];
            $this->company->responsible_id = $data['responsible_id'];
            $this->company->save();
            Notification::make()
                ->success()
                ->title(__('Company updated'))
                ->body(__("The company's details has been updated"))
                ->send();
        }
        $this->emit('companySaved');
    }

    /**
     * Delete an existing company
     *
     * @return void
     */
    public function doDeleteCompany(): void
    {
        $this->company->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('companyDeleted');
        Notification::make()
            ->success()
            ->title(__('Company deleted'))
            ->body(__('The company has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a company
     *
     * @return void
     */
    public function cancelDeleteCompany(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete company confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteCompany(): void
    {
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title(__('Company deletion'))
            ->body(__('Are you sure you want to delete this company?'))
            ->actions([
                Action::make('confirm')
                    ->label(__('Confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit('doDeleteCompany'),
                Action::make('cancel')
                    ->label(__('Cancel'))
                    ->close()
                    ->emit('cancelDeleteCompany')
            ])
            ->persistent()
            ->send();
    }
}
