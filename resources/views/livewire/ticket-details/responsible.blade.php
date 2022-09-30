<div class="w-full flex flex-col justify-start items-start">
    @if($updating)
        <form wire:submit.prevent="save" class="w-full relative flex flex-row justify-start items-start gap-2">
            <div class="w-full flex flex-col gap-0">
                {{ $this->form }}
                <div class="w-full">
                    <button type="button" wire:click="assignToMe"
                            class="text-gray-500 hover:text-primary-500 hover:underline text-xs">
                        @lang('Assign to me')
                    </button>
                </div>
            </div>
            <div class="flex flex-row items-center gap-1">
                <button type="submit"
                        class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-primary-700 hover:bg-primary-800
                        text-white text-base">
                    <div wire:loading.remove>
                        <em class="fa fa-check"></em>
                    </div>
                    <div wire:loading>
                        <em class="fa fa-spin fa-spinner"></em>
                    </div>
                </button>
            </div>
        </form>
    @else
        <div class="w-full flex flex-row justify-start items-center gap-5 updating-section">
            @if($ticket->responsible)
                <div class="flex flex-row justify-start items-center gap-2">
                    <x-user-avatar :user="$ticket->responsible"/>
                    <span class="text-gray-700 text-sm font-medium">{{ $ticket->responsible->name }}</span>
                </div>
            @else
                <span class="text-gray-400 font-medium text-sm">@lang('Not assigned yet!')</span>
            @endif
            @if(
                (
                    auth()->user()->can('Update all tickets')
                    || (
                        auth()->user()->can('Update own tickets')
                        && (
                            $ticket->owner_id === auth()->user()
                            || $ticket->responsible_id === auth()->user()->id
                            )
                        )
                    )
                    && auth()->user()->can('assign-tickets')
                )
                <button type="button" wire:click="update"
                        class="bg-gray-100 shadow hover:bg-gray-200 hover:shadow-lg w-6 h-6 text-xs flex-row
                        justify-center items-center rounded-lg text-gray-400">
                    <em class="fa fa-pencil"></em>
                </button>
            @endif
        </div>
    @endif
</div>
