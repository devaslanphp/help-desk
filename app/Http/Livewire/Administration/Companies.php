<?php

namespace App\Http\Livewire\Administration;

use App\Models\Company;
use App\Tables\Columns\UserColumn;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
        $query = Company::query();
        if (auth()->user()->can('View own companies') && !auth()->user()->can('View all companies')) {
            $query->where('responsible_id', auth()->user()->id);
        } elseif (!auth()->user()->can('View all companies')) {
            // Get empty list
            $query->whereNull('id');
        }
        return $query;
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

            TagsColumn::make('users.name')
                ->label(__('Company users'))
                ->limit(1)
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
                ->visible(fn () => auth()->user()->can('Update companies'))
                ->action(fn(Company $record) => $this->updateCompany($record->id))
        ];
    }

    /**
     * Table header actions definition
     *
     * @return array
     */
    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label(__('Export'))
                ->color('success')
                ->icon('heroicon-o-document-download')
                ->exports([
                    ExcelExport::make()
                        ->askForWriterType()
                        ->withFilename('companies-export')
                        ->withColumns([
                            Column::make('name')
                                ->heading(__('Company name')),
                            Column::make('responsible.name')
                                ->heading(__('Responsible')),
                            Column::make('is_disabled')
                                ->heading(__('Company activated'))
                                ->formatStateUsing(fn (bool $state) => $state ? __('No') : __('Yes')),
                            Column::make('users')
                                ->heading(__('Company users'))
                                ->formatStateUsing(fn (Company $record) => $record->users->pluck('name')->join(', ')),
                            Column::make('created_at')
                                ->heading(__('Created at'))
                                ->formatStateUsing(fn (Carbon $state) => $state->format(__('Y-m-d g:i A'))),
                        ])
                ])
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
