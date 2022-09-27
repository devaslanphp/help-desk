<?php

namespace App\Core;

use Exception;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

trait CrudDialogHelper
{

    public bool $deleteConfirmationOpened = false;

    /**
     * Delete confirmation function
     *
     * @param string $title
     * @param string $body
     * @param string $deleteEvent
     * @param string $cancelEvent
     * @return void
     * @throws Exception
     */
    public function deleteConfirmation(string $title, string $body, string $deleteEvent, string $cancelEvent): void
    {
        $this->deleteConfirmationOpened = true;
        Notification::make()
            ->warning()
            ->title($title)
            ->body($body)
            ->actions([
                Action::make('confirm')
                    ->label(__('Confirm'))
                    ->color('danger')
                    ->button()
                    ->close()
                    ->emit($deleteEvent),
                Action::make('cancel')
                    ->label(__('Cancel'))
                    ->close()
                    ->emit($cancelEvent)
            ])
            ->persistent()
            ->send();
    }

}
