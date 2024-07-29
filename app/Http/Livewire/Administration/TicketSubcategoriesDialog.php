<?php

namespace App\Http\Livewire\Administration;

use App\Core\CrudDialogHelper;
use App\Models\TicketCategory;
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

class TicketSubcategoriesDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public TicketCategory $subcategory;

    protected $listeners = ['doDeleteSubcategory', 'cancelDeleteSubcategory'];

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->subcategory->title,
            'parent_id' => TicketCategory::getCategoriesByParentId($this->subcategory->parent_id),
            'text_color' => $this->subcategory->text_color,
            'bg_color' => $this->subcategory->bg_color,
        ]);
    }

    public function render()
    {
        return view('livewire.administration.ticket-subcategories-dialog');
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
                ->label(__('Category'))
                ->required()
                ->searchable()
                ->options(fn () => TicketCategory::whereNull('parent_id')->pluck('title','id')->toArray()),
            TextInput::make('title')
                ->label(__('Subcategory name'))
                ->maxLength(255)
                ->unique(
                    table: TicketCategory::class,
                    column: 'title',
                    ignorable: fn () => $this->subcategory,
                    callback: function (Unique $rule)
                    {
                        return $rule->withoutTrashed();
                    }
                )
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
        if (!$this->subcategory?->id) {
                TicketCategory::create([
                    'title' => $data['title'],
                    'parent_id' => $data['parent_id'],
                    'text_color' => TicketCategory::where('id',$parent)->pluck('text_color')->first(),
                    'bg_color' => TicketCategory::where('id',$parent)->pluck('bg_color')->first(),
                    'slug' => Str::slug($data['title'], '_'),
                    'level' => 'subcategory'
                ]);
            Notification::make()
                ->success()
                ->title(__('Subcategory created'))
                ->body(__('The subcategory has been created'))
                ->send();
        } else {
            $this->subcategory->title = $data['title'];
            $this->subcategory->parent_id = $data['parent_id'];
            $this->subcategory->text_color = TicketCategory::where('id',$parent)->pluck('text_color')->first();
            $this->subcategory->bg_color = TicketCategory::where('id',$parent)->pluck('bg_color')->first();
            $this->subcategory->save();
            Notification::make()
                ->success()
                ->title(__('Category updated'))
                ->body(__('The category\'s details has been updated'))
                ->send();
        }
        $this->emit('subcategorySaved');
    }

    /**
     * Delete an existing category
     *
     * @return void
     */
    public function doDeleteSubcategory(): void
    {
        $this->subcategory->delete();
        $this->deleteConfirmationOpened = false;
        $this->dispatchBrowserEvent('toggleSubcategoryModal');
        redirect()->to('/administration/ticket-subcategories');
        Notification::make()
            ->success()
            ->title(__('Subcategory deleted'))
            ->body(__('The subcategory has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a subcategory
     *
     * @return void
     */
    public function cancelDeleteSubcategory(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete subcategory confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteSubcategory(): void
    {
        $this->deleteConfirmation(
            __('Subcategory deletion'),
            __('Are you sure you want to delete this subcategory?'),
            'doDeleteSubcategory',
            'cancelDeleteSubcategory'
        );
    }
}
