<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-3">
            <a href="{{ route('tickets') }}" class="text-xs text-blue-500 hover:text-blue-600 font-light flex items-center gap-2">
                <i class="fa fa-long-arrow-left"></i>
                @lang('Go back to tickets list')
            </a>
            <div class="flex flex-col justify-center items-start gap-0">
                <span class="text-sm font-medium text-gray-500 flex flex-row justify-start items-center gap-2">
                    <i class="fa fa-tag"></i>
                    {{ $ticket->project->name }}
                </span>
                <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700 flex items-center gap-3">
                    {{ $ticket->title }}
                </span>
            </div>
        </div>
    </div>
    <div class="w-full flex lg:flex-row flex-col gap-5 mt-5">
        <div class="lg:w-3/4 w-full flex flex-col gap-2 lg:order-1 order-2">
            <span class="text-gray-500 font-normal text-xs">@lang('Content')</span>
            <div class="w-full prose">
                {!! $ticket->content !!}
            </div>
            <div class="w-full flex flex-col gap-2 mt-10" id="ticket-details-tabs">
                <div class="w-full flex flex-row justify-start items-center gap-3 overflow-x-auto menu">
                    @foreach($menu as $item)
                        <button wire:click="selectMenu('{{ $item }}')" type="button" class="item {{ $activeMenu === $item ? 'active' : '' }}">
                            @lang($item)
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="w-full mt-5">
                @switch($activeMenu)
                    @case($activeMenu === 'Comments')

                        @break
                    @case($activeMenu === 'Activities')

                        @break
                @endswitch
            </div>
        </div>
        <div class="lg:w-1/4 w-full flex flex-col gap-5 lg:order-2 order-1">
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Type')</span>
                <x-type-span :type="$ticket->type" />
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Priority')</span>
                <x-priority-span :priority="$ticket->priority" />
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Status')</span>
                <x-status-span :status="$ticket->status" />
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Owner')</span>
                <div class="w-full flex flex-row justify-start items-center gap-2">
                    <x-user-avatar :user="$ticket->owner" /> <span class="text-gray-700 text-sm font-medium">{{ $ticket->owner->name }}</span>
                </div>
            </div>
            @if($ticket->responsible)
                <div class="w-full flex flex-col justify-start items-start gap-2">
                    <span class="text-gray-500 font-normal text-xs">@lang('Responsible')</span>
                    <div class="w-full flex flex-row justify-start items-center gap-2">
                        <x-user-avatar :user="$ticket->responsible" /> <span class="text-gray-700 text-sm font-medium">{{ $ticket->responsible->name }}</span>
                    </div>
                </div>
            @else
                <div class="w-full flex flex-col justify-start items-start gap-2">
                    <span class="text-gray-500 font-normal text-xs">@lang('Responsible')</span>
                    <span class="text-gray-400 font-medium text-sm">@lang('Not assigned yet!')</span>
                </div>
            @endif
            <div class="w-full flex flex-col justify-start items-start gap-1 mt-5 pt-5 border-t border-gray-200">
                <div class="w-full flex flex-row justify-start items-center gap-1">
                    <span class="text-gray-500 font-normal text-xs">@lang('Created:')</span>
                    <span class="text-gray-500 font-medium text-xs">{{ $ticket->created_at->diffForHumans() }}</span>
                </div>
                <div class="w-full flex flex-row justify-start items-center gap-1">
                    <span class="text-gray-500 font-normal text-xs">@lang('Last update:')</span>
                    <span class="text-gray-500 font-medium text-xs">{{ $ticket->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
