<div class="w-full flex flex-col justify-start items-start">
    @if($updating)
        <form wire:submit.prevent="save" class="w-full relative flex flex-row justify-start items-center gap-2">
            <div class="w-full">
                {{ $this->form }}
            </div>
            <div class="flex flex-row items-center gap-1">
                <button type="submit"
                        class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-primary-700 hover:bg-primary-800
                        text-white text-base">
                    <div wire:loading.remove>
                        <em  class="fa fa-check"></em>
                    </div>
                    <div wire:loading>
                        <em  class="fa fa-spin fa-spinner"></em>
                    </div>
                </button>
            </div>
        </form>
    @else
        <div class="w-full flex flex-row justify-start items-center gap-5 updating-section">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700 flex items-center gap-3">
                {{ $ticket->title }}
            </span>
            @if(
                auth()->user()->can('Update all tickets')
                || (
                    auth()->user()->can('Update own tickets')
                    && (
                        $ticket->owner_id === auth()->user()
                        || $ticket->responsible_id === auth()->user()->id
                    )
                )
            )
                <button type="button" wire:click="update"
                        class="bg-gray-100 shadow hover:bg-gray-200 hover:shadow-lg w-6 h-6 text-xs flex-row
                        justify-center items-center rounded-lg text-gray-400">
                    <em  class="fa fa-pencil"></em>
                </button>
            @endif
        </div>
    @endif
</div>
