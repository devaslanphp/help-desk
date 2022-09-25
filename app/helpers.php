<?php

use App\Models\TicketPriority;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

if (!function_exists('statuses_list')) {
    /**
     * Return statuses list as an array of KEY (status id) => VALUE (status title)
     *
     * @return array
     */
    function statuses_list(): array
    {
        return TicketStatus::all()->pluck('title', 'slug')->toArray();
    }
}

if (!function_exists('statuses_list_for_kanban')) {
    /**
     * Return statuses list as an array for kanban board
     *
     * @return array
     */
    function statuses_list_for_kanban(): array
    {
        return TicketStatus::all()->map(fn($item) => [
            'id' => $item->slug,
            'title' => $item->title,
            'text-color' => $item->text_color,
            'bg-color' => $item->bg_color
        ])->toArray();
    }
}

if (!function_exists('priorities_list')) {
    /**
     * Return priorities list as an array of KEY (priority id) => VALUE (priority title)
     *
     * @return array
     */
    function priorities_list(): array
    {
        return TicketPriority::all()->pluck('title', 'slug')->toArray();
    }
}

if (!function_exists('default_ticket_status')) {
    /**
     * Return the default status configured on system configurations
     *
     * @return string|null
     */
    function default_ticket_status(): string|null
    {
        if ($default = TicketStatus::where('default', true)->first()) {
            return Str::slug($default->title);
        }
        return null;
    }
}

if (!function_exists('types_list')) {
    /**
     * Return types list as an array of KEY (type id) => VALUE (type title)
     *
     * @return array
     */
    function types_list(): array
    {
        return TicketType::all()->pluck('title', 'slug')->toArray();
    }
}

if (!function_exists('locales')) {
    /**
     * Return application locales as an array of KEY (locale id) => VALUE (locale title)
     *
     * @return array
     */
    function locales(): array
    {
        $locales = [];
        foreach (config('system.locales') as $key => $value) {
            $locales[$key] = __($value);
        }
        return $locales;
    }
}
