<x-layout>

    <x-slot:title>Administration</x-slot:title>

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
            <a href="#" class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg shadow hover:shadow-lg text-xs">
                @lang('Create a new user')
            </a>
        </div>
        <div class="w-full mt-5">
            @livewire('users')
        </div>
    </div>

</x-layout>
