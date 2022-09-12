<x-layout>

    <x-slot:title>My profile - {{ auth()->user()->name }}</x-slot:title>

    @livewire('my-profile')

</x-layout>
