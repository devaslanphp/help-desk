<x-layout>

    <x-slot:title>Kanban Board</x-slot:title>

    <div class="w-full flex flex-col justify-start items-start gap-5">
        <div class="w-full flex md:flex-row flex-col justify-between items-start gap-2">
            <div class="flex flex-col justify-center items-start gap-1">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Kanban Board')
            </span>
                <span class="lg:text-lg md:text-sm text-xs font-light text-gray-500">
                @lang('Below is the Kanban Board for tickets configured on :app', [
                    'app' => config('app.name')
                ])
            </span>
            </div>
        </div>
        <div class="w-full flex flex-row flex-wrap overflow-x-auto p-0">
            @livewire('kanban')
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('open-ticket', event => {
                window.open(event.detail.url, '_blank').focus();
            })
        </script>
    @endpush

</x-layout>
