@if($type && config('system.types.' . $type))
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm {{ __(config('system.types.' . $type . '.bg-color')) }} {{ __(config('system.types.' . $type . '.text-color')) }}">
        <i class="fa {{ config('system.types.' . $type . '.icon') }}"></i>
        {{ __(config('system.types.' . $type . '.title')) }}
    </span>
@endif
