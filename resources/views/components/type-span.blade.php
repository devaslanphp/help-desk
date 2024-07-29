@if($type || $type == "Select new type")
    <span class="px-3 py-1 rounded-full flex flex-row justify-center items-center gap-2 text-sm <?php if($type == "Select new type") { echo 'animate-pulse'; } ?>"
          style="color: {{ $type->text_color ?? '#ffffff'}}; background-color: {{$type->bg_color ?? '#000000'}};">
        @if($type->icon ?? null)
          <em class="fa {{ $type->icon }}"></em>
        @endif
        {{ $type->title ?? "Select new type"}}
    </span>
@endif
