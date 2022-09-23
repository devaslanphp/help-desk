<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} {{ isset($title) ? (' - ' . $title) : '' }}</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    @livewireStyles
    @livewireScripts

</head>
<body>

{{$slot}}

<script src="{{ asset('js/chart.min.js') }}"></script>
@stack('scripts')

@livewire('notifications')
</body>
</html>
