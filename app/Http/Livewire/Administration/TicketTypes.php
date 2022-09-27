<?php

namespace App\Http\Livewire\Administration;

use App\Models\TicketType;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class TicketTypes extends Component implements HasTable
{
    use InteractsWithTable;

    public $selectedType;

    protected $listeners = ['typeSaved', 'typeDeleted'];

    public function render()
    {
        return view('livewire.administration.ticket-types');
    }

    /**
     * Table query definition
     *
     * @return Builder|Relation
     */
    protected function getTableQuery(): Builder|Relation
    {
        return TicketType::query();
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
                ->formatStateUsing(fn(TicketType $record) => new HtmlString('
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
                ->label(__('Edit type'))
                ->action(fn(TicketType $record) => $this->updateType($record->id))
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
     * Show update type dialog
     *
     * @param $id
     * @return void
     */
    public function updateType($id)
    {
        $this->selectedType = TicketType::find($id);
        $this->dispatchBrowserEvent('toggleTypeModal');
    }

    /**
     * Show create type dialog
     *
     * @return void
     */
    public function createType()
    {
        $this->selectedType = new TicketType();
        $this->dispatchBrowserEvent('toggleTypeModal');
    }

    /**
     * Cancel and close type create / update dialog
     *
     * @return void
     */
    public function cancelType()
    {
        $this->selectedType = null;
        $this->dispatchBrowserEvent('toggleTypeModal');
    }

    /**
     * Event launched after a type is created / updated
     *
     * @return void
     */
    public function typeSaved()
    {
        $this->cancelType();
    }

    /**
     * Event launched after a type is deleted
     *
     * @return void
     */
    public function typeDeleted()
    {
        $this->typeSaved();
    }
}

