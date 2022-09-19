@if($type)
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm" style="color: {{ $type->text_color }}; background-color: {{$type->bg_color}};">
        <i class="fa {{ $type->icon }}"></i>
        {{ $type->title }}
    </span>
@endif
