<?php

namespace App\Http\Livewire\Administration;

use App\Models\Company;
use App\Tables\Columns\UserColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Companies extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedCompany;

    protected $listeners = ['companySaved', 'companyDeleted'];

    public function render()
    {
        return view('livewire.administration.companies');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return Company::query();
    }

    /**
     * Table definition
     *
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('logo')
                ->label(__('Logo'))
                ->height(30),

            TextColumn::make('name')
                ->label(__('Company name'))
                ->searchable()
                ->sortable(),

            UserColumn::make('responsible')
                ->label(__('Responsible'))
                ->searchable()
                ->sortable(),

            BooleanColumn::make('is_disabled')
                ->label(__('Company activated'))
                ->trueIcon('heroicon-o-x-circle')
                ->falseIcon('heroicon-o-check-circle')
                ->trueColor('danger')
                ->falseColor('success')
                ->searchable()
                ->sortable(),

            TextColumn::make('created_at')
                ->label(__('Created at'))
                ->sortable()
                ->searchable()
                ->dateTime(),
        ];
    }

    /**
     * Table actions definition
     *
     * @return array
     */
    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->link()
                ->label(__('Edit company'))
                ->action(fn(Company $record) => $this->updateCompany($record->id))
        ];
    }

    /**
     * Table default sort column definition
     *
     * @return string|null
     */
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    /**
     * Table default sort direction definition
     *
     * @return string|null
     */
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    /**
     * Show update company dialog
     *
     * @param $id
     * @return void
     */
    public function updateCompany($id)
    {
        $this->selectedCompany = Company::find($id);
        $this->dispatchBrowserEvent('toggleCompanyModal');
    }

    /**
     * Show create company dialog
     *
     * @return void
     */
    public function createCompany()
    {
        $this->selectedCompany = new Company();
        $this->dispatchBrowserEvent('toggleCompanyModal');
    }

    /**
     * Cancel and close company create / update dialog
     *
     * @return void
     */
    public function cancelCompany()
    {
        $this->selectedCompany = null;
        $this->dispatchBrowserEvent('toggleCompanyModal');
    }

    /**
     * Event launched after a company is created / updated
     *
     * @return void
     */
    public function companySaved()
    {
        $this->cancelCompany();
    }

    /**
     * Event launched after a company is deleted
     *
     * @return void
     */
    public function companyDeleted()
    {
        $this->companySaved();
    }
}
