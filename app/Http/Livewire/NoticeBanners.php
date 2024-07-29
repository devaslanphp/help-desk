<?php

namespace App\Http\Livewire;

use App\Models\Notice;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class NoticeBanners extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedNotice;

    protected $listeners = ['noticeSaved', 'noticeDeleted'];

    public function render()
    {
        return view('livewire.notice-banners');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return Notice::query();
    }

    /**
     * Table definition
     *
     * @return array
     */
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('content')
                ->label(__('Content'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn(Notice $record) => new HtmlString('
                    <span class="px-2 py-1 rounded-full text-sm"
                        >
                            ' . $record->content . '
                        </span>
                ')),

            TextColumn::make('created_at')
                ->label(__('Created since'))
                ->sortable()
                ->searchable()
                ->dateTime()
                ->formatStateUsing(fn(Notice $record) => new HtmlString('
                    <div>
                    <span 
                        x-data="{ tooltip: false }" 
                        x-on:mouseover="tooltip = true" 
                        x-on:mouseleave="tooltip = false"
                        class="px-2 py-1 rounded-full text-sm">
                            ' . Carbon::parse($record->created_at)->diffForHumans() . '
                        <div x-show="tooltip"
                            class="text-sm text-white absolute bg-blue-400 rounded-lg p-2
                            transform -translate-y-14 translate-x-0">
                        ' . $record->created_at . '
                        </div>
                    </span>
                    </div>
                ')),
            // ToggleColumn::make('status')
            //     ->label('Active'),

            IconColumn::make('status')
                ->boolean()
                ->toggle(),
        ];
    }

    /**
     * Table actions definition
     *
     * @return array
     */
    protected function getTableActions(): array
    {
        if(auth()->user()->can('Manage notice banners'))
        return [
            Action::make('edit')
                ->icon('heroicon-o-pencil')
                ->link()
                ->label(__('Edit type'))
                ->action(fn(Notice $record) => $this->updateNotice($record->id))
        ];
        else return [];
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
     * Show update notice dialog
     *
     * @param $id
     * @return void
     */
    public function updateNotice($id)
    {
        $this->selectedNotice = Notice::find($id);
        $this->dispatchBrowserEvent('toggleNoticeModal');
    }

    /**
     * Show create notice dialog
     *
     * @return void
     */
    public function createNotice()
    {
        $this->selectedNotice = new Notice();
        $this->dispatchBrowserEvent('toggleNoticeModal');
    }

    /**
     * Cancel and close notice create / update dialog
     *
     * @return void
     */
    public function cancelNotice()
    {
        $this->selectedNotice = null;
        $this->dispatchBrowserEvent('toggleNoticeModal');
    }

    /**
     * Event launched after a notice is created / updated
     *
     * @return void
     */
    public function noticeSaved()
    {
        $this->cancelNotice();
    }

    /**
     * Event launched after a notice is deleted
     *
     * @return void
     */
    public function noticeDeleted()
    {
        $this->noticeSaved();
    }
}
