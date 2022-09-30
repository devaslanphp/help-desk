<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketStatus;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class TicketStatuses extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedStatus;

    protected $listeners = ['statusSaved', 'statusDeleted'];

    public function render()
    {
        return view('livewire.administration.ticket-statuses');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return TicketStatus::query();
    }

    /**
     * Table definition
     *
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(__('Title'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn(TicketStatus $record) => new HtmlString('
                    <span class="px-2 py-1 rounded-full text-sm"
                        style="color: ' . $record->text_color . '; background-color: ' . $record->bg_color . '">
                            ' . $record->title . '
                        </span>
                ')),

            BooleanColumn::make('default')
                ->label(__('Default status'))
                ->sortable()
                ->searchable(),

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
                ->label(__('Edit status'))
                ->action(fn(TicketStatus $record) => $this->updateStatus($record->id))
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
                        ->withFilename('ticket-statuses-export')
                        ->withColumns([
                            Column::make('title')
                                ->heading(__('Title')),
                            Column::make('created_at')
                                ->heading(__('Created at'))
                                ->formatStateUsing(fn(Carbon $state) => $state->format(__('Y-m-d g:i A'))),
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
     * Show update status dialog
     *
     * @param $id
     * @return void
     */
    public function updateStatus($id)
    {
        $this->selectedStatus = TicketStatus::find($id);
        $this->dispatchBrowserEvent('toggleStatusModal');
    }

    /**
     * Show create status dialog
     *
     * @return void
     */
    public function createStatus()
    {
        $this->selectedStatus = new TicketStatus();
        $this->dispatchBrowserEvent('toggleStatusModal');
    }

    /**
     * Cancel and close status create / update dialog
     *
     * @return void
     */
    public function cancelStatus()
    {
        $this->selectedStatus = null;
        $this->dispatchBrowserEvent('toggleStatusModal');
    }

    /**
     * Event launched after a status is created / updated
     *
     * @return void
     */
    public function statusSaved()
    {
        $this->cancelStatus();
    }

    /**
     * Event launched after a status is deleted
     *
     * @return void
     */
    public function statusDeleted()
    {
        $this->statusSaved();
    }
}
