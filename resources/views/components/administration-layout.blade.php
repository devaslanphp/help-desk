<div>
    <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
        <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Administration')
            </span>
        </div>
    </div>
    <div class="w-full flex flex-row flex-wrap border-t border-gray-200 mt-8 pt-3">

        <div class="xl:w-1/5 lg:w-1/4 w-full flex flex-col space-y-5 py-5" wire:ignore>
            @foreach($menu as $item)
                @if(auth()->user()->hasAnyPermission($item['permissions']))
                    <a href="{{ route($item['route']) }}" class="w-full px-5 text-lg hover:text-primary-500 border-l-2 border-transparent {{ (Route::is($item['route']) || Route::is($item['route'] . '.*')) ? 'text-primary-500 font-medium border-primary-500' : 'text-gray-500 font-base hover:border-primary-500' }}">
                        <span>{{ $item['title'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        <div class="xl:w-4/5 lg:w-3/4 w-full flex flex-col gap-2 py-5">
            {{ $slot }}
        </div>
    </div>
</div>
