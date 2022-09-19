{{-- Injected variables $status, $styles --}}
<div class="{{ $styles['kanbanHeader'] }}" style="color: {{ $status['text-color'] }}; background-color: {{  $status['bg-color'] }};">
    {{ $status['title'] }}
</div>
