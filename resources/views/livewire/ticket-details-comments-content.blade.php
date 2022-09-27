<div class="w-full">
    @foreach($ticket->comments as $comment)
        <div class="w-full flex flex-row gap-2 px-5 border-b border-gray-200 pb-5 mb-5">
            <x-user-avatar :user="$comment->owner"/>
            <div class="flex flex-col justify-start items-start gap-3">
                <div class="flex flex-col justify-center items-start gap-0">
                    <span class="text-gray-700 text-sm font-medium">{{ $comment->owner->name }}</span>
                    <span
                        class="text-gray-500 text-xs font-light">
                        @lang('Added a comment') {{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>
                <div class="w-full flex flex-col">
                    @if($updating && $comment->id === $selectedComment->id)
                        <form wire:submit.prevent="save"
                              class="w-full relative flex flex-col justify-start items-start gap-2">
                            <div class="w-full">
                                {{ $this->form }}
                            </div>
                            <div class="flex flex-row items-center gap-1">
                                <button type="submit"
                                        class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-primary-700
                                        hover:bg-primary-800 text-white text-base flex flex-row gap-2 items-center">
                                    <div wire:loading.remove>
                                        <em  class="fa fa-check"></em>
                                    </div>
                                    <div wire:loading>
                                        <em  class="fa fa-spin fa-spinner"></em>
                                    </div>
                                    <span>@lang('Update')</span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="w-full prose max-w-full magnificpopup-container">
                            {!! $comment->content !!}
                        </div>
                    @endif
                    @if(
                        $comment->owner_id === auth()->user()->id
                        && (
                            !$updating
                            || $comment->id !== $selectedComment?->id
                        )
                    )
                        <div class="w-full flex flex-row justify-start items-center gap-5">
                            <button type="button" wire:click="updateComment('{{ $comment->id }}')"
                                    class="text-gray-400 text-xs hover:text-primary-500 flex
                                    flex-row justify-start items-center gap-1">
                                <em  class="fa fa-pencil"></em> @lang('Edit')
                            </button>
                            <span class="text-gray-300 font-light">|</span>
                            <button {!! $deleteConfirmationOpened ? 'disabled' : '' !!} type="button"
                                    wire:click="deleteComment({{ $comment }})"
                                    class="text-gray-400 text-xs hover:text-danger-500 flex flex-row
                                    justify-start items-center gap-1">
                                <em  class="fa fa-times"></em> @lang('Delete')
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

