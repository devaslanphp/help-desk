<div class="w-full flex flex-col justify-start items-start gap-5">
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Projects')
            </span>
            <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Below is the list of configured projects in :app', [
                    'app' => config('app.name')
                ])
            </span>
        </div>
        @if(has_all_permissions(auth()->user(), 'create-projects'))
            <button type="button" wire:click="createProject()" class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg shadow hover:shadow-lg text-base">
                @lang('Create a new project')
            </button>
        @endif
    </div>
    @if(auth()->user()->favoriteProjects()->count())
        <div class="w-full mt-5 flex flex-col justify-start items-start gap-2">
            <span class="text-lg text-warning-500 font-medium flex flex-row justify-start items-center gap-2">
                <i class="fa fa-star"></i>
                @lang('Favorite projects')
            </span>
            <div class="w-full flex flex-row justify-start items-start flex-wrap -ml-2">
                @foreach(auth()->user()->favoriteProjects as $project)
                    <div class="xl:w-1/5 lg:w-1/4 md:w-1/3 w-1/2 p-2">
                        <div class="w-full flex flex-col gap-1 p-5 border border-gray-100 rounded-lg shadow bg-white hover:shadow-lg">
                            <span class="text-gray-700 font-medium text-base">
                                {{ $project->name }}
                            </span>
                            <span class="text-gray-500 font-light text-sm" style="min-height: 120px;">
                                {{ Str::limit(htmlspecialchars(strip_tags($project->description)), 100) }}
                            </span>
                            <a href="#" class="mt-2 text-primary-500 hover:text-primary-600 font-normal text-sm hover:underline">
                                @lang('View tickets')
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
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
                            @lang('Project name')
                        </th>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Description')
                        </th>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Owner')
                        </th>
                        <th scope="col" class="py-3 px-6 min-w-table">
                            @lang('Tickets')
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
                    @if($projects->count())
                        @foreach($projects as $project)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="py-4 px-6">
                                    <div class="flex flex-row justify-start items-center gap-2">
                                        <button wire:click="toggleFavoriteProject({{ $project }})" type="button" class="{{ $project->favoriteUsers()->where('user_id', auth()->user()->id)->count() ? 'text-warning-500' : 'text-gray-500' }}">
                                            <i class="fa {{ $project->favoriteUsers()->where('user_id', auth()->user()->id)->count() ? 'fa-star' : 'fa-star-o' }}"></i>
                                        </button>
                                        {{ $project->name }}
                                    </div>
                                </th>
                                <td class="py-4 px-6">
                                    {{ Str::limit(htmlspecialchars(strip_tags($project->description)), 50) }}
                                </td>
                                <td class="flex items-center py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <x-user-avatar :user="$project->owner" />
                                    <div class="pl-3">
                                        <div class="text-base font-semibold">{{ $project->owner->name }}</div>
                                        <div class="font-normal text-gray-500">{{ $project->owner->email }}</div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    {{ $project->tickets()->count() }} @lang($project->tickets()->count() > 1 ? 'Tickets' : 'Ticket')
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span class="text-base font-semibold">{{ $project->created_at->diffForHumans() }}</span>
                                        <span class="font-normal text-gray-500">{{ $project->created_at->format(__('Y-m-d g:i A')) }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if(has_all_permissions(auth()->user(), 'update-all-projects') || (has_all_permissions(auth()->user(), 'update-own-projects') && $project->owner_id === auth()->user()->id))
                                        <button wire:click="updateProject('{{ $project->id }}')" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">@lang('Edit project')</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="6" class="py-4 px-6 text-center dark:text-white">
                                @lang('No projects to show!')
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="w-full flex flex-row justify-start items-center">
                {{ $projects->links('pagination::tailwind') }}
            </div>

            <div id="projectModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex items-center justify-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                @lang($selectedProject?->id ? 'Update project' : 'Create a new project')
                            </h3>
                            <button wire:click="cancelProject()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        @if($selectedProject)
                            @livewire('projects-dialog', ['project' => $selectedProject])
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="hidden" data-modal-toggle="projectModal" id="toggleProjectModal"></button>

    @push('scripts')
        <script>
            window.addEventListener('toggleProjectModal', () => {
                const toggleProjectModalBtn = document.querySelector('#toggleProjectModal');
                toggleProjectModalBtn.click();
            });
        </script>
    @endpush
</div>
