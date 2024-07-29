<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="w-full flex flex-col justify-center items-start gap-3">
            <a href="{{ route('tickets') }}"
               class="text-xs text-blue-500 hover:text-blue-600 font-light flex items-center gap-2">
                <em  class="fa fa-long-arrow-left"></em>
                @lang('Go back to tickets list')
            </a>
            <div class="w-full flex flex-col justify-center items-start gap-0">
                <span class="w-full text-sm font-medium text-gray-500 flex flex-row justify-start items-center gap-2">
                    <em  class="fa fa-tag"></em>
                    <span class="text-xs text-gray-300">/</span>
                    <button type="button" class="font-normal hover:cursor-pointer hover:underline"
                            wire:click="copyTicketUrl('{{ $ticket->id }}')"
                            title="@lang('Click to copy url to ticket')">{{ $ticket->ticket_number }}</button>
                </span>
                <div class="w-3/4 flex">
                    @livewire('ticket-details.title', ['ticket' => $ticket])

                    @if($ticket->status === 'resolved' && auth()->user()->can('Update own tickets')
                        && (
                            $ticket->owner_id === auth()->user()->id)
                        )
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-8 rounded-full whitespace-nowrap"
                        wire:click="closeTicket">
                        Close Ticket
                    </button>
                    @endif
                    @if($ticket->subcategory === 'networkaccessright' && auth()->user()->hasRole('Head of Department'))
                        <button type="button" class="transition ease-in-out delay-100 bg-blue-500 hover:-translate-y-1 hover:scale-110 duration-300 bg-blue-500 hover:bg-blue-700 text-white font-bold px-1 rounded-full whitespace-nowrap
                            <?php if($ticket->status == 'approved') { echo 'hidden'; } ?>"
                            wire:click="approveTicket">
                            Approves ticket
                        </button>
                        <button type="button" class="transition ease-in-out delay-100 hover:-translate-y-1 hover:scale-110 duration-300 bg-red-500 hover:bg-red-700 text-white font-bold px-1 rounded-full whitespace-nowrap
                            <?php if($ticket->status == 'closed') { echo 'hidden'; } ?>"
                            wire:click="disapproveTicket">
                            Disapproves ticket
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex lg:flex-row flex-col gap-5 mt-5">
        <div class="lg:w-3/4 w-full flex flex-col gap-2 lg:order-1 order-2">
            <span class="text-gray-500 font-normal text-xs">@lang('Content')</span>
            @livewire('ticket-details.content', ['ticket' => $ticket])
            <div class="w-full flex flex-col gap-2 mt-10" id="ticket-details-tabs">
                <div class="w-full flex flex-row justify-start items-center gap-3 overflow-x-auto menu">
                    @foreach($menu as $item)
                        <button wire:click="selectMenu('{{ $item }}')" type="button"
                                class="item {{ $activeMenu === $item ? 'active' : '' }}">
                            @lang($item)
                            {{
                                (
                                    $item === 'Comments'
                                    && $ticket->comments->count()
                                )
                                ?
                                ('(' . $ticket->comments->count() . ')')
                                :
                                ''
                            }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="w-full mt-5">
                @switch($activeMenu)
                    @case($activeMenu === 'Comments')
                        @livewire('ticket-details-comments', ['ticket' => $ticket])
                        @break
                    @case($activeMenu === 'Chat')
                        @livewire('chat', ['ticket' => $ticket])
                        @break
                @endswitch
            </div>
        </div>
        <div class="lg:w-1/4 w-full flex flex-col gap-5 lg:order-2 order-1">
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Priority')</span>
                @livewire('ticket-details.priority', ['ticket' => $ticket])
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Category')</span>
                @livewire('ticket-details.category', ['ticket' => $ticket])
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Subcategory')</span>
                @livewire('ticket-details.subcategory', ['ticket' => $ticket])
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Issue')</span>
                @livewire('ticket-details.issue', ['ticket' => $ticket])
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Type')</span>
                @livewire('ticket-details.type', ['ticket' => $ticket])
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Status')</span>
                @livewire('ticket-details.status', ['ticket' => $ticket])
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Owner')</span>
                <div class="w-full flex flex-row justify-start items-center gap-2">
                    <x-user-avatar :user="$ticket->owner"/>
                    <span class="text-gray-700 text-sm font-medium">{{ $ticket->owner->name }}</span>
                </div>
            </div>
            <div class="w-full flex flex-col justify-start items-start gap-2">
                <span class="text-gray-500 font-normal text-xs">@lang('Responsible')</span>
                <div class="w-full flex flex-row justify-start items-center gap-2">
                    @livewire('ticket-details.responsible', ['ticket' => $ticket])
                </div>
            </div>
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

    @push('scripts')
        <script>
            window.addEventListener('ticketUrlCopied', (event) => {
                window.unsecuredCopyToClipboard(event.detail.url);
            });
            window.addEventListener('initMagnificPopupOnTicketComments', (e) => {
                window.initMagnificPopupOnTicketComments();
            });
        </script>
    @endpush
</div>
