<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full mb-5 pb-5 border-b border-gray-200">
        <form wire:submit.prevent="comment" class="w-full">
            <div class="w-full p-5">
                {{ $this->form }}
            </div>
            <div class="w-full flex flex-row gap-2 justify-between items-center px-5">
                <button type="submit" wire:loading.attr="disabled"
                        class="rounded-lg flex flex-row justify-center items-center text-center gap-2
                        text-white bg-primary-700 bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg
                        px-10 py-3 text-sm">
                    @lang('Add comment')
                    <div wire:loading>
                        <em class="fa fa-spin fa-spinner"></em>
                    </div>
                </button>
            </div>
        </form>
    </div>
    @if($ticket->comments->count())
        @livewire('ticket-details-comments-content', ['ticket' => $ticket])
    @else
        <div class="w-full flex flex-col justify-center items-center gap-2 text-center">
            <img src="{{ asset('images/comments-empty.jpeg') }}" alt="No comments" class="w-14 opacity-50"/>
            <span class="text-lg text-neutral-400 font-light">
                @lang('No comments yet!')
            </span>
        </div>
    @endif
</div>
