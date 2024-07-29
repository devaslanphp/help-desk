<?php

namespace App\Http\Livewire;

use App\Models\Notice;
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

class Announcements extends Component implements HasTable
{
    use InteractsWithTable;


    public function render()
    {
        return view('livewire.announcements');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        $query = Notice::query();

        if (auth()->check() && !auth()->user()->can('Manage notice banners')) {
            // Filter for regular users to see only enabled notices
            $query->where('status', true);
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

}