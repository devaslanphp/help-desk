<x-layout>

    <x-slot:title>Tickets</x-slot:title>

    <div class="w-full flex flex-col justify-start items-start gap-5">
        <div class="w-full flex flex-row justify-between items-center">
            <span class="lg:text-4xl md:text-2xl text-xl font-medium text-gray-700">
                @lang('Tickets')
            </span>
            <a href="#" class="bg-primary-700 text-white hover:bg-primary-800 px-4 py-2 rounded-lg shadow hover:shadow-lg text-base">
                @lang('New ticket')
            </a>
        </div>
    </div>

</x-layout>
