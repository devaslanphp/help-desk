<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
                <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                    @lang('Users')
                </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                    @lang('Below is the list of configured users having access to :app', [
                        'app' => config('app.name')
                    ])
                </span>
        </div>
        <button type="button" wire:click="createUser()" class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg shadow hover:shadow-lg text-base">
            @lang('Create a new user')
        </button>
    </div>
    <div class="w-full mt-5">
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
                            @lang('Account activated')
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
                                @if($user->register_token)
                                    <div class="flex flex-row justify-start items-center gap-2">
                                        <i class="fa fa-times-circle-o text-red-500 text-lg"></i>
                                        <button wire:click="resendActivationEmail({{ $user }})" class="bg-warning-500 text-white hover:bg-warning-600 px-2 py-1 rounded shadow hover:shadow-lg text-xs">
                                            @lang('Resend activation email')
                                        </button>
                                    </div>
                                @else
                                    <i class="fa fa-check-circle-o text-green-500 text-lg"></i>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-base font-semibold">{{ $user->created_at->diffForHumans() }}</span>
                                    <span class="font-normal text-gray-500">{{ $user->created_at->format(__('Y-m-d g:i A')) }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($user->id !== auth()->user()->id)
                                    <button wire:click="updateUser('{{ $user->id }}')" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">@lang('Edit user')</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="w-full flex flex-row justify-start items-center">
                {{ $users->links('pagination::tailwind') }}
            </div>

            <div id="userModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex items-center justify-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                @lang($selectedUser?->id ? 'Update user' : 'Create a new user')
                            </h3>
                            <button wire:click="cancelUser()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        @if($selectedUser)
                            @livewire('users-dialog', ['user' => $selectedUser])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="hidden" data-modal-toggle="userModal" id="toggleUserModal"></button>

    @push('scripts')
        <script>
            window.addEventListener('toggleUserModal', () => {
                const toggleUserModalBtn = document.querySelector('#toggleUserModal');
                toggleUserModalBtn.click();
            });
        </script>
    @endpush
</div>
