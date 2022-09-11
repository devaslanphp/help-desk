@if($status && config('system.statuses.' . $status))
    <span class="px-3 py-1 rounded-full text-sm {{ __(config('system.statuses.' . $status . '.bg-color')) }} {{ __(config('system.statuses.' . $status . '.text-color')) }}">
        {{ __(config('system.statuses.' . $status . '.title')) }}
    </span>
@endif
