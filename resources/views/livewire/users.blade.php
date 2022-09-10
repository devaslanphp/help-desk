<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex flex-row justify-end items-center pb-4 bg-white dark:bg-gray-900">
        <form wire:submit.prevent="search" class="relative flex flex-row justify-end items-center gap-1 md:w-1/3 w-2/3">
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
                    @lang('Full name')
                </th>
                <th scope="col" class="py-3 px-6 min-w-table">
                    @lang('Role')
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
            @foreach($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <x-user-avatar :user="$user" />
                        <div class="pl-3">
                            <div class="text-base font-semibold">{{ $user->name }}</div>
                            <div class="font-normal text-gray-500">{{ $user->email }}</div>
                        </div>
                    </th>
                    <td class="py-4 px-6">
                        <x-role-span :role="$user->role" />
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-col">
                            <span class="text-base font-semibold">{{ $user->created_at->diffForHumans() }}</span>
                            <span class="font-normal text-gray-500">{{ $user->created_at->format(__('Y-m-d g:i A')) }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">@lang('Edit user')</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
