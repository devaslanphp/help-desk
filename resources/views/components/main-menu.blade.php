<nav
    class="bg-white px-2 sm:px-4 py-2.5 dark:bg-gray-900 fixed w-full z-20 top-0
    left-0 border-b border-gray-200 dark:border-gray-600"
>
    <div class="flex flex-wrap justify-start items-center w-full gap-8 xl:px-32 lg:px-22 md:px-18 px-14">
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" class="mr-3 w-32" alt="{{ config('app.name') }}" />
        </a>
        <div class="flex xl:order-2 ml-auto space-x-2">
            <button
                data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 xl:hidden
                rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200
                dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-sticky" aria-expanded="false"
            >
                <span class="sr-only">Open main menu</span>
                <svg
                    class="w-6 h-6"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd">
                    </path>
                </svg>
            </button>
            <button type="button"
                    class="flex mr-3 text-sm bg-gray-800 rounded-full xl:mr-0 focus:ring-4
                    focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button"
                    aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom"
            >
                <span class="sr-only">Open user menu</span>
                <x-user-avatar :user="auth()->user()" />
            </button>
            <div
                class="hidden z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100
                shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown"
            >
                <div class="py-3 px-4">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                    <span
                        class="block text-sm font-medium text-gray-500
                        truncate dark:text-gray-400">
                        {{ auth()->user()->email }}
                    </span>
                </div>
                <ul class="py-1" aria-labelledby="user-menu-button">
                    <li>
                        <a
                            href="{{ route('my-profile') }}"
                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600
                            dark:text-gray-200 dark:hover:text-white"
                        >
                            @lang('My profile')
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('auth.logout') }}"
                            class="block py-2 px-4 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600
                            dark:text-red-200 dark:hover:text-red-50"
                        >
                            @lang('Sign out')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="hidden justify-between items-center w-full xl:flex xl:w-auto xl:order-1" id="navbar-sticky">
            <ul
                class="flex flex-col p-2 bg-gray-50 rounded-lg border border-gray-100 xl:flex-row xl:space-x-8
                xl:mt-0 xl:text-sm xl:font-medium xl:border-0 xl:bg-white dark:bg-gray-800 xl:dark:bg-gray-900
                dark:border-gray-700"
            >
                @foreach($menu as $value)
                    @if($value['always_shown'] || auth()->user()->hasAnyPermission($value['permissions']))
                        @isset($value['children'])
                            <li>
                                <button id="{{ $value['route'] }}"
                                        data-dropdown-toggle="{{ $value['route'] . '-navbar' }}"
                                        class="relative xl:flex hidden items-center justify-start gap-2
                                        gap-2 py-2 px-3 text-base rounded-lg dark:text-white
                                        {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                                ?
                                                'text-white bg-primary-500 font-medium'
                                                :
                                                'text-gray-500 font-normal hover:bg-gray-100 dark:hover:bg-gray-700'
                                        }}"
                                >
                                    <div class="relative">
                                        <em class="fa {{ $value['icon'] }}"></em>
                                        @if(
                                            $value['show_notification_indicator']
                                            && auth()->user()->unreadNotifications()->count()
                                            )
                                            <em
                                                class="fa fa-circle fa-beat-fade
                                                {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                                    ?
                                                    'text-white'
                                                    :
                                                    'text-primary-500'
                                                }} absolute -right-1"
                                                style="
                                                    font-size: .4rem;
                                                    --fa-beat-fade-opacity: .65;
                                                    --fa-beat-fade-scale: 1.075;"
                                            >
                                            </em>
                                        @endif
                                    </div>
                                    @if((Route::is($value['route']) || Route::is($value['route'] . '.*')))
                                        <span>@lang($value['title'])</span>
                                    @endif
                                </button>
                                <button data-dropdown-toggle="{{ $value['route'] . '-navbar' }}"
                                        class="relative xl:hidden flex items-center justify-start gap-2 py-2 px-3
                                        text-base rounded-lg dark:text-white w-full
                                        {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                                ? 'text-white bg-primary-500 font-medium'
                                                :
                                                'text-gray-500 font-normal hover:bg-gray-100 dark:hover:bg-gray-700'
                                        }}"
                                    >
                                    <div class="relative">
                                        <em class="fa {{ $value['icon'] }}"></em>
                                        @if(
                                            $value['show_notification_indicator']
                                            && auth()->user()->unreadNotifications()->count()
                                            )
                                            <em
                                                class="fa fa-circle fa-beat-fade
                                                {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                                    ?
                                                    'text-white'
                                                    :
                                                    'text-primary-500'
                                                }} absolute -right-1"
                                                style="
                                                    font-size: .4rem;
                                                    --fa-beat-fade-opacity: .65;
                                                    --fa-beat-fade-scale: 1.075;"
                                            >
                                            </em>
                                        @endif
                                    </div>
                                    <span>@lang($value['title'])</span>
                                </button>
                                <div
                                    id="{{ $value['route'] . '-navbar' }}"
                                    class="hidden z-10 w-56 font-normal bg-white rounded divide-y
                                    divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                                >
                                    <ul
                                        class="py-1 text-sm text-gray-700 dark:text-gray-400"
                                        aria-labelledby="dropdownLargeButton"
                                    >
                                        @foreach($value['children'] as $item)
                                            @if(
                                                    $item['always_shown']
                                                    || auth()->user()->hasAnyPermission($item['permissions'])
                                                )
                                                <li class="w-full">
                                                    <a href="{{ route($item['route']) }}"
                                                       class="flex items-center justify-start w-full space-x-2
                                                              block py-2 px-4 hover:bg-gray-100
                                                       {{
                                                            (
                                                                Route::is($item['route'])
                                                                || Route::is($item['route'] . '.*')
                                                            )
                                                            ?
                                                            'text-primary-500 font-medium'
                                                            :
                                                            'text-gray-500'
                                                        }}"
                                                    >
                                                        <em class="w-6 fa {{ $item['icon'] }}"></em>
                                                        <span class="w-full">{{ __($item['title']) }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li>
                                <a
                                    href="{{ route($value['route']) }}"
                                    id="{{ $value['route'] }}"
                                    class="relative xl:flex hidden items-center justify-between
                                    gap-2 py-2 px-3 text-base xl:flex hidden rounded-lg dark:text-white
                                    {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                            ?
                                            'text-white bg-primary-500 font-medium'
                                            :
                                            'text-gray-500 font-normal hover:bg-gray-100 dark:hover:bg-gray-700'
                                    }}"
                                >
                                    <div class="relative">
                                        <em class="fa {{ $value['icon'] }}"></em>
                                        @if(
                                            $value['show_notification_indicator']
                                            && auth()->user()->unreadNotifications()->count()
                                        )
                                            <em
                                                class="fa fa-circle fa-beat-fade
                                                {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                                    ?
                                                    'text-white'
                                                    :
                                                    'text-primary-500'
                                                }} absolute -right-1"
                                                style="
                                                    font-size: .4rem;
                                                    --fa-beat-fade-opacity: .65;
                                                    --fa-beat-fade-scale: 1.075;"
                                            ></em>
                                        @endif
                                    </div>
                                    @if((Route::is($value['route']) || Route::is($value['route'] . '.*')))
                                        <span>@lang($value['title'])</span>
                                    @endif
                                </a>
                                <a
                                    href="{{ route($value['route']) }}"
                                    class="relative xl:hidden flex items-center justify-start gap-2 py-2 px-3
                                    text-base rounded-lg dark:text-white
                                    {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                            ? 'text-white bg-primary-500 font-medium'
                                            :
                                            'text-gray-500 font-normal hover:bg-gray-100 dark:hover:bg-gray-700'
                                    }}"
                                >
                                    <div class="relative">
                                        <em class="fa {{ $value['icon'] }}"></em>
                                        @if(
                                            $value['show_notification_indicator']
                                            && auth()->user()->unreadNotifications()->count()
                                        )
                                            <em
                                                class="fa fa-circle fa-beat-fade
                                                {{ (Route::is($value['route']) || Route::is($value['route'] . '.*'))
                                                    ?
                                                    'text-white'
                                                    :
                                                    'text-primary-500'
                                                }} absolute -right-1"
                                                style="
                                                    font-size: .4rem;
                                                    --fa-beat-fade-opacity: .65;
                                                    --fa-beat-fade-scale: 1.075;"
                                            ></em>
                                        @endif
                                    </div>
                                    <span>@lang($value['title'])</span>
                                </a>
                            </li>
                        @endisset
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                @foreach($menu as $value['route'] => $value)
                    @if(!(Route::is($value['route']) || Route::is($value['route'] . '.*')))
                        window.makeTippy('#{{ $value['route'] }}', '{{ $value['title'] }}');
                    @endif
                @endforeach
            })
        </script>
    @endpush
</nav>
