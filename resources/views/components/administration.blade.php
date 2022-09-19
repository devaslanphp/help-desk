<div class="w-full flex flex-col gap-8">

    <div class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="w-52 h-36 bg-cover bg-center bg-no-repeat rounded-tl-lg rounded-bl-lg border-r border-gray-200" style="background-image: url('{{ asset('images/administration/users.jpg') }}')"></div>
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-medium tracking-tight text-gray-900 dark:text-white">@lang('User Management')</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">@lang('Here you can show and manage the users list configured on :app', [
                'app' => config('app.name')
            ])</p>
            <div class="w-full flex items-center">
                <a href="{{ route('administration.users') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    @lang('Manage users')
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="w-52 h-36 bg-cover bg-center bg-no-repeat rounded-tl-lg rounded-bl-lg border-r border-gray-200" style="background-image: url('{{ asset('images/administration/workflow.jpg') }}')"></div>
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-medium tracking-tight text-gray-900 dark:text-white">@lang('Statuses Management')</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">@lang('Here you can show and manage the tickets statuses list configured on :app', [
                'app' => config('app.name')
            ])</p>
            <div class="w-full flex items-center">
                <a href="{{ route('administration.ticket-statuses') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    @lang('Manage statuses')
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="w-52 h-36 bg-cover bg-center bg-no-repeat rounded-tl-lg rounded-bl-lg border-r border-gray-200" style="background-image: url('{{ asset('images/administration/priorities.jpg') }}')"></div>
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-medium tracking-tight text-gray-900 dark:text-white">@lang('Priorities Management')</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">@lang('Here you can show and manage the tickets priorities list configured on :app', [
                'app' => config('app.name')
            ])</p>
            <div class="w-full flex items-center">
                <a href="{{ route('administration.ticket-priorities') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    @lang('Manage priorities')
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="w-52 h-36 bg-cover bg-center bg-no-repeat rounded-tl-lg rounded-bl-lg border-r border-gray-200" style="background-image: url('{{ asset('images/administration/types.jpg') }}')"></div>
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-medium tracking-tight text-gray-900 dark:text-white">@lang('Types Management')</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">@lang('Here you can show and manage the tickets types list configured on :app', [
                'app' => config('app.name')
            ])</p>
            <div class="w-full flex items-center">
                <a href="{{ route('administration.ticket-types') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    @lang('Manage types')
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center bg-white rounded-lg border shadow-md md:flex-row w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <div class="w-52 h-36 bg-cover bg-center bg-no-repeat rounded-tl-lg rounded-bl-lg border-r border-gray-200" style="background-image: url('{{ asset('images/administration/activity-logs.jpg') }}')"></div>
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-medium tracking-tight text-gray-900 dark:text-white">@lang('Activity logs')</h5>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">@lang('Here you can see all activity logs of :app', [
                'app' => config('app.name')
            ])</p>
            <div class="w-full flex items-center">
                <a href="{{ route('administration.activity-logs') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    @lang('See details')
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </div>

</div>
