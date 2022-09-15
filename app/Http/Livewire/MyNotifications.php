<?php

namespace App\Http\Livewire;

use Filament\Notifications\Notification;
use Livewire\Component;

class MyNotifications extends Component
{

    public function render()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->paginate();
        return view('livewire.my-notifications', compact('notifications'));
    }

    /**
     * Mark a notification as read
     *
     * @param string $notification
     * @return void
     */
    public function markRead(string $notification): void
    {
        auth()->user()->notifications()->where('id', $notification)->update([
            'read_at' => now()
        ]);
        Notification::make()
            ->success()
            ->title(__('Notification updated'))
            ->body(__('The notification is now marked as read'))
            ->send();
    }

    /**
     * Mark all unread notifications as read
     *
     * @return void
     */
    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        Notification::make()
            ->success()
            ->title(__('Notifications updated'))
            ->body(__('All unread notifications is marked as read'))
            ->send();
    }
}
