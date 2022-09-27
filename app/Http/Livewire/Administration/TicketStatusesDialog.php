<?php

namespace App\Http\Livewire\Administration;

use App\Core\CrudDialogHelper;
use App\Models\TicketStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class TicketStatusesDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public TicketStatus $status;

    protected $listeners = ['doDeleteStatus', 'cancelDeleteStatus'];

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->status->title,
            'text_color' => $this->status->text_color,
            'bg_color' => $this->status->bg_color,
            'default' => $this->status->default,
        ]);
    }


    public function render()
    {
        return view('livewire.administration.ticket-statuses-dialog');
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
                    table: TicketStatus::class,
                    column: 'title',
                    ignorable: fn() => $this->status,
                    callback: function (Unique $rule) {
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

            Checkbox::make('default')
                ->label(__('Default status'))
                ->helperText(__('Check this box if this status should be assigned by default to new tickets')),
        ];
    }

    /**
     * Create / Update the status
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->status?->id) {
            $status = TicketStatus::create([
                'title' => $data['title'],
                'text_color' => $data['text_color'],
                'bg_color' => $data['bg_color'],
                'default' => $data['default'],
                'slug' => Str::slug($data['title'], '_')
            ]);
            Notification::make()
                ->success()
                ->title(__('Status created'))
                ->body(__('The status has been created'))
                ->send();
            if ($status->default) {
                TicketStatus::where('id', '<>', $status->id)->update(['default' => false]);
            }
        } else {
            $this->status->title = $data['title'];
            $this->status->text_color = $data['text_color'];
            $this->status->bg_color = $data['bg_color'];
            $this->status->default = $data['default'];
            $this->status->save();
            Notification::make()
                ->success()
                ->title(__('Status updated'))
                ->body(__('The status\'s details has been updated'))
                ->send();
            TicketStatus::where('id', '<>', $this->status->id)->update(['default' => false]);
        }
        if (TicketStatus::where('default', true)->count() === 0) {
            $first = TicketStatus::first();
            $first->default = true;
            $first->save();
        }
        $this->emit('statusSaved');
    }

    /**
     * Delete an existing status
     *
     * @return void
     */
    public function doDeleteStatus(): void
    {
        $this->status->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('statusDeleted');
        Notification::make()
            ->success()
            ->title(__('Status deleted'))
            ->body(__('The status has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a status
     *
     * @return void
     */
    public function cancelDeleteStatus(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete status confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteStatus(): void
    {
        $this->deleteConfirmation(
            __('Status deletion'),
            __('Are you sure you want to delete this status?'),
            'doDeleteStatus',
            'cancelDeleteStatus'
        );
    }
}
