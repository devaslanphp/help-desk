<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
                <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700 flex items-center gap-3">
                    @lang('Tickets')
                    <div wire:loading>
                        <em  class="fa fa-spin fa-spinner opacity-50"></em>
                    </div>
                </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                    @lang('Below is the list of created tickets in :app', [
                        'app' => config('app.name')
                    ])
                </span>
        </div>
        @can('Create tickets')
            <button type="button" wire:click="createTicket()"
                    class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg shadow hover:shadow-lg
                    text-base">
                @lang('Create a new ticket')
            </button>
        @endCan
    </div>
    <div class="w-full mt-5">
        <div class="w-full flex flex-col justify-start items-start gap-5" id="tickets">
            <div class="w-full flex flex-row justify-start items-center gap-3 overflow-x-auto menu">
                @foreach($menu as $item)
                    <button wire:click="selectMenu('{{ $item }}')" type="button"
                            class="item {{ $activeMenu === $item ? 'active' : '' }}">
                        @lang($item)
                    </button>
                @endforeach
            </div>
            <div class="w-full flex flex-col gap-5" wire:ignore>
                <div id="filter-accordion" data-accordion="collapse">
                    <h2 id="filter-accordion-heading">
                        <button type="button"
                                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500
                                border border-gray-200 rounded-t-lg focus:ring-4 focus:ring-gray-200
                                dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100
                                dark:hover:bg-gray-800"
                                data-accordion-target="#filter-accordion-body" aria-expanded="false"
                                aria-controls="filter-accordion-body">
                            <span>@lang('Filters')</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-360 shrink-0" fill="currentColor"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="filter-accordion-body" class="hidden" aria-labelledby="filter-accordion-heading">
                        <div class="w-full flex flex-row justify-start items-center p-5 border border-gray-200">
                            <form wire:submit.prevent="search"
                                  class="relative flex lg:flex-row flex-col justify-start items-center gap-5 w-full">
                                {{ $this->form }}
                                <div class="flex flex-row items-center gap-1">
                                    <button type="submit"
                                            class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-primary-700
                                            hover:bg-primary-800 text-white text-base">
                                        <div wire:loading.remove>
                                            <em  class="fa fa-search"></em>
                                        </div>
                                        <div wire:loading>
                                            <em  class="fa fa-spin fa-spinner"></em>
                                        </div>
                                    </button>
                                    <button type="button" wire:click="resetFilters"
                                            class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-gray-700
                                            hover:bg-gray-800 text-white text-base">
                                        <em  class="fa fa-filter-circle-xmark"></em>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex flex-col gap-5">
        @if($tickets->count())
            <div class="w-full flex flex-col justify-start items-start gap-5">
                @foreach($tickets as $ticket)
                    <div
                        class="w-full bg-white border border-gray-200 shadow hover:shadow-lg rounded-lg p-5 flex
                        flex-col justify-start items-start gap-1">
                        <span class="text-xs font-medium text-gray-500 flex flex-row justify-start items-center gap-2">
                            <em  class="fa fa-tag"></em>
                            {{ $ticket->project->name }}
                            <span class="text-xs text-gray-300">/</span>
                            <button type="button" class="font-normal hover:cursor-pointer hover:underline"
                                    wire:click="copyTicketUrl('{{ $ticket->id }}')"
                                    title="@lang('Click to copy url to ticket')">{{ $ticket->ticket_number }}</button>
                        </span>
                        <div class="w-full flex flex-row justify-between items-start gap-5">
                            <a
                                href="{{ route(
                                        'tickets.details',
                                        [
                                            'ticket' => $ticket,
                                            'slug' => Str::slug($ticket->title)
                                        ]
                                    ) }}"
                               class="text-lg font-medium text-gray-700 hover:underline">
                                {{ $ticket->title }}
                            </a>
                            <span
                                class="text-sm font-medium text-gray-700">
                                {{ $ticket->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <span class="text-sm font-light text-gray-500">
                            {{ Str::limit(htmlspecialchars(strip_tags($ticket->content)), 400) }}
                        </span>
                        <div class="w-full flex flex-row justify-start items-center gap-3 mt-2 overflow-x-auto">
                            <x-type-span :type="$ticket->type"/>
                            <x-priority-span :priority="$ticket->priority"/>
                            <x-status-span :status="$ticket->status"/>
                            <span
                                class="flex flex-row justify-center items-center gap-2 text-sm
                                text-gray-700 font-medium">
                                {{ $ticket->comments_count }}
                                <em  class="fa fa-comment-o"></em>
                            </span>
                        </div>
                        <div class="w-full flex flex-row justify-start items-center gap-10 mt-5">
                            <div class="flex flex-row justify-start items-center gap-2 text-xs">
                                <x-user-avatar :user="$ticket->owner" :size="30"/>
                                <div class="flex flex-col gap-0">
                                    <span class="font-medium text-gray-500 text-xs">@lang('Owner')</span>
                                    <span class="font-light text-gray-500 text-base">{{ $ticket->owner->name }}</span>
                                </div>
                            </div>
                            @if($ticket->responsible)
                                <div class="flex flex-row justify-start items-center gap-2">
                                    <x-user-avatar :user="$ticket->responsible" :size="30"/>
                                    <div class="flex flex-col gap-0">
                                        <span class="font-medium text-gray-500 text-xs">@lang('Responsible')</span>
                                        <span
                                            class="font-light text-gray-500 text-base">
                                            {{ $ticket->responsible->name }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-full flex flex-row justify-start items-center">
                {{ $tickets->links('pagination::tailwind') }}
            </div>
        @else
            <div class="w-full flex flex-col justify-center items-center gap-2 text-center">
                <img src="{{ asset('images/search-empty.png') }}" alt="No tickets" class="w-20 opacity-70"/>
                <span class="text-lg text-neutral-400 font-light">
                    @lang('No tickets to show!')
                </span>
            </div>
        @endif
    </div>

    <div id="ticketModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex items-center
         justify-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-4xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        @lang('Create a new ticket')
                    </h3>
                    <button wire:click="cancelTicket()" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg
                            text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600
                            dark:hover:text-white">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                @if($selectedTicket)
                    @livewire('tickets-dialog', ['ticket' => $selectedTicket])
                @endif
            </div>
        </div>
    </div>

    <button type="button" class="hidden" data-modal-toggle="ticketModal" id="toggleTicketModal"></button>

    @push('scripts')
        <script>
            window.addEventListener('toggleTicketModal', () => {
                const toggleTicketModalBtn = document.querySelector('#toggleTicketModal');
                toggleTicketModalBtn.click();
            });

            window.addEventListener('ticketUrlCopied', (event) => {
                window.unsecuredCopyToClipboard(event.detail.url);
            });
        </script>
    @endpush
</div>
