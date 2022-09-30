<?php

namespace App\Http\Livewire\Administration;

use App\Models\Company;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Spatie\Permission\Models\Role;

class Roles extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedRole;

    protected $listeners = ['roleSaved', 'roleDeleted'];

    public function render()
    {
        return view('livewire.administration.roles');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        $query = Role::query();
        $query->orderBy('created_at', 'desc');
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
            TextColumn::make('name')
                ->label(__('Role name'))
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
                ->label(__('Edit role'))
                ->visible(fn () => auth()->user()->can('Update user roles'))
                ->action(fn(Role $record) => $this->updateRole($record->id))
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
                        ->withFilename('user-roles-export')
                        ->withColumns([
                            Column::make('name')
                                ->heading(__('Role name')),
                            Column::make('permissions')
                                ->heading(__('Permissions'))
                                ->formatStateUsing(
                                    fn (Role $record) => $record->permissions->pluck('name')->join(', ')
                                ),
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
     * Show update role dialog
     *
     * @param $id
     * @return void
     */
    public function updateRole($id)
    {
        $this->selectedRole = Role::find($id);
        $this->dispatchBrowserEvent('toggleRoleModal');
    }

    /**
     * Show create role dialog
     *
     * @return void
     */
    public function createRole()
    {
        $this->selectedRole = new Role();
        $this->dispatchBrowserEvent('toggleRoleModal');
    }

    /**
     * Cancel and close role create / update dialog
     *
     * @return void
     */
    public function cancelRole()
    {
        $this->selectedRole = null;
        $this->dispatchBrowserEvent('toggleRoleModal');
    }

    /**
     * Event launched after a role is created / updated
     *
     * @return void
     */
    public function roleSaved()
    {
        $this->cancelRole();
    }

    /**
     * Event launched after a role is deleted
     *
     * @return void
     */
    public function roleDeleted()
    {
        $this->roleSaved();
    }
}
