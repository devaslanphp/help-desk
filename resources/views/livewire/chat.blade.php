<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-0">
            <span class="lg:text-xl md:text-lg text-lg font-medium text-gray-700">
                @lang('Chat section')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Use the section below to chat with the speakers of this ticket')
            </span>
        </div>
    </div>
    <div class="w-full flex flex-col gap-5">
        <div id="chat"
             class="relative w-full flex flex-col justify-end items-end gap-3 rounded-lg
                    border border-gray-300 bg-gray-50"
             wire:poll>
            @if($messages->count())
                <div id="chat-container"
                     class="absolute top-0 right-0 left-0 bottom-0 w-full h-full flex flex-col-reverse
                     justify-start items-start gap-8 p-5 overflow-y-auto"
                >
                    @foreach($messages as $message)
                        <div
                            class="w-full flex flex-col justify-center gap-1
                            {{ $message->user_id === auth()->user()->id ? 'items-end' : 'items-start' }}"
                        >
                            <span class="text-xs text-gray-500 font-medium px-2">{{ $message->user->name }}</span>
                            <div
                                class="w-auto max-w-3xl prose text-left rounded-2xl p-4 shadow
                                {{ $message->user_id === auth()->user()->id ? 'bg-white' : 'bg-primary-100' }}"
                            >
                                {!! $message->message !!}
                            </div>
                            <span
                                class="text-xs text-gray-500 font-light px-2">
                                {{ $message->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="absolute top-0 right-0 left-0 bottom-0 w-full h-full
                    flex flex-col justify-center items-center"
                >
                    <img src="{{ asset('images/comments-empty.jpeg') }}" alt="No comments" class="w-14 opacity-50"/>
                    <span class="text-lg text-neutral-400 font-light">
                        @lang('No messages yet!')
                    </span>
                </div>
            @endif
        </div>
        <form wire:submit.prevent="send" class="w-full relative flex flex-col justify-start items-start gap-2">
            <div class="w-full">
                {{ $this->form }}
            </div>
            <div class="flex flex-row items-center gap-1">
                <button type="submit"
                        class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-primary-700
                        hover:bg-primary-800 text-white text-base"
                >
                    <div class="flex items-center gap-2">
                        <em class="fa fa-send-o"></em>
                        @lang('Send')
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>
