<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Notifications')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Below is the list of notifications you have received on :app', [
                    'app' => config('app.name')
                ])
            </span>
        </div>
    </div>
    <div class="w-full flex flex-row flex-wrap">
        @if(auth()->user()->unreadNotifications()->count())
            <div class="w-full flex flex-row justify-end items-center pb-5">
                <button type="button"
                        class="text-primary-500 hover:text-primary-600 text-sm hover:underline"
                        wire:click="markAllRead">
                    @lang('Mark all unread notification as read')
                </button>
            </div>
        @endif
        <div class="w-full overflow-x-auto relative sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <caption class="hidden">@lang('Notifications')</caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6 min-w-table">
                        @lang('Type')
                    </th>
                    <th scope="col" class="py-3 px-6 min-w-table">
                        @lang('Received at')
                    </th>
                    <th scope="col" class="py-3 px-6 min-w-table"></th>
                </tr>
                </thead>
                <tbody>
                @if($notifications->count())
                    @foreach($notifications as $notification)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                            hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <td class="py-4 px-6">
                                @if(!$notification->read_at)
                                    <em class="fa fa-circle fa-beat-fade text-primary-500"
                                        style="--fa-beat-fade-opacity: .65; --fa-beat-fade-scale: 1.075;"
                                    ></em>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <x-notification-type :notification="$notification" />
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span
                                        class="text-base font-semibold">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    <span
                                        class="font-normal text-gray-500">
                                        {{ $notification->created_at->format(__('Y-m-d g:i A')) }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if(!$notification->read_at)
                                    <button
                                        class="text-primary-500 hover:text-primary-600
                                            text-sm hover:underline" type="button"
                                        wire:click="markRead('{{ $notification->id }}')"
                                    >
                                        @lang('Mark as read')
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                        hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td colspan="4" class="py-4 px-6 text-center dark:text-white">
                            @lang('No notifications received yet!')
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="w-full flex flex-row justify-start items-center">
            {{ $notifications->links('pagination::tailwind') }}
        </div>
    </div>
</div>
