<x-base-layout>

    @isset($title)
        <x-slot:title>{{$title}}</x-slot:title>
    @endisset

    {{$slot}}

</x-base-layout>
