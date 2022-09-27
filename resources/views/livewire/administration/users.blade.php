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
        @can('Create users')
            <button type="button" wire:click="createUser()"
                    class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg
                    shadow hover:shadow-lg text-base">
                @lang('Create a new user')
            </button>
        @endcan
    </div>
    <div class="w-full mt-5">
        <div class="w-full flex flex-col justify-start items-start gap-5">
            <div class="w-full overflow-x-auto relative sm:rounded-lg">
                <div class="w-full overflow-x-auto relative sm:rounded-lg">
                    {{ $this->table }}
                </div>
            </div>

            <div id="userModal" tabindex="-1" aria-hidden="true"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex items-center
                 justify-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-4xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                @lang($selectedUser?->id ? 'Update user' : 'Create a new user')
                            </h3>
                            <button wire:click="cancelUser()" type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                                    rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600
                                    dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        @if($selectedUser)
                            @livewire('administration.users-dialog', ['user' => $selectedUser])
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
