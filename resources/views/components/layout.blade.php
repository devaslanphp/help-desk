<x-base-layout>

    @isset($title)
        <x-slot:title>{{$title}}</x-slot:title>
    @endisset

    <div
        class="overflow-hidden absolute w-full h-full top-0 left-0 right-0 bottom-0
        overflow-auto flex flex-row justify-start items-start gap-0"
    >
        <x-main-menu />

        <div class="w-full bg-white h-full xl:p-32 lg:p-22 md:p-18 p-14 my-5 overflow-auto">
            {{$slot}}
        </div>
    </div>


</x-base-layout>
