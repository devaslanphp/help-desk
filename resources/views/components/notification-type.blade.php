@switch($notification->type)

    @case(\App\Notifications\CommentCreateNotification::class)
        <div class="flex flex-col justify-start items-start gap-2">
            <span class="text-sm text-gray-700 font-medium">@lang(':user commented the ticket :ticket',  [
                'user' => $notification->data['user']['name'],
                'ticket' => $notification->data['ticket']['title']
            ])</span>
            <a href="{{ route(
                    'tickets.details',
                    [
                        'ticket' => $notification->data['ticket']['id'],
                        'slug' => Str::slug($notification->data['ticket']['title'])
                    ]
                ) }}"
               class="text-gray-500 hover:text-primary-500 text-xs flex flex-row justify-start items-center gap-2"
            >
                @lang('View ticket details') <em class="fa fa-long-arrow-right"></em>
            </a>
        </div>
        @break

    @case(\App\Notifications\TicketCreatedNotification::class)
        <div class="flex flex-col justify-start items-start gap-2">
            <span class="text-sm text-gray-700 font-medium">@lang(':user created the ticket :ticket',  [
                    'user' => $notification->data['user']['name'],
                    'ticket' => $notification->data['ticket']['title']
                ])</span>
            <a href="{{ route(
                            'tickets.details',
                            [
                                'ticket' => $notification->data['ticket']['id'],
                                'slug' => Str::slug($notification->data['ticket']['title'])
                            ]
                        ) }}"
               class="text-gray-500 hover:text-primary-500 text-xs flex flex-row justify-start items-center gap-2">
                @lang('View ticket details') <em class="fa fa-long-arrow-right"></em>
            </a>
        </div>
        @break

    @case(\App\Notifications\TicketUpdatedNotification::class)
        <div class="flex flex-col justify-start items-start gap-2">
            <span class="text-sm text-gray-700 font-medium">@lang(':user updated the ticket :ticket',  [
                        'user' => $notification->data['user']['name'],
                        'ticket' => $notification->data['ticket']['title']
                    ])</span>
            <div class="w-full flex flex-row justify-start items-center gap-2">
                <div class="flex flex-row justify-start items-center gap-1">
                    <span class="text-xs text-gray-500 font-medium">
                        @lang('Field:')
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $notification->data['field'] }}
                    </span>
                </div>
                <span class="px-2 text-xs text-gray-200">|</span>
                <div class="flex flex-row justify-start items-center gap-1">
                    <span class="text-xs text-gray-500 font-medium">
                        @lang('Before:')
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $notification->data['before'] }}
                    </span>
                </div>
                <span class="px-2 text-xs text-gray-200">|</span>
                <div class="flex flex-row justify-start items-center gap-1">
                    <span class="text-xs text-gray-500 font-medium">
                        @lang('After:')
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $notification->data['after'] }}
                    </span>
                </div>
            </div>
            <a href="{{ route(
                            'tickets.details',
                            [
                                'ticket' => $notification->data['ticket']['id'],
                                'slug' => Str::slug($notification->data['ticket']['title'])
                            ]
                        ) }}"
               class="text-gray-500 hover:text-primary-500 text-xs flex flex-row justify-start items-center gap-2"
            >
                @lang('View ticket details') <em class="fa fa-long-arrow-right"></em>
            </a>
        </div>
        @break

@endswitch
