<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketPriority;
use App\Models\User;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
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

class TicketPriorities extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedPriority;

    protected $listeners = ['prioritySaved', 'priorityDeleted'];

    public function render()
    {
        return view('livewire.administration.ticket-priorities');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return TicketPriority::query();
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
                ->formatStateUsing(fn(TicketPriority $record) => new HtmlString('
                    <span
                        class="px-2 py-1 rounded-full text-sm flex items-center gap-2"
                        style="color: ' . $record->text_color . '; background-color: ' . $record->bg_color . '"
                    >
                    <i class="fa ' . $record->icon . '"></i>' . $record->title . '
                    </span>
                ')),

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
                ->label(__('Edit priority'))
                ->action(fn(TicketPriority $record) => $this->updatePriority($record->id))
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
                        ->withFilename('ticket-priorities-export')
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
     * Show update priority dialog
     *
     * @param $id
     * @return void
     */
    public function updatePriority($id)
    {
        $this->selectedPriority = TicketPriority::find($id);
        $this->dispatchBrowserEvent('togglePriorityModal');
    }

    /**
     * Show create priority dialog
     *
     * @return void
     */
    public function createPriority()
    {
        $this->selectedPriority = new TicketPriority();
        $this->dispatchBrowserEvent('togglePriorityModal');
    }

    /**
     * Cancel and close priority create / update dialog
     *
     * @return void
     */
    public function cancelPriority()
    {
        $this->selectedPriority = null;
        $this->dispatchBrowserEvent('togglePriorityModal');
    }

    /**
     * Event launched after a priority is created / updated
     *
     * @return void
     */
    public function prioritySaved()
    {
        $this->cancelPriority();
    }

    /**
     * Event launched after a priority is deleted
     *
     * @return void
     */
    public function priorityDeleted()
    {
        $this->prioritySaved();
    }
}
