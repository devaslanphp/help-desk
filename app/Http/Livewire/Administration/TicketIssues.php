<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketCategory;
use App\Models\TicketType;
use Carbon\Carbon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

class TicketIssues extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedIssue;

    protected $listeners = ['issueSaved', 'issueDeleted'];

    public TicketCategory $issue;

    public function render()
    {
        return view('livewire.administration.ticket-issues');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return TicketCategory::all()->where('level', 'issue')->toQuery();
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
                ->label(__('Issues'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn(TicketCategory $record) => new HtmlString('
                    <span
                        class="px-2 py-1 rounded-full text-sm flex items-center gap-2"
                        style="color: ' . $record->text_color . '; background-color: ' . $record->bg_color . '"
                    >
                    <i class="fa ' . $record->icon . '"></i>' . $record->title . '
                    </span>
                ')),
            TextColumn::make('parent_id')
                ->label(__('Subcategory'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn(TicketCategory $record) =>
                    new HtmlString('
                    <span
                        class="px-2 py-1 rounded-full text-sm flex items-center gap-2"
                        style="color: ' . $record->text_color . '; background-color: ' . $record->bg_color . '"
                    >
                    ' . $record->where('id', $record->parent_id)->pluck('title')->implode(', ') . '
                    </span>
                    ')
                ),
            TextColumn::make('type')
                ->label(__('Type'))
                ->sortable()
                ->searchable()
                ->formatStateUsing(function (TicketCategory $record) {
                    return new HtmlString('
                    <span
                        class="px-2 py-1 rounded-full text-sm flex items-center gap-2"
                        
                    >
                    ' . (TicketType::where('slug',$record->type)->first()->title ?? 'N/A') . '
                    </span>
                    ');
                }),
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
                ->label(__('Edit category'))
                ->action(fn(TicketCategory $record) => $this->updateIssue($record->id))
        ];
    }

    /**
     * Table header actions definition
     *
     * @return array
     */
    // protected function getTableHeaderActions(): array
    // {
    //     return [
    //         ExportAction::make()
    //             ->label(__('Export'))
    //             ->color('success')
    //             ->icon('heroicon-o-document-download')
    //             ->exports([
    //                 ExcelExport::make()
    //                     ->askForWriterType()
    //                     ->withFilename('ticket-subcategories-export')
    //                     ->withColumns([
    //                         Column::make('title')
    //                             ->heading(__('Title')),
    //                         Column::make('created_at')
    //                             ->heading(__('Created at'))
    //                             ->formatStateUsing(fn(Carbon $state) => $state->format(__('Y-m-d g:i A'))),
    //                     ])
    //             ])
    //     ];
    // }

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
     * Show update issue dialog
     *
     * @param $id
     * @return void
     */
    public function updateIssue($id)
    {
        $this->selectedIssue = TicketCategory::find($id);
        $this->dispatchBrowserEvent('toggleIssueModal');
    }

    /**
     * Show create issue dialog
     *
     * @return void
     */
    public function createIssue()
    {
        $this->selectedIssue = new TicketCategory();
        $this->dispatchBrowserEvent('toggleIssueModal');
    }

    /**
     * Cancel and close issue create / update dialog
     *
     * @return void
     */
    public function cancelIssue()
    {
        $this->selectedIssue = null;
        $this->dispatchBrowserEvent('toggleIssueModal');
    }

    /**
     * Event launched after a issue is created / updated
     *
     * @return void
     */
    public function issueSaved()
    {
        $this->cancelIssue();
    }

    /**
     * Event launched after a issue is deleted
     *
     * @return void
     */
    public function issueDeleted()
    {
        $this->issueSaved();
    }
}
