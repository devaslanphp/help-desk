<x-layout>

    <x-slot:title>Tickets - {{ $ticket->title }}</x-slot:title>

    @livewire('ticket-details', ['ticket' => $ticket])

</x-layout>
