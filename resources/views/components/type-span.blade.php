@if($type && config('system.types.' . $type))
    <span class="{{ $min ? 'w-6 h-6 rounded-lg' : 'px-3 py-1 gap-2 rounded-full' }} flex flex-row justify-center items-center text-sm {{ __(config('system.types.' . $type . '.bg-color')) }} {{ __(config('system.types.' . $type . '.text-color')) }}">
        <i class="fa {{ config('system.types.' . $type . '.icon') }}"></i>
        @if(!$min)
            {{ __(config('system.types.' . $type . '.title')) }}
        @endif
    </span>
@endif
