<x-base-layout>

    @isset($title)
        <x-slot:title>{{$title}}</x-slot:title>
    @endisset

    <div class="absolute w-full h-full top-0 left-0 right-0 bottom-0 overflow-hidden">
        <div
            class="absolute lg:w-1/2 md:w-1/3 lg:flex md:flex hidden flex-col justify-start
            items-start top-0 bottom-0 left-0 bg-primary-700 bg-cover bg-no-repeat
            bg-left-bottom bg-opacity-90"
            style="background-image: url('{{ asset('images/help-desk.png') }}'); background-size: 80%">
        </div>
        <div
            class="absolute lg:w-1/2 md:w-2/3 xl:p-44 lg:p-32 md:p-24 p-20 flex flex-col justify-center
            items-center top-0 bottom-0 right-0 bg-white overflow-y-auto"
        >
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="mb-5 w-56" />
            {{$slot}}
        </div>
    </div>

</x-base-layout>
