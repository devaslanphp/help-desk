<x-layout>

    <x-slot:title>Administration</x-slot:title>

    <div class="w-full flex flex-col justify-start items-start gap-5">
        <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
            <div class="flex flex-col justify-center items-start gap-1">
                <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                    @lang('Administration')
                </span>
                <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                    @lang('Below you can configure the different components of :app', [
                        'app' => config('app.name')
                    ])
                </span>
            </div>
        </div>
        <div class="w-full mt-5">

            <x-administration />

        </div>
    </div>

</x-layout>
