<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <a href="{{ route('administration') }}" class="text-xs text-blue-500 hover:text-blue-600 font-light flex items-center gap-2">
                <i class="fa fa-long-arrow-left"></i>
                @lang('Go back to administration')
            </a>
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Ticket priorities')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Below is the list of configured tickets priorities in :app', [
                    'app' => config('app.name')
                ])
            </span>
        </div>
        <button type="button" wire:click="createPriority()" class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg shadow hover:shadow-lg text-base">
            @lang('Create a new priority')
        </button>
    </div>
    <div class="w-full mt-5">
        <div class="w-full flex flex-col justify-start items-start gap-5">
            <div class="w-full flex flex-row justify-end items-center pb-4 bg-white dark:bg-gray-900">
                <form wire:submit.prevent="search" class="relative flex flex-row justify-end items-center gap-5 md:w-1/3 w-2/3">
                    {{ $this->form }}
                    <button type="submit" class="py-2 px-3 rounded-lg shadow hover:shadow-lg bg-primary-700 hover:bg-primary-800 text-white text-base">
                        <div wire:loading.remove>
                            <i class="fa fa-search"></i>
                        </div>
                        <div wire:loading>
                            <i class="fa fa-spin fa-spinner"></i>
                        </div>
                    </button>
                </form>
            </div>
            <div class="w-full overflow-x-auto relative sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Title')
                        </th>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Created at')
                        </th>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Actions')
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($priorities->count())
                        @foreach($priorities as $priority)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-sm" style="color: {{ $priority->text_color }}; background-color: {{ $priority->bg_color }}">
                                        <i class="fa {{ $priority->icon }}"></i> {{ $priority->title }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span class="text-base font-semibold">{{ $priority->created_at->diffForHumans() }}</span>
                                        <span class="font-normal text-gray-500">{{ $priority->created_at->format(__('Y-m-d g:i A')) }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <button wire:click="updatePriority('{{ $priority->id }}')" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">@lang('Edit priority')</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="3" class="py-4 px-6 text-center dark:text-white">
                                @lang('No ticket priorities to show!')
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="w-full flex flex-row justify-start items-center">
                {{ $priorities->links('pagination::tailwind') }}
            </div>
        </div>

        <div id="priorityModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex items-center justify-center w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            @lang($selectedPriority?->id ? 'Update priority' : 'Create a new priority')
                        </h3>
                        <button wire:click="cancelPriority()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    @if($selectedPriority)
                        @livewire('administration.ticket-priorities-dialog', ['priority' => $selectedPriority])
                    @endif
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="hidden" data-modal-toggle="priorityModal" id="togglePriorityModal"></button>

    @push('scripts')
        <script>
            window.addEventListener('togglePriorityModal', () => {
                const togglePriorityModalBtn = document.querySelector('#togglePriorityModal');
                togglePriorityModalBtn.click();
            });
        </script>
    @endpush
</div>
