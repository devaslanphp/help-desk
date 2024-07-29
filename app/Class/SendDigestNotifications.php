<?php

namespace App\Class;

use App\Models\User;
use Filament\Notifications\Notification;
use App\Notifications\SummaryNotification;

class SendDigestNotifications
{
    public function __invoke()
    {
        
        $users = User::all(); // Or a more specific query to target users with pending notifications
        
        foreach ($users as $user) {
            $notifications = $user->unreadNotifications; // Get unread notifications
            $temp = $notifications;
            // Aggregate notifications based on your criteria
            $groupedNotifications = $notifications->groupBy(function ($notification) {
                    return $notification->type;
            });

            foreach ($groupedNotifications as $type => $temp) {
                if($temp->first()->type == "App\\Notifications\\SummaryNotification"){
                    continue;
                }                                                                                  
                // // Create a summary notification for each group
                $summary = $this->createSummary($temp);

                // // // Send the summary notification
                $user->notify(new SummaryNotification($summary));

                // // // Mark the individual notifications as read
            }
            foreach ($user->unreadNotifications as $notification) {
                if($notification->type != "App\\Notifications\\SummaryNotification"){
                $notification->delete();
                }
            }
        }
        
    }

    protected function createSummary($notifications)
    {
        // Logic to create a summary from a group of notifications
        $summary = [
            'count' => $notifications->count(),
            'type' => $notifications->first()->type,
            'messages' => $notifications->pluck('data')->toArray(), // Assuming 'message' is an attribute in notification data
        ];

        return $summary;
    }
}