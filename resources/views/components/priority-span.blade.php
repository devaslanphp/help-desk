@if($priority && config('system.priorities.' . $priority))
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm {{ __(config('system.priorities.' . $priority . '.bg-color')) }} {{ __(config('system.priorities.' . $priority . '.text-color')) }}">
        <i class="fa {{ config('system.priorities.' . $priority . '.icon') }}"></i>
        {{ __(config('system.priorities.' . $priority . '.title')) }}
    </span>
@endif
