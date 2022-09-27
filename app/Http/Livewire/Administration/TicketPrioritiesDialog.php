<?php

namespace App\Http\Livewire\Administration;

use App\Core\CrudDialogHelper;
use App\Models\Icon;
use App\Models\TicketPriority;
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

class TicketPrioritiesDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public TicketPriority $priority;

    protected $listeners = ['doDeletePriority', 'cancelDeletePriority'];

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->priority->title,
            'text_color' => $this->priority->text_color,
            'bg_color' => $this->priority->bg_color,
            'icon' => $this->priority->icon,
        ]);
    }


    public function render()
    {
        return view('livewire.administration.ticket-priorities-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->label(__('Title'))
                ->maxLength(255)
                ->unique(
                    table: TicketPriority::class,
                    column: 'title',
                    ignorable: fn () => $this->priority,
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

            Select::make('icon')
                ->label(__('Icon'))
                ->reactive()
                ->searchable()
                ->required()
                ->getSearchResultsUsing(
                    fn (string $search) =>
                        Icon::where('icon', 'like', "%{$search}%")
                            ->limit(50)
                            ->pluck('icon', 'icon')
                )
                ->getOptionLabelUsing(fn ($value): ?string => Icon::where('icon', $value)->first()?->icon)
                ->hint(
                    fn (Closure $get) =>
                        $get('icon') ?
                            new HtmlString(
                                __('Selected icon:')
                                . ' <i class="fa fa-2x '
                                . $get('icon')
                                . '"></i>'
                            )
                            :
                            ''
                )
                ->helperText(
                    new HtmlString(
                        __("Check the <a href='https://fontawesome.com/icons'
                                    target='_blank' class='text-blue-500 underline'>
                                    fontawesome icons here
                                </a> to choose your right icon"
                        )
                    )
                ),
        ];
    }

    /**
     * Create / Update the priority
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->priority?->id) {
            TicketPriority::create([
                'title' => $data['title'],
                'text_color' => $data['text_color'],
                'bg_color' => $data['bg_color'],
                'icon' => $data['icon'],
                'slug' => Str::slug($data['title'], '_')
            ]);
            Notification::make()
                ->success()
                ->title(__('Priority created'))
                ->body(__('The priority has been created'))
                ->send();
        } else {
            $this->priority->title = $data['title'];
            $this->priority->text_color = $data['text_color'];
            $this->priority->bg_color = $data['bg_color'];
            $this->priority->icon = $data['icon'];
            $this->priority->save();
            Notification::make()
                ->success()
                ->title(__('Priority updated'))
                ->body(__('The priority\'s details has been updated'))
                ->send();
        }
        $this->emit('prioritySaved');
    }

    /**
     * Delete an existing priority
     *
     * @return void
     */
    public function doDeletePriority(): void
    {
        $this->priority->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('priorityDeleted');
        Notification::make()
            ->success()
            ->title(__('Priority deleted'))
            ->body(__('The priority has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a priority
     *
     * @return void
     */
    public function cancelDeletePriority(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete priority confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deletePriority(): void
    {
        $this->deleteConfirmation(
            __('Priority deletion'),
            __('Are you sure you want to delete this priority?'),
            'doDeletePriority',
            'cancelDeletePriority'
        );
    }
}
