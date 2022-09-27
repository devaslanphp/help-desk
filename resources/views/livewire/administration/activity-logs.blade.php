<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Activity logs')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Below is the list of activity logs of :app', [
                    'app' => config('app.name')
                ])
            </span>
        </div>
    </div>
    <div class="w-full mt-5">
        <div class="w-full flex flex-col justify-start items-start gap-5">
            <div class="w-full flex flex-row justify-end items-center pb-4 bg-white dark:bg-gray-900">
                <form wire:submit.prevent="search"
                      class="relative flex flex-row justify-end items-center gap-5 md:w-1/3 w-2/3"
                >
                    {{ $this->form }}
                    <button type="submit"
                            class="py-2 px-3 rounded-lg shadow hover:shadow-lg
                            bg-primary-700 hover:bg-primary-800 text-white text-base"
                    >
                        <div wire:loading.remove>
                            <em class="fa fa-search"></em>
                        </div>
                        <div wire:loading>
                            <em class="fa fa-spin fa-spinner"></em>
                        </div>
                    </button>
                </form>
            </div>
            <div class="w-full overflow-x-auto relative sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <caption class="hidden">@lang('Activity logs')</caption>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Description')
                        </th>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Created at')
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($logs->count())
                        @foreach($logs as $log)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                                hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                <td class="py-4 px-6">
                                    {!! $log->description !!}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-base font-semibold">
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>
                                        <span
                                            class="font-normal text-gray-500">
                                            {{ $log->created_at->format(__('Y-m-d g:i A')) }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700
                            hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="3" class="py-4 px-6 text-center dark:text-white">
                                @lang('No ticket priorities to show!')
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="w-full flex flex-row justify-start items-center">
                {{ $logs->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
