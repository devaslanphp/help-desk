<x-layout>

    <x-slot:title>Analytics</x-slot:title>
    <div class="relative h-320 w-320">
        <div class="w-full absolute inset-0 -top-12 flex flex-col justify-start items-start gap-5" style="margin-left: 100px;padding: 20px;">
            <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
                <div class="flex flex-col justify-center items-start gap-1">
                    <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                        @lang('Analytics')
                    </span>
                    <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                        @lang('Below is the dashboard containing all analytics related to tickets configured in :app', [
                            'app' => config('app.name')
                        ])
                    </span>
                </div>
            </div>
        @livewire('analytics')
            
            

            
            
        </div>
    </div>
</x-layout>
