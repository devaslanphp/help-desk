<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketCategory;
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

class TicketCategories extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedCategory;

    protected $listeners = ['categorySaved', 'categoryDeleted'];

    public TicketCategory $category;
 


    public function render()
    {
        return view('livewire.administration.ticket-categories');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return TicketCategory::all()->whereNull('parent_id')->toQuery();
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
                ->label(__('Category'))
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
    
            // TextColumn::make('parent_id')
            //     ->label(__('Subcategories'))
            //     ->searchable()
            //     ->sortable()
            //     ->formatStateUsing(fn(TicketCategory $record) => new HtmlString('
            //         <span
            //             class="px-2 py-1 rounded-full text-sm flex items-center gap-2"
            //             style="color: ' . $record->text_color . '; background-color: ' . $record->bg_color . '"
            //         >
            //         ' . $record->where('parent_id',$record->id)->pluck('title')->implode(', ') . '
            //         </span>
            //     ')),

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
                ->action(fn(TicketCategory $record) => $this->updateCategory($record->id))
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
    //                     ->withFilename('ticket-categories-export')
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
     * Show update category dialog
     *
     * @param $id
     * @return void
     */
    public function updateCategory($id)
    {
        $this->selectedCategory = TicketCategory::find($id);
        $this->dispatchBrowserEvent('toggleCategoryModal');
    }

    /**
     * Show create category dialog
     *
     * @return void
     */
    public function createCategory()
    {
        $this->selectedCategory = new TicketCategory();
        $this->dispatchBrowserEvent('toggleCategoryModal');
    }

    /**
     * Cancel and close category create / update dialog
     *
     * @return void
     */
    public function cancelCategory()
    {
        $this->selectedCategory = null;
        $this->dispatchBrowserEvent('toggleCategoryModal');
    }

    /**
     * Event launched after a category is created / updated
     *
     * @return void
     */
    public function categorySaved()
    {
        $this->cancelCategory();
    }

    /**
     * Event launched after a category is deleted
     *
     * @return void
     */
    public function categoryDeleted()
    {
        $this->selectedCategory->delete();
        
    }
}
