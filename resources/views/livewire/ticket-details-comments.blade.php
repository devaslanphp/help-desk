<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full mb-5 pb-5 border-b border-gray-200">
        <form wire:submit.prevent="comment" class="w-full">
            <div class="w-full p-5">
                {{ $this->form }}
            </div>
            <div class="w-full flex flex-row gap-2 justify-between items-center px-5">
                <button type="submit" wire:loading.attr="disabled" class="rounded-lg flex flex-row justify-center items-center text-center gap-2 text-white bg-primary-700 bg-opacity-90 hover:bg-opacity-100 shadow hover:shadow-lg px-10 py-3 text-sm">
                    @lang('Add comment')
                    <div wire:loading>
                        <i class="fa fa-spin fa-spinner"></i>
                    </div>
                </button>
            </div>
        </form>
    </div>
    @if($ticket->comments->count())
        @foreach($ticket->comments as $comment)
            <div class="w-full flex flex-row gap-2 px-5 {{ $loop->index !== 0 ? 'pt-5 mt-5 border-t border-gray-200' : '' }}">
                <x-user-avatar :user="$comment->owner" />
                <div class="flex flex-col justify-start items-start gap-3">
                    <div class="flex flex-col justify-center items-start gap-0">
                        <span class="text-gray-700 text-sm font-medium">{{ $comment->owner->name }}</span>
                        <span class="text-gray-500 text-xs font-light">@lang('Added a comment') {{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="w-full prose magnificpopup-container">
                        {!! $comment->content !!}
                    </div>
                    @if($comment->owner_id === auth()->user()->id)
                        <div class="w-full flex flex-row justify-start items-center gap-5">
                            <a href="#" class="text-gray-400 text-xs hover:text-primary-500 flex flex-row justify-start items-center gap-1">
                                <i class="fa fa-pencil"></i> @lang('Edit')
                            </a>
                            <span class="text-gray-300 font-light">|</span>
                            <a href="#" class="text-gray-400 text-xs hover:text-danger-500 flex flex-row justify-start items-center gap-1">
                                <i class="fa fa-times"></i> @lang('Delete')
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="w-full flex flex-col justify-center items-center gap-2 text-center">
            <img src="{{ asset('images/comments-empty.jpeg') }}" alt="No comments" class="w-14 opacity-50" />
            <span class="text-lg text-neutral-400 font-light">
                @lang('No comments yet!')
            </span>
        </div>
    @endif
</div>
