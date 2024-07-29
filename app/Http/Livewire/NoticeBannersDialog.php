<?php

namespace App\Http\Livewire;

use App\Core\CrudDialogHelper;
use App\Models\Notice;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class NoticeBannersDialog extends Component implements HasForms
{
    use InteractsWithForms;
    use CrudDialogHelper;

    public Notice $notice;

    protected $listeners = ['doDeleteNotice', 'cancelDeleteNotice'];

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->notice->title,
            'content' => $this->notice->content,
            'category' => $this->notice->category,
            'status' => $this->notice->status,
        ]);
    }

    public function render()
    {
        return view('livewire.notice-banners-dialog');
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        if (!$this->notice?->id) {
        return [
            TextInput::make('title')
                ->label(__('Title'))
                ->maxLength(255)
                ->unique(
                    table: Notice::class,
                    column: 'title',
                    ignorable: fn() => $this->notice,
                    callback: function (Unique $rule) {
                        return $rule->withoutTrashed();
                    }
                )
                ->required(),
            TextInput::make('content')
                ->label(__('Content'))
                ->maxLength(255)
                ->required(),
            TextInput::make('category')
                ->label(__('Category'))
                ->maxLength(255)
                ->required(),
            ];
        } else {
            return [
                TextInput::make('title')
                    ->label(__('Title'))
                    ->maxLength(255)
                    ->unique(
                        table: Notice::class,
                        column: 'title',
                        ignorable: fn() => $this->notice,
                        callback: function (Unique $rule) {
                            return $rule->withoutTrashed();
                        }
                    )
                    ->required(),
                TextInput::make('content')
                    ->label(__('Content'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('category')
                    ->label(__('Category'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('status')
                    ->label(__('Status'))
                    ->maxLength(255)
                    ->required(),
                ];
        }
    }

    /**
     * Create / Update the notice
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        if (!$this->notice?->id) {
            $notice = Notice::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'category' => $data['category'],
                'status' => true,
                'slug' => Str::slug($data['title'], '_')
            ]);
            Notification::make()
                ->success()
                ->title(__('Notice created'))
                ->body(__('The notice has been created'))
                ->send();
            // if ($notice->status) {
            //     Notice::where('id', '<>', $notice->id)->update(['status' => false]);
            // }
        } else {
            $this->notice->title = $data['title'];
            $this->notice->content = $data['content'];
            $this->notice->category = $data['category'];
            $this->notice->status = $data['status'];
            $this->notice->save();
            Notification::make()
                ->success()
                ->title(__('Notice updated'))
                ->body(__('The notice\'s details has been updated'))
                ->send();
            //Notice::where('id', '<>', $this->notice->id)->update(['status' => false]);
        }
        if (Notice::where('status', true)->count() === 0) {
            $first = Notice::first();
            $first->status = true;
            $first->save();
        }
        $this->emit('noticeSaved');
    }

    /**
     * Delete an existing notice
     *
     * @return void
     */
    public function doDeleteNotice(): void
    {
        $this->notice->delete();
        $this->deleteConfirmationOpened = false;
        $this->emit('notice');
        Notification::make()
            ->success()
            ->title(__('Notice deleted'))
            ->body(__('The notice has been deleted'))
            ->send();
    }

    /**
     * Cancel the deletion of a notice
     *
     * @return void
     */
    public function cancelDeleteNotice(): void
    {
        $this->deleteConfirmationOpened = false;
    }

    /**
     * Show the delete notice confirmation dialog
     *
     * @return void
     * @throws \Exception
     */
    public function deleteNotice(): void
    {
        $this->deleteConfirmation(
            __('Notice deletion'),
            __('Are you sure you want to delete this notice?'),
            'doDeleteNotice',
            'cancelDeleteNotice'
        );
    }
}
