<?php

namespace App\Http\Livewire\Administration;

use App\Core\CrudDialogHelper;
use App\Models\TicketCategory;
use App\Models\TicketType;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class TicketIssuesDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public TicketCategory $issue;

    protected $listeners = ['doDeleteIssue', 'cancelDeleteIssue'];

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->issue->title,
            'parent_id' => TicketCategory::getCategoriesByParentId($this->issue->parent_id),
            'text_color' => $this->issue->text_color,
            'bg_color' => $this->issue->bg_color,
            'type' => $this->issue->type,
        ]);
    }

    public function render()
    {
        return view('livewire.administration.ticket-issues-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Select::make('parent_id')
                ->label(__('Subcategory'))
                ->required()
                ->searchable()
                ->options(fn () => TicketCategory::where('level','subcategory')->pluck('title','id')->toArray()),
            TextInput::make('title')
                ->label(__('Issue name'))
                ->maxLength(255)
                ->unique(
                    table: TicketCategory::class,
                    column: 'title',
                    ignorable: fn () => $this->issue,
                    callback: function (Unique $rule)
                    {
                        return $rule->withoutTrashed();
                    }
                )
                ->required(),
            Select::make('type')
                ->label(__('Type'))
                ->options(fn () => TicketType::pluck('title','slug')->toArray())
                ->required(),
        ];
    }

    /**
     * Create / Update the category
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $parent = $data['parent_id'];
        if (!$this->issue?->id) {
                TicketCategory::create([
                    'title' => $data['title'],
                    'parent_id' => $data['parent_id'],
                    'text_color' => TicketCategory::where('id',$parent)->pluck('text_color')->first(),
                    'bg_color' => TicketCategory::where('id',$parent)->pluck('bg_color')->first(),
                    'slug' => Str::slug($data['title'], '_'),
                    'type' => $data['type'],
                    'level' => 'issue'
                ]);
            Notification::make()
                ->success()
                ->title(__('Issue created'))
                ->body(__('The issue has been created'))
                ->send();
        } else {
            $this->issue->title = $data['title'];
            $this->issue->parent_id = $data['parent_id'];
            $this->issue->text_color = TicketCategory::where('id',$parent)->pluck('text_color')->first();
            $this->issue->bg_color = TicketCategory::where('id',$parent)->pluck('bg_color')->first();
            $this->issue->type = $data['type'];
            $this->issue->save();
            Notification::make()
                ->success()
                ->title(__('Category updated'))
                ->body(__('The category\'s details has been updated'))
                ->send();
        }
        $this->emit('issueSaved');
    }

    /**
     * Delete an existing issue
     *
     * @return void
     */
    public function doDeleteIssue(): void
    {
        $this->issue->delete();
        $this->deleteConfirmationOpened = false;
        $this->dispatchBrowserEvent('toggleIssueModal');
        redirect()->to('/administration/ticket-issues');
        Notification::make()
            ->success()
            ->title(__('Issue deleted'))
            ->body(__('The issue has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a issue
     *
     * @return void
     */
    public function cancelDeleteIssue(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete issue confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteIssue(): void
    {
        $this->deleteConfirmation(
            __('Issue deletion'),
            __('Are you sure you want to delete this issue?'),
            'doDeleteIssue',
            'cancelDeleteIssue'
        );
    }
}
