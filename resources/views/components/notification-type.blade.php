@switch($notification->type)
    
    @case(\App\Notifications\SummaryNotification::class) <!-- Digested Notifications  --->
        <div class="flex flex-col justify-start items-start gap-2">
            <?php
            $messages = $notification->data['summary']['messages'];
            ?>
            @foreach($messages as $message)
            <?php
            $ticket = App\Models\Ticket::find($message['ticket']['id']);
            ?>
                @if($notification->data['summary']['type'] == 'App\\Notifications\\TicketCreatedNotification')
                    <span class="text-sm text-gray-700 font-medium">@lang(':user created the ticket: :ticket',  [
                        'user' => $ticket->owner->where('id',$message['ticket']['owner_id'])->pluck('name')->first(),
                        'ticket' => $message['ticket']['title']
                        ])</span>
                            <a href="{{ route(
                                    'tickets.details',
                                    [
                                        'ticket' => $message['ticket']['id'],
                                        'slug' => Str::slug($message['ticket']['title'])
                                    ]
                                ) }}"
                                class="text-gray-500 hover:text-primary-500 text-xs flex flex-row justify-start items-center gap-2">
                                @lang('View ticket details') <em class="fa fa-long-arrow-right"></em>
                            </a>
                                    
                @elseif($notification->data['summary']['type'] == 'App\\Notifications\\TicketUpdatedNotification')
                    <span class="text-sm text-gray-700 font-medium">@lang('ticket: :ticket is updated',  [
                        'ticket' => $message['ticket']['title']
                        ])</span>
                            <div class="w-full flex flex-row justify-start items-center gap-2">
                                <div class="flex flex-row justify-start items-center gap-1">
                                    <span class="text-xs text-gray-500 font-medium">
                                        @lang('Field:')
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $message['field'] }}
                                    </span>
                                </div>
                                <span class="px-2 text-xs text-gray-200">|</span>
                                <div class="flex flex-row justify-start items-center gap-1">
                                    <span class="text-xs text-gray-500 font-medium">
                                        @lang('Before:')
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $message['before'] }}
                                    </span>
                                </div>
                                <span class="px-2 text-xs text-gray-200">|</span>
                                <div class="flex flex-row justify-start items-center gap-1">
                                    <span class="text-xs text-gray-500 font-medium">
                                        @lang('After:')
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $message['after'] }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route(
                                        'tickets.details',
                                        [
                                            'ticket' => $message['ticket']['id'],
                                            'slug' => Str::slug($message['ticket']['title'])
                                        ]
                                    ) }}"
                                    class="text-gray-500 hover:text-primary-500 text-xs flex flex-row justify-start items-center gap-2">
                                    @lang('View ticket details') <em class="fa fa-long-arrow-right"></em>
                            </a>
                                        
                @elseif($notification->data['summary']['type'] == 'App\\Notifications\\CommentCreateNotification')
                    <div class="flex flex-col justify-start items-start gap-2">
                        <?php
                        $comment = App\Models\Comment::find($message['comment']['id']);
                        ?>
                        <span class="text-sm text-gray-700 font-medium">@lang(':user commented the ticket: :ticket',  [
                            'user' => $comment->owner->where('id',$message['comment']['owner_id'])->pluck('name')->first(),
                            'ticket' => $message['ticket']['title']
                        ])</span>
                        <div class="w-full flex flex-row justify-start items-center gap-2">
                            <div class="flex flex-row justify-start items-center gap-1">
                                <span class="text-xs text-gray-500 font-medium">
                                    @lang('Comment:')
                                </span>
                                <span class="text-xs text-gray-500">
                                    <?php echo $message['comment']['content']; ?>
                                </span>
                            </div>
                        </div>
                        <a href="{{ route(
                                'tickets.details',
                                [
                                    'ticket' => $message['ticket']['id'],
                                    'slug' => Str::slug($message['ticket']['title'])
                                ]
                            ) }}"
                           class="text-gray-500 hover:text-primary-500 text-xs flex flex-row justify-start items-center gap-2"
                        >
                            @lang('View ticket details') <em class="fa fa-long-arrow-right"></em>
                        </a>
                    </div>          
                @endif
            @endforeach
        </div>
        @break

    @case(\App\Notifications\CommentCreateNotification::class) <!-- Comment Create Notifications  --->
        <div class="flex flex-col justify-start items-start gap-2">
            <?php
            $comment = App\Models\Comment::find($notification->data['comment']['id']);
            ?>
            <span class="text-sm text-gray-700 font-medium">@lang(':user commented the ticket: :ticket',  [
                
                
                'user' => $comment->owner->where('id',$notification->data['comment']['owner_id'])->pluck('name')->first(),
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
 
    @case(\App\Notifications\TicketUpdatedNotification::class) <!-- Ticket Updated Notifications  --->
        <div class="flex flex-col justify-start items-start gap-2">
            <?php
            $ticket = App\Models\Ticket::find($notification->data['ticket']['id']);
            ?>
            <span class="text-sm text-gray-700 font-medium">@lang('ticket: :ticket is updated',  [
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

    @case(\App\Notifications\TicketCreatedNotification::class) <!-- Ticket Created Notifications  --->
        <div class="flex flex-col justify-start items-start gap-2">
            <?php
            $ticket = App\Models\Ticket::find($notification->data['ticket']['id']);
            ?>
            <span class="text-sm text-gray-700 font-medium">@lang(':user created the ticket: :ticket',  [
                    'user' => $ticket->owner->where('id',$notification->data['ticket']['owner_id'])->pluck('name')->first(),
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

    

@endswitch
