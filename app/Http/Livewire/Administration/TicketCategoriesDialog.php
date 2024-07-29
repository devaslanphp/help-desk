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

class TicketCategoriesDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public TicketCategory $category;

    protected $listeners = ['doDeleteCategory', 'cancelDeleteCategory'];

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->category->title,
            'parent_id' => $this->category->parent_id,
            'text_color' => $this->category->text_color,
            'bg_color' => $this->category->bg_color,
        ]);
    }

    public function render()
    {
        return view('livewire.administration.ticket-categories-dialog');
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
                ->label(__('Note: Select Category only when creating Subcategory'))
                ->searchable()
                ->options(categories_list('id')),
            TextInput::make('title')
                ->label(__('Category / Subcategory name'))
                ->maxLength(255)
                ->unique(
                    table: TicketCategory::class,
                    column: 'title',
                    ignorable: fn () => $this->category,
                    callback: function (Unique $rule)
                    {
                        return $rule->withoutTrashed();
                    }
                )
                ->required(),
            ColorPicker::make('text_color')
                ->label(__('Text color'))
                ->required(),

            ColorPicker::make('bg_color')
                ->label(__('Background color'))
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
        if (!$this->category?->id) {
            if(!$data['parent_id']) {
                TicketCategory::create([
                    'title' => $data['title'],
                    'parent_id' => null,
                    'text_color' => $data['text_color'],
                    'bg_color' => $data['bg_color'],
                    'slug' => Str::slug($data['title'], '_'),
                    'level' => 'category'
                ]);
            Notification::make()
                ->success()
                ->title(__('Category created'))
                ->body(__('The category has been created'))
                ->send();

            }else{
                $parent = $data['parent_id'];
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
            }
        } else {
            $this->category->title = $data['title'];
            $this->category->parent_id = $data['parent_id'];
            $this->category->text_color = $data['text_color'];
            $this->category->bg_color = $data['bg_color'];
            $this->category->save();

        // Fetch the ticket subcategories in a single query
        $category_id = TicketCategory::where('slug', Str::slug($data['title'], '_'))->pluck('id')->first();
        $subcategories = TicketCategory::where('parent_id', $category_id)->get();

        foreach ($subcategories as $subcategory) {
            // Apply the value to the subcategory (e.g., updating a specific field)
            $subcategory->update([
                'text_color' => $data['text_color'], 
                'bg_color' => $data['bg_color'], 
            ]);
        }

            Notification::make()
                ->success()
                ->title(__('Category updated'))
                ->body(__('The category\'s details has been updated'))
                ->send();
        }
        $this->emit('categorySaved');
    }

    /**
     * Delete an existing category
     *
     * @return void
     */
    public function doDeleteCategory(): void
    {
        $this->category->delete();
        $this->deleteConfirmationOpened = false;
        
        $this->dispatchBrowserEvent('toggleCategoryModal');
        redirect()->to('/administration/ticket-categories');
        
        Notification::make()
            ->success()
            ->title(__('Category deleted'))
            ->body(__('The category has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a category
     *
     * @return void
     */
    public function cancelDeleteCategory(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete category confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteCategory(): void
    {
        $this->deleteConfirmation(
            __('Category deletion'),
            __('Are you sure you want to delete this category?'),
            'doDeleteCategory',
            'cancelDeleteCategory'
        );
    }
}
