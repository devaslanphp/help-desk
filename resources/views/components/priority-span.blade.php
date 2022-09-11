@if($priority && config('system.priorities.' . $priority))
    <span class="px-3 py-1 rounded-full text-sm {{ __(config('system.priorities.' . $priority . '.bg-color')) }} {{ __(config('system.priorities.' . $priority . '.text-color')) }}">
        {{ __(config('system.priorities.' . $priority . '.title')) }}
    </span>
@endif
