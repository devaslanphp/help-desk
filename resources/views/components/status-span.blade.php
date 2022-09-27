@if($status)
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm"
          style="color: {{ $status->text_color }}; background-color: {{$status->bg_color}};">
        {{ $status->title }}
    </span>
@endif
