@if($priority)
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm"
          style="color: {{ $priority->text_color }}; background-color: {{$priority->bg_color}};"
    >
        <em class="fa {{ $priority->icon }}"></em>
        {{ $priority->title }}
    </span>
@endif
